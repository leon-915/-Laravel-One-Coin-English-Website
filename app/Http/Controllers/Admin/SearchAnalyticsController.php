<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\OnePageLevelsPoints\AddRequest;
use App\Http\Requests\Admin\OnePageLevelsPoints\EditRequest;
use App\Models\SearchAnalytics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SearchAnalyticsController extends Controller
{
    public function index($input = array())
    {
		$from_date = date('Y-m-d', strtotime('-7 days'));
		$end_date = date('Y-m-d');
		
		$from_date = !empty($input['from_date']) ? date('Y-m-d', strtotime($input['from_date'])) : $from_date;
        $to_date = !empty($input['to_date']) ? date('Y-m-d', strtotime($input['to_date'])) : $end_date;
		
		if(isset($_POST['from_date']) && isset($_POST['end_date']))
		{
			$from_date = $_POST['from_date'];
			$end_date = $_POST['end_date'];
		} 
		
		$lessions = SearchAnalytics::select(
                    DB::raw("keyword"),
                    DB::raw("count(*) as count"))
                    ->whereRaw("to_char(searched_on, 'YYYY-MM-DD') between '" . $from_date . "' and'" . $to_date . "'")
                    //->where('status','!=','cancel')
                    ->groupBy('keyword')->get()->pluck('count','keyword')->toArray();

                /*$week = $this->dateRange($from_date,$end_date);*/
	
                $lessionsData = [];
                foreach ($lessions as $key => $day) {
                    $lessionsData['lables'][] = $key;
                    $lessionsData['data'][] = !empty($day) ? (int)$day : 0;
                }
			
        return view('admin.search-analytics.index', compact('lessionsData'));
    }
	
	function search_analytics_download() {
		$searched_data = SearchAnalytics::all();
		
		$teacherKeywrds = SearchAnalytics::select([
				'search_analytics.*',
				DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS user_name"),
				])
				->Join('users', 'users.id', 'search_analytics.user_id')
				->orderBy('search_analytics.id', 'ASC');
		$searched_data = $teacherKeywrds->get();
				
		
		
		
		$csv_output = "Keyword Search Records";
		$csv_output .= "\n";
		$csv_output .= "Serial number, User, Keyword, Date, Count";
		//echo '<pre>';print_r($searched_data);exit;
		$no=1;
		foreach($searched_data as $searched_data) {
			$id 		= $searched_data->id;
			$keyword 	= $searched_data->keyword;
			$date 		= $searched_data->searched_on;
			$count 		= $searched_data->search_count;
			$user_name 		= $searched_data->user_name;
			if($id)
			{
				$csv_output .= "\n";
				$csv_output .= $no.', '.$user_name.', "'.$keyword.'", '.$date.', '.$count.', ';
				$no++;
			}
		}
		$csv_output .= "\n";
		$filename = "searched_keywords_record_till_".date("d-m-Y_H-i",time());
		header("Content-type: application/vnd.ms-excel; charset=utf-8");
		header("Content-disposition: csv" . date("Y-m-d") . ".csv");
		header( "Content-disposition: filename=".$filename.".csv");
		print $csv_output;
		exit;
	}
}
