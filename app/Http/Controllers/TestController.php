<?php

namespace App\Http\Controllers;

use Newsletter;
use LINEBotTiny;
use Illuminate\Support\Facades\Log;
use App\Helpers\AppHelper;
use App\Helpers\ZohoHelper;
use App\Models\StudentLessonsBooking;
use App\Models\Locations;
use App\Models\Services;
use App\Models\Packages;
use App\Models\ServiceLocations;
use App\Models\TeacherServices;
use App\Models\StudentLessons;
use App\Models\StudentTransactions;
use App\Models\StudentPackages;
use App\Models\StudentLessonsARP;
use App\Models\StudentLessonsCIP;
use App\Models\StudentLessonsKeyword;
use App\Models\StudentLessonsTopic;
use App\Models\StudentLessonsTasks;
use Illuminate\Support\Facades\DB;
use App\Libraries\Ical\iCalEasyReader;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Mail;

use App\User;
use App\Models\StudentDetail;

use App\Models\TeacherIcal;


class TestController extends Controller
{
    public function testWebHook(){


        $channelaccesstoken = '738e45e62d3d3f686efc01dce30912e8';
        $secret  = 'fvf0A/zgsbVhTCuYEwjiDer7EmYh8kith+FZIP6OH9SrB5YXRkdBzI3mMp/3Ntc6CN43OqUlVP0nLxUXsbtAyHQhA8jU4vXNlztK2AoT1pHN6h8sCVISCh8LxbZiTnaU0Mf+8BsD9yOxZzWhM0Q3UAdB04t89/1O/w1cDnyilFU=';

        $client = new LINEBotTiny($channelaccesstoken,$secret);

        //dd($client);
        //dd(get_class_methods($client));
        Log::info('event fired');
        foreach($client->parseEvents() as $event){

            $file = fopen('log.txt','w+');
                 fwrite($file,$event['type']);
            switch  ( $event [ 'type' ])  {

                case  'message' :
                    $message  = $event [ 'message' ];

                     switch  ( $message [ 'type' ])  {
                        Case  'text' :
                            $client -> ReplyMessage ( array (
                                'ReplyToken'  =>  $event [ 'ReplyToken' ],
                                'messages'  =>  array (
                                    array (
                                        'type'  =>  'text' ,
                                        'text'  =>  $message [ 'text' ]
                                    )
                                )
                            ));
                            break ;
                        default :
                            error_log( "Unsupporeted message type:"  .  $message [ 'type' ]);
                            break ;
                    }
                    break ;
                default :
                    error_log ( "Unsupporeted event type:"  .  $event [ 'type' ]);
                    break ;
            }
        }

        // $content = file_get_contents("php://input");

        // $file = fopen('log.txt','w+');
        // fwrite($file,$content);

        // $api = Newsletter::getApi();
        // //dd($api);
        // Newsletter::subscribe('rgthakkar12feb@gmail.com');
         echo "Hello";
        http_response_code(200);
    }
	
	function currenttime() {
		echo date_default_timezone_get();
		echo '<br>';
		echo date('Y-m-d H:i:s');
		echo '<br>';
		echo gmdate('Y-m-d H:i:s');
		$this->testemailattachment();
		exit;
		echo '<br>';
		//'My wife\'s stress level',
		$currenttime = time();
		echo $starttime = $currenttime - (20*60);
		echo '<br>';
		echo $endtime = $currenttime + (20*60);
	}
	
	function testpayout() {
		/*$amount = 750;
		$user_id = 367;
		$lesson_id = 16324;
		$student_name = 'Tatsuya Miyagawa';
		$lesson_date_time = '2019-12-02 19:30';*/
		
		//$amount = isset($_REQUEST['amount']) ? $_REQUEST['amount'] : 0;
		//$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
		$lesson_id = isset($_REQUEST['lesson_id']) ? $_REQUEST['lesson_id'] : 0;
		$studentLesson = StudentLessonsBooking::select([
                'student_lessons_bookings.*',
                DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS student_name"),
            ])
            ->where('student_lessons_bookings.id', $lesson_id)
            ->where('student_lessons_bookings.paid', 0)
            ->leftJoin('users', 'users.id', 'student_lessons_bookings.user_id')
            ->get()->first();

        if (!empty($studentLesson)) {
            $studentLesson = $studentLesson->toArray();
			$amount = $studentLesson['teacher_earnings'];
			$teacher_id = $studentLesson['teacher_id'];
			$student_name = $studentLesson['student_name'];
			$lesson_date_time = $studentLesson['lession_date'].' '.$studentLesson['lession_time'];
        
			echo $amount.'--'.$teacher_id.'--'.$lesson_id.'--'.$student_name.'--'.$lesson_date_time;
			$output = AppHelper::payout($amount, $teacher_id, $student_name, $lesson_date_time);
			echo $payoutBatchId = $output->getBatchHeader()->getPayoutBatchId();
			
			echo '<pre>';
			//print_r($studentLesson);
			print_r($output);
			$booking = StudentLessonsBooking::find($lesson_id);	
			$booking->payment_id = $payoutBatchId;
			$booking->paid = 1;
			$booking->save();
		}
		
	}
	
	function textfb() {
		$page_id = '125587797516968';
		$value = 'a:5:{s:6:"fbPgID";s:15:"125587797516968";s:14:"fbAppAuthToken";s:208:"CAAXX22hfxpMBAPJEQCjEpoZBx4mcZAwG32R20RnDThqSOtpnJWQNvW9NtkbvXwXCBwrewimL4yAPprzIUHywPRhVBZAojVR70Nii4BeckVFdhySczK3nOOF6yBn7bAXc5B5Fr3JzUtTiX0zFQ43UpwYT7dNp6F8gGtmQCZAZCHDAc4YbDwlvvUryXBR17TyWSKaOJeomq4wZDZD";s:17:"page_access_token";s:191:"CAAXX22hfxpMBAFSAqZBw4PWppt6ZCCUlqVcTg8STcRAlySlQVcRZCihMO7wE1951YagCGLhepfZAI5gANQJZBKkDXiuV0ZAZCZA9BvzjiMHW78d12GynZAZBlptgKRAaAZCisdH2NGw3uL7US9oWMTF6mkf5Er63ZAK47ckZCKojPgj1XlpIK8DZBLhxaL";s:7:"user_id";s:17:"10153587110145409";s:11:"app_secrect";s:32:"36b5b23275ee1c933505fe55877fd2c2";}';	
		
		$link = 'https://accent-language.com/team/';
		$photo = 'https://accent-language.com/wp-content/plugins/social-teacher-message/images/logo_new.png';
		
		$page_access_token = 'CAAXX22hfxpMBAFSAqZBw4PWppt6ZCCUlqVcTg8STcRAlySlQVcRZCihMO7wE1951YagCGLhepfZAI5gANQJZBKkDXiuV0ZAZCZA9BvzjiMHW78d12GynZAZBlptgKRAaAZCisdH2NGw3uL7US9oWMTF6mkf5Er63ZAK47ckZCKojPgj1XlpIK8DZBLhxaL';
		$app_secrect = '36b5b23275ee1c933505fe55877fd2c2';
		
		$mssg['access_token'] = $page_access_token;
		$appsecret_proof = hash_hmac('sha256', $mssg['access_token'], $app_secrect);
		$mssg['appsecret_proof'] = $appsecret_proof;
		$mssg['method'] = 'post';
		$mssg['message'] = 'Face book message to post on FB';
		$mssg['name'] = "View the teacher's profile, schedule a lesson or trial lesson."; 
		$mssg['caption'] = 'accent-language.com';
		$mssg['link'] = $link;
		$mssg['description']='';
		$mssg['picture'] = $photo;
		$destURL = "https://graph.facebook.com/$page_id/feed";
		//$responce = file_put_contents( $destURL, array( 'method' => 'POST', 'httpversion' => '1.1', 'timeout' => 45, 'sslverify'=>false, 'redirection' => 0, 'body' => $mssg));
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $destURL);
		curl_setopt($ch, CURLOPT_POST, 1);
		//curl_setopt($ch, CURLOPT_POSTFIELDS,	"method=POST&httpversion=1.1&timeout=45&sslverify=false&redirection=0&body=$mssg");

		// In real life you should use something like:
		 curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array( 'method' => 'POST', 'httpversion' => '1.1', 'timeout' => 45, 'sslverify'=>false, 'redirection' => 0, 'body' => $mssg)));

		// Receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$responce = curl_exec($ch);

		curl_close ($ch);
		echo '<pre>';print_r($responce);echo '</pre>';exit;
	}
	
	function insert_location() {
		
		
		$locations = file_get_contents('http://old.accent-language.com/get_locations.php');
		$locations = json_decode($locations, true);
		//echo '<pre>';print_r($locations);echo '</pre>';exit;
		if(!empty($locations['locationData']) && $locations['success'] == '1') {
			foreach($locations['locationData'] as $location) {
				$data[] = array('title'=>$location['title'], 'title_jp'=>$location['title'], 'location_type'=>'Station', 'status'=>'1', 'accent_location_id'=>$location['accent_location_id']);
				//]break;
			}
		}				
        Locations::insert($data);
	}
	
	
	
	function insert_services() {
		
		
		$services = file_get_contents('http://old.accent-language.com/get_services.php');
		$services = json_decode($services, true);
		//echo '<pre>';print_r($services);echo '</pre>';
		if(!empty($services['servicesData']) && $services['success'] == '1') {
			foreach($services['servicesData'] as $service) {
				//echo '<pre>';print_r($service);echo '</pre>';
				$data = new Services;
				$data->title = $service['title'];
				$data->status = '1';
				$data->price = $service['price'] ? $service['price'] : '0.00';
				$data->length = $service['length']?$service['length']:30;
				$data->length_type = $service['length_type'];
				$data->padding_minutes = $service['padding_minutes'] ? $service['padding_minutes'] : 0;
				$data->padding_type = $service['padding_type'];
				$data->is_system_service = $service['is_system_service'];
							//'receive_credit_on_booking = $service['receive_credit_on_booking'],
							//'receive_credit_on_booking_type = $service['receive_credit_on_booking_type'],
				$data->service_name_en = $service['service_name_en'];
				$data->available_lessons = $service['available_lessons'];
				$data->no_of_days = $service['no_of_days'];
				$data->accent_service_id = $service['accent_service_id'];
				$data->save();
				$service_id = $data->id;
				
				// loop all locations get id and save
				$assigned_locations = $service['assigned_locations'];
				if(!empty($assigned_locations)) {
					foreach($assigned_locations as $assigned_location) {
						$ServiceLocations = new ServiceLocations;
						$locations = Locations::where('accent_location_id', $assigned_location)->get()->first();
						//echo '<pre>';print_r($locations);echo '</pre>';exit;
						if(!empty($locations)) {
							$ServiceLocations->service_id = $service_id;
							$ServiceLocations->location_id = $locations->id;
							$ServiceLocations->is_deleted = '0';
							$ServiceLocations->save();
						}
					}
				}
				
				$assigned_staff = $service['assigned_staff'];
				if(!empty($assigned_staff)) {
					foreach($assigned_staff as $staff) {
						$TeacherServices = new TeacherServices;
						
						$TeacherServices->service_id = $service_id;
						$TeacherServices->teacher_id = $staff;
						$TeacherServices->is_deleted = '0';
						$TeacherServices->save();
					}
				}
				
				//exit;
			}
		}      
	}
	
	function insert_students() {		
		
		$students = file_get_contents('http://old.accent-language.com/get_all_students.php');
		$students = json_decode($students, true);
		//echo '<pre>';print_r($students);echo '</pre>';exit;
		if(!empty($students['studentData']) && $students['success'] == '1') {
			foreach($students['studentData'] as $student) {
				if($student['email'] != 'joomlaphpexpert@gmail.com') {
					
					$data = array(
							'email' => $student['email'],
							'password' => bcrypt(1234567),
							'firstname' => $student['firstname'],
							'lastname' => $student['lastname'],
							'contact_no' => $student['contact_no'],
							'user_type' => 'student',
							//'skype_name' => '',
							//'line_token' => '',
							//'asana_project_id' => '',
							//'send_line_notifications' => '',
							'address' => $student['address'],
							'city' => $student['city'],
							'post_code' => $student['post_code'],
							'country' => $student['country'],							
							'status' => 1,
							'accent_user_id' => $student['accent_user_id'],
						);
					//break;
					//echo '<pre>';print_r($data);echo '</pre>';
					$authUser = User::create($data);
					$studentDetail = StudentDetail::create(['user_id' => $authUser->id, 'credit_balance' => $student['credit_balance'],	'reward_balance' => $student['reward_balance'],]);
					//exit;
				}
			}
		}				
        //Locations::insert($data);
		
	}	
	
	function insert_orders() {		
		
		$offset = isset($_REQUEST['offset']) ? $_REQUEST['offset'] : 0;
		$orders = file_get_contents('http://old.accent-language.com/get_orders_migration.php?offset='.$offset.'');
		$orders = json_decode($orders, true);
		
		//echo '<pre>';print_r($orders);echo '</pre>';exit;
		if(!empty($orders['orderData']) && $orders['success'] == '1') {
			foreach($orders['orderData'] as $order) {
				$transaction_type_id = [];
				$student_lesson_id = [];
				if($order['is_subscription'] == 2 && $order['wp_user_id'] != '') { // regular courses
					
					echo '<pre>';print_r($order);echo '</pre>';
					$accent_user_id = $order['wp_user_id'];
										
					$user_id = User::select('id')
						->where('accent_user_id', $accent_user_id)
						->value('id');
					$order_date = $order['order_date'];	
					$price = $order['order_amount'];
					$order_status = $order['status'];
					$wp_order_id = $order['wp_order_id'];
					$sub_total = $order['sub_total'];
					$tax_amount = $order['tax_amount'];
					$sprice = $sub_total;
					$netAmount = $sprice;
					$tax = 0;
					$temp = 0;
					$tax = $tax_amount;
					if(!empty($tax)){
						$netAmount = $tax + $netAmount;
					}
					
					if(isset($order['order_items_array'][0]['wp_product_id']) && $user_id != '') {
						//echo '<pre>';print_r($order['order_items_array']);echo '</pre>';exit;
						foreach($order['order_items_array'] as $order_items_array) {
							
							$wp_product_id = $order_items_array['wp_product_id'];
							$accent_service_id = $order_items_array['service_id'];
							$service_id = Services::select('id')
									->where('accent_service_id', $accent_service_id)
									->value('id');
									
							if (in_array($wp_product_id, [1709,1711])) { // onepage
								$service_id = 54; //54
							} else if (in_array($wp_product_id, [1708,1710])) { //registration fee
								$service_id = 55; //55
							}
							if($service_id != '' && $service_id > 0) {
								$transaction_type_id[] = $service_id;
							
								$ddl = $order_items_array['ddl'] ? $order_items_array['ddl'] : '0x0x0';
								$ddl=explode('x',$ddl);
								$minutes = $ddl[0];
								$lessons = $ddl[1];
								$days = $ddl[2];
								$expiry_date = strtotime('+'.$days.' days', strtotime($order_date));	
								if (in_array($wp_product_id, [1709,1711])) {
									$expiry_date = strtotime('+1 year', strtotime($order_date));	
								} else if (in_array($wp_product_id, [1708,1710])) {
									$expiry_date = strtotime('+10 year', strtotime($order_date));	
								}							
								
								$studentLesson = [];
								$studentLesson['user_id'] = $user_id;
								$studentLesson['status'] = $order_status == 'completed' ? 1 : 0;
								$studentLesson['service_id'] = $service_id;
								if($order_items_array['free_lessons'] > 0){									
									$studentLesson['available_bookings'] = $lessons + $order_items_array['free_lessons'];
								} else {
									$studentLesson['available_bookings'] = $lessons;
								}
								
								if($order_items_array['rolled_over_lessons'] > 0){									
									$studentLesson['available_bookings'] = $studentLesson['available_bookings'] + $order_items_array['rolled_over_lessons'];
								}
								
								$studentLesson['price'] = $price;
								$studentLesson['start_date'] = $order_date;
								if($order_items_array['course_extension'] > 0) {
									$expire_date = $expiry_date + ($order_items_array['course_extension'] * 86400);
									$studentLesson['expire_date'] = date('Y-m-d', $expire_date);
									
								} else {
									$studentLesson['expire_date'] = date('Y-m-d', $expiry_date);
								}
								$studentLesson['student_level_id'] = 9;
								$studentLesson['free_lessons'] = $order_items_array['free_lessons'];
								$studentLesson['free_lessons2'] = 0;
								
								$studentLesson['rolled_over_lessons'] = $order_items_array['rolled_over_lessons'];
								$studentLesson['rolled_over_lessons2'] = 0;
								
								$studentLesson['show_comment_to_student'] = 2;
								$studentLesson['days_extend'] = $order_items_array['course_extension'];
								$studentLesson['days_extended2'] = 0;
								$studentLesson['accent_order_id'] = $wp_order_id;

								$studentLesson_data = StudentLessons::create($studentLesson);
								$studentLesson_id = $studentLesson_data->id;
								$student_lesson_id[] = $studentLesson_id;
								$student =  User::find($user_id);
								
								
								if (in_array($wp_product_id, [1709,1711])) {
									$student->onepage_start_date = $order_date;
									$onepage_end_date = strtotime('+1 year', strtotime($order_date));	
									$student->onepage_end_date = date('Y-m-d', $onepage_end_date);
									$student->save();
								} else if (in_array($wp_product_id, [1708,1710])) {
									$student->is_registerfee_paid = 1;
									$student->save();
								}
							}
							
						}
						if(count($transaction_type_id) > 0) {
							$studentTransaction = [
								"user_id" => $user_id,
								"provider" => 'cash',
								//"transaction_id" => $charge->balance_transaction,
								//"stripe_customer_id" => $charge->customer,
								"amount" => $netAmount,
								//"stripe_payment_method_id" => $charge->payment_method,
								"transaction_type" => "multi_service",
								"transaction_type_id" => implode(',', $transaction_type_id),
								"payment_status" => $order_status == 'completed' ? 'succeeded' : 'pending',
								//"response" => json_encode($charge),
								"discount" => 0,
								//"coupon_code" => $coupon,
								"subtotal" => $sprice,
								"one_page_fee" => 0,
								"tax" => $tax,
								"student_lesson_id" => implode(',', $student_lesson_id),
								'accent_order_id' => $wp_order_id,
								'created_at' => $order_date.' 00:00:00',
							];

							$savedTransaction = StudentTransactions::create($studentTransaction);
						}
					}
					//exit;				
					
				} else if(1==2 && $order['is_subscription'] == 1 && $order['wp_user_id'] != '') {
					echo '<pre>';print_r($order);echo '</pre>';
					
					$accent_user_id = $order['wp_user_id'];
										
					$user_id = User::select('id')
						->where('accent_user_id', $accent_user_id)
						->value('id');
					
					$studentPackage = StudentPackages::where('user_id',$user_id)->first();
					
					$order_date = $order['order_date'];	
					$price = $order['order_amount'];
					$order_status = $order['status'];
					$wp_order_id = $order['wp_order_id'];
					$sub_total = $order['sub_total'];
					$tax_amount = $order['tax_amount'];
					$sprice = $sub_total;
					$netAmount = $sprice;
					$tax = 0;
					$temp = 0;
					$tax = $tax_amount;
					if(!empty($tax)){
						$netAmount = $tax + $netAmount;
					}
					
					
					if(isset($order['order_items_array'][0]['wp_product_id']) && $user_id != '') {
						
						foreach($order['order_items_array'] as $order_items_array) {
							echo '<pre>';print_r($order);echo '</pre>';
							if(in_array($order_items_array['wp_product_id'], [20497, 20500])) { // power
								$package_id = 27;
							} else if(in_array($order_items_array['wp_product_id'], [20494, 20501])) { //standard
								$package_id = 28;
							} else if(in_array($order_items_array['wp_product_id'], [20493, 20503])) { // light
								$package_id = 29;
							} else if(in_array($order_items_array['wp_product_id'], [20488, 20491])) { // ultra light
								$package_id = 30;
							} else if(in_array($order_items_array['wp_product_id'], [26038, 26034])) { // test subscription
								$package_id = 53;
							}
							
							
							echo $package_id;
							if($package_id > 0 && (!in_array($package_id, [53]))) {
								$package_end_date = $end_date = $order_items_array['expiry_date'];
								//$credit_balance = $order['walletAmount'];
								$start_date = $order['order_date'];
								$package_price = $order['order_amount'];
								$subtotal = $order['sub_total'];
								$tax = $order['tax_amount'];
								$status = $order['status'];
								$student_package_status = strtotime($package_end_date) > time() ? 'active' : 'expired';
								$payment_status = $order['status'] == 'completed' ? 'succeeded' : 'pending';
								$wp_order_id = $order['wp_order_id'];
								if(!empty($studentPackage)){
								
									$studentDetail = StudentDetail::where('user_id',$user_id)->first();
									$studentDetail->current_package_id = $package_id;
									$studentDetail->package_end_date = $package_end_date;
									//$studentDetail->credit_balance = $credit_balance;
									$studentDetail->save() ;

									$studentPackage->package_id = $package_id;
									$studentPackage->start_date =  $start_date;
									$studentPackage->end_date = $end_date;
									$studentPackage->price = $package_price;
									$studentPackage->status = $student_package_status;
									$studentPackage->payment_type = 'paypal';
									$studentPackage->payment_status = $payment_status;
									$studentPackage->accent_order_id = $wp_order_id;
									$studentPackage->save();
								} else {
									 $studentPackage = [
										"user_id"       => $user_id,
										"package_id"    => $package_id,
										"start_date"    => $start_date,
										"end_date"      => $end_date,
										"price"         => $package_price,
										"status"        => $student_package_status,
										"payment_status"        => $payment_status,
										"accent_order_id"        => $wp_order_id
									];
									$studentPackage = StudentPackages::create($studentPackage);

									$studentDetail = StudentDetail::where('user_id',$user_id)->first();
									$studentDetail->current_package_id = $package_id;
									$studentDetail->package_end_date = $package_end_date;
									//$studentDetail->credit_balance = $credit_balance;
									$studentDetail->save() ;

									
								}
							
								$studentTransaction = [
									"user_id" => $user_id,
									"provider" => 'paypal',
									"amount" => $package_price,
									"transaction_type" => "package",
									"transaction_type_id" => $package_id,
									"payment_status" => $payment_status,
									"discount" => 0,
									"subtotal" => $subtotal,
									"one_page_fee" => 0,
									"tax" => $tax,
									"billing_agreement_id" => '',
									"student_package_id" => $package_id,
									'payment_ip' => '',
									'accent_order_id' => $wp_order_id,
									'created_at' => $start_date.' 00:00:00',
								];

								$studentTransaction = StudentTransactions::create($studentTransaction);
							}
							//exit;
						}
					}
				}	
				
			}
		} else {
			echo 'no record found';
		}		
	}		
	
	function migrate_lesson_records() {		
		
		$offset = isset($_REQUEST['offset']) ? $_REQUEST['offset'] : 0;
		$lesson_records = file_get_contents('http://old.accent-language.com/migrate_lesson_records.php?offset='.$offset.'');
		$lesson_records = json_decode($lesson_records, true);
		
		//echo '<pre>';print_r($lesson_records);echo '</pre>';exit;
		if(!empty($lesson_records['lesson_records_data']) && $lesson_records['success'] == '1') {
			foreach($lesson_records['lesson_records_data'] as $lesson_record) {
				$transaction_type_id = [];
				$student_lesson_id = [];				
					
				echo '<pre>';print_r($lesson_record);echo '</pre>';
				$student = $lesson_record['student_id'];									
				$student_id = User::select('id')
					->where('accent_user_id', $student)
					->value('id');
				

				if($lesson_record['teacher_id'] == 1217) {
					$teacher_id = 367;
				} else {
					$teacher_id = 368;
				}	
				
				$service = $lesson_record['service_id'];				
				$service_id = Services::select('id')
					->where('accent_service_id', $service)
					->value('id');

				$location = $lesson_record['location'];				
				$location_id = Locations::select('id')
					->where('title', $location)
					->value('id');			
				$location_id = $location_id == '' ? 583 : $location_id;	
				$lesson_record_id = $lesson_record['lesson_record_id'];	
				$order = $lesson_record['order_id'];	
				$is_subscription = $lesson_record['is_subscription'];
				
				$duration = $lesson_record['duration'];
				$status = $lesson_record['status'];
				$taught_on = $lesson_record['taught_on'];
				$taught_at = $lesson_record['taught_at'];
				$lesson_amount = $lesson_record['lesson_amount'];
				$teacher_amount = $lesson_record['teacher_amount'];
				$booked_on = $lesson_record['booked_on'];
				$arp_data = $lesson_record['arp_data'];
				$ci_data = $lesson_record['ci_data'];
				$kp_data = $lesson_record['kp_data'];
				$or_data = $lesson_record['or_data'];
				
				
				if($is_subscription == 1) {					
					$order_id = StudentTransactions::select('id')
						->where('accent_order_id', $order)
						->value('id');	
				} else {					
					$order_data = StudentLessons::where('accent_order_id', $order)
						->first();
					if(!$order_data){
						continue;
					}	
					$order_id = $order_data->id;	
					$available_bookings = $order_data->available_bookings;
					if($taught_on >= $order_data->start_date && $taught_on <= $order_data->expire_date){
						//$order_data->available_bookings = $order_data->available_bookings - 1;
					}
					$order_data->save();
				}
				
				if($order_id == '') {
					continue;
				}				
				
				if(strtolower($status) == 'scheduled') {
					$lesson_status = 'booked';
				} else if(strtolower($status) == 'completed') {
					$lesson_status = 'completed';
				} else if(strtolower($status) == 'tnoshow') {
					$lesson_status = 'teacher_not_show';
				} else if(strtolower($status) == 'snoshow') {
					$lesson_status = 'student_not_show';
				} else if(strtolower($status) == 'csd') {
					$lesson_status = 'csd';
				} else {
					$lesson_status = 'completed';
				}/* else if(strtolower($status) == 'completed') {
					$lesson_status = 'free_lesson';
				} else if(strtolower($status) == 'completed') {
					$lesson_status = 'cancel';
				}	*/					

				$overall_rating = 0;
				$ca = 0;
				$fp = 0;
				$lc = 0;
				$v = 0;
				$ga = 0;
				$lesson_comment = '';
				$lesson_comment_ja = '';
				$points_to_improve_comment = '';
				$strong_points_comment = '';
				$topic = '';
				$topic_ja = '';
				$previous_topic = '';
				$previous_topic_ja = '';
				$last_ticked_item = '';
				$lessons_matarial_and_tasks_data = '';
				$lesson_tasks_data = '';
				$next_lesson_data = '';
				$student_level_id = 0;
				
				if(!empty($or_data)) {
					foreach($or_data as $or) {						
						$overall_rating = $or['overall_rating'];
						$ca = $or['ca'];
						$fp = $or['fp'];
						$lc = $or['lc'];
						$v = $or['v'];
						$ga = $or['ga'];
						$lesson_comment = $or['lesson_comment'];
						$lesson_comment_ja = $or['lesson_comment_ja'];
						$points_to_improve_comment = $or['points_to_improve_comment'];
						$strong_points_comment = $or['strong_points_comment'];
						$topic = $or['topic'];
						$topic_ja = $or['topic_ja'];
						$previous_topic = $or['previous_topic'];
						$previous_topic_ja = $or['previous_topic_ja'];
						$last_ticked_item = $or['last_ticked_item'];
						$student_level_id = $or['student_level_id'];
						$canvas_html = $or['canvas_html'];
						$lessons_matarial_and_tasks_data = $or['lesson_meta_data'];
						$lesson_tasks_data = $or['current_task_data'];
						$next_lesson_data = $or['next_lesson_data'];
					}
				}
				
				
				$studentBooking = [];
				$studentBooking['user_id'] = $student_id;
				$studentBooking['teacher_id'] = $teacher_id;
				$studentBooking['service_id'] = $service_id;
				$studentBooking['location_id'] = $location_id;
				$studentBooking['lession_date'] = $taught_on;
				$studentBooking['lession_time'] = $taught_at;
				$studentBooking['status'] = $lesson_status;
				$studentBooking['is_student_present'] = strtolower($status) == 'completed' ? 1 : 2;
				$studentBooking['lesson_duration'] = $duration;
				$studentBooking['lession_type'] = 'regular';
				$studentBooking['teacher_earnings'] = $teacher_amount;
				$studentBooking['is_wrapped'] = strtolower($lesson_status) == 'booked' ? 0 : 1;
				$studentBooking['onepage_title'] = date('ymd', strtotime($taught_on));
				$studentBooking['completed_at'] = $taught_on;
				$studentBooking['admin_earnings'] = $lesson_amount;
				$studentBooking['total_earnings'] = $lesson_amount;
				$studentBooking['booking_comments'] = $lesson_comment;
				$studentBooking['onepage_level_id'] = $student_level_id;
				$studentBooking['ca_rating'] = $ca;
				$studentBooking['fp_rating'] = $fp;
				$studentBooking['lc_rating'] = $lc;
				$studentBooking['v_rating'] = $v;
				$studentBooking['ga_rating'] = $ga;
				$studentBooking['points_to_improve_comment'] = $points_to_improve_comment;
				$studentBooking['strong_points_comment'] = $strong_points_comment;
				$studentBooking['accent_lesson_record_id'] = $lesson_record_id;
				//$studentBooking['canvas_html'] = $canvas_html;
				$studentBooking['student_lessons_id'] = $order_id;
				//echo '<pre>';print_r($studentBooking);echo '</pre>';exit;
				$studentBooking_data = StudentLessonsBooking::create($studentBooking);
				$studentBooking_id = $studentBooking_data->id;							
				$arps = [];
				/*if(!empty($arp_data)) {
					foreach($arp_data as $arp) {						
						$arps['student_lesson_id'] = $order_id;
						$arps['line_1'] = $arp['arp1'];
						$arps['line_2'] = $arp['arp2'];
						if($arp['status'] == 1) {
							$status = 2;
						} else if($arp['status'] == 2) {
							$status = 1;
						} else if($arp['status'] == 5) {
							$status = 4;
						} else {
							$status = 3;
						}
						$arps['status'] = $status;
						$arps['lesson_booking_id'] = $studentBooking_id;
						StudentLessonsARP::create($arps);
					}
				}*/
				
				$cis = [];
				if(!empty($ci_data)) {
					foreach($ci_data as $ci) {						
						$cis['student_lesson_id'] = $order_id;
						$cis['correct_phrase'] = $ci['correct_phrase'];
						$cis['incorrect_phrase'] = $ci['incorrect_phrase'];
						if($ci['status'] == 1) { // green O
							$status = 2;
						} else if($ci['status'] == 2) { // red X 
							$status = 1;
						} else if($ci['status'] == 5) { // blue square
							$status = 4;
						} else { // yellow tringle
							$status = 3;
						}
						
						$cis['status'] = $status;
						$cis['lesson_booking_id'] = $studentBooking_id;
						StudentLessonsCIP::create($cis);
					}
				}
				
				$keywords = [];
				if(!empty($kp_data)) {
					foreach($kp_data as $kp) {						
						$keywords['student_lesson_id'] = $order_id;
						$keywords['type'] = $kp['type'] == 'keyword_phrase' ? 'keyphrase' : $kp['type'];
						$keywords['keyword'] = $kp['description'];
						$keywords['keyword_ja'] = $kp['description_ja'];	
						if($kp['status'] == 1) { // green O
							$status = 2;
						} else if($kp['status'] == 2) { // red X 
							$status = 1;
						} else if($kp['status'] == 5) { // blue square
							$status = 4;
						} else { // yellow tringle
							$status = 3;
						}
						$keywords['status'] = $status;				
						$keywords['lesson_booking_id'] = $studentBooking_id;
						StudentLessonsKeyword::create($keywords);
					}
				}
				
				$topics = array_filter(explode(',', $topic));
				if (!empty($topics)) {
                    foreach ($topics as $tkey => $topic) {
                        $ntopic = new StudentLessonsTopic();
                        $ntopic->student_lesson_id = $order_id;
                        $ntopic->lesson_booking_id = $studentBooking_id;
                        $ntopic->title = $topic;
                        $ntopic->save();
                    }
                }
				
				$lessons_matarial_and_tasks_data = explode('~~!', $lessons_matarial_and_tasks_data);
				$LessonsTasks = new StudentLessonsTasks();
				$LessonsTasks->student_lesson_id = $order_id;
				if(!empty($lessons_matarial_and_tasks_data)) {					
					$LessonsTasks->lessons_material_and_tasks_1 = isset($lessons_matarial_and_tasks_data[0]) ? $lessons_matarial_and_tasks_data[0] : '';
					$LessonsTasks->lessons_material_and_tasks_2 = isset($lessons_matarial_and_tasks_data[1]) ? $lessons_matarial_and_tasks_data[1] : '';
					$LessonsTasks->lessons_material_and_tasks_3 = isset($lessons_matarial_and_tasks_data[2]) ? $lessons_matarial_and_tasks_data[2] : '';
				}
				$lesson_tasks_data = explode('~~!', $lesson_tasks_data);
				if(!empty($lesson_tasks_data)) {
					$LessonsTasks->lessons_tasks_1 = isset($lesson_tasks_data[0]) ? $lesson_tasks_data[0] : '';
					$LessonsTasks->lessons_tasks_2 = isset($lesson_tasks_data[1]) ? $lesson_tasks_data[1] : '';
					$LessonsTasks->lessons_tasks_3 = isset($lesson_tasks_data[2]) ? $lesson_tasks_data[2] : '';					
				}
				
				$next_lesson_data = explode('~~!', $next_lesson_data);
				if(!empty($next_lesson_data)) {
					$LessonsTasks->next_lessons_tasks_1 = isset($next_lesson_data[0]) ? $next_lesson_data[0] : '';
					$LessonsTasks->next_lessons_tasks_2 = isset($next_lesson_data[1]) ? $next_lesson_data[1] : '';
					$LessonsTasks->next_lessons_tasks_3 = isset($next_lesson_data[2]) ? $next_lesson_data[2] : '';					
				}
				$LessonsTasks['lesson_booking_id'] = $studentBooking_id;
				$LessonsTasks->save();
				//exit;		
			}
		}		
	}		
	
	function migrate_homework_tasks() {		
		
		$offset = isset($_REQUEST['offset']) ? $_REQUEST['offset'] : 0;
		$homework_tasks = file_get_contents('http://old.accent-language.com/migrate_homework_tasks.php?offset='.$offset.'');
		$homework_tasks = json_decode($homework_tasks, true);
		
		//echo '<pre>';print_r($homework_tasks);echo '</pre>';exit;
		if(!empty($homework_tasks['homework_tasks_data']) && $homework_tasks['success'] == '1') {
			foreach($homework_tasks['homework_tasks_data'] as $lesson_record_id => $homework_task) {
				echo $lesson_record_id;
				echo '<pre>';print_r($homework_task);echo '</pre>';
				//exit;
				
				$StudentLessonsBooking = StudentLessonsBooking::where('accent_lesson_record_id', $lesson_record_id)->first();
				if(!empty($StudentLessonsBooking)){	
					echo $StudentLessonsBooking->id;
					
					$LessonsTasks = StudentLessonsTasks::where('lesson_booking_id', $StudentLessonsBooking->id)->first();
					if(!empty($homework_task)) {					
						$LessonsTasks->homework_lessons_material_and_tasks_1 = isset($homework_task[0]) ? $homework_task[0] : '';
						$LessonsTasks->homework_lessons_material_and_tasks_2 = isset($homework_task[1]) ? $homework_task[1] : '';
						$LessonsTasks->homework_lessons_material_and_tasks_3 = isset($homework_task[2]) ? $homework_task[2] : '';
					}
					$LessonsTasks->save();
				}
				
				
				
				//exit;		
			}
		}		
	}		
	
	function migrate_canvas_data() {		
		
		$offset = isset($_REQUEST['offset']) ? $_REQUEST['offset'] : 0;
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
		$canvas_data = file_get_contents('http://old.accent-language.com/migrate_canvas_data.php?offset='.$offset.'&id='.$id.'');
		$canvas_data = json_decode($canvas_data, true);
		
		//echo '<pre>';print_r($canvas_data);echo '</pre>';exit;
		if(!empty($canvas_data['canvas_data']) && $canvas_data['success'] == '1') {
			foreach($canvas_data['canvas_data'] as $lesson_record_id => $data) {
				echo $lesson_record_id;
				echo '<br>';
				echo '<pre>';print_r($data);echo '</pre>';
				//	exit;
				
				$StudentLessonsBooking = StudentLessonsBooking::where('accent_lesson_record_id', $lesson_record_id)->first();
				if(!empty($StudentLessonsBooking)){		
					echo $StudentLessonsBooking->id;
					echo '<br>';
					
					if(!empty($data[0])) {					
						$StudentLessonsBooking->canvas_html = $data[0];					
					}
					$StudentLessonsBooking->save();
				}
				
				
				
				//exit;		
			}
		}		
	}
			
	
	function migrate_arps_data() {		
		
		$offset = isset($_REQUEST['offset']) ? $_REQUEST['offset'] : 0;
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
		$arps_data = file_get_contents('http://old.accent-language.com/migrate_arps_data.php?offset='.$offset.'&id='.$id.'');
		$arps_data = json_decode($arps_data, true);
		
		//echo '<pre>';print_r($arps_data);echo '</pre>';exit;
		if(!empty($arps_data['arps_data']) && $arps_data['success'] == '1') {
			foreach($arps_data['arps_data'] as $arp_data) {
				echo '<pre>';print_r($arp_data);echo '</pre>';
				$StudentLessonsBooking = StudentLessonsBooking::where('accent_lesson_record_id', $arp_data['accent_lesson_record_id'])->first();	
				$studentBooking_id = $StudentLessonsBooking->id;
				//echo '<br>';
				$order_id = $StudentLessonsBooking->student_lessons_id;
				if(!empty($studentBooking_id)){	
					//echo '<pre>';print_r($studentBooking_id);echo '</pre>';exit;
					$arps['student_lesson_id'] = $order_id;
					$arps['line_1'] = $arp_data['arp1'];
					$arps['line_2'] = $arp_data['arp2'];
					if($arp_data['status'] == 1) {
						$status = 2;
					} else if($arp_data['status'] == 2) {
						$status = 1;
					} else if($arp_data['status'] == 5) {
						$status = 4;
					} else {
						$status = 3;
					}
					$arps['status'] = $status;
					$arps['lesson_booking_id'] = $studentBooking_id;
					StudentLessonsARP::create($arps);
				}
			}
		}		
	}
			
	
	function accent_lesson_record_id() {		
		
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
		if($id > 0) {
		$StudentLessonsBooking = StudentLessonsBooking::where('id', $id)->first();	
			echo $studentBooking_id = $StudentLessonsBooking->accent_lesson_record_id;				
		} else {
			echo 'Id is missing.';
		}
	}		
	
	function delete_arp_data() {		
		
		$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
		$date = isset($_REQUEST['date']) ? $_REQUEST['date'] : 0;
		if($user_id > 0 && $date != '') {
			$StudentLessonsBooking = StudentLessonsBooking::where('user_id', $user_id)
			->whereRaw("lession_date <= '".$date."'::date")
			->orderBy('id', 'DESC')
			->get();	
			$n = 0;
			foreach ($StudentLessonsBooking as $booking) {
				$accent_lesson_record_ids[] = $booking['accent_lesson_record_id'];
				$booking_ids[] = $booking['id'];
				DB::table('student_lessons_active_recall_pairs')->whereIn('lesson_booking_id', $booking_ids)->delete(); 
				
				$n++;
			}			
			if(!is_dir(storage_path('zohoOauth'))) {
				mkdir(storage_path('zohoOauth'));
			}
			file_put_contents(storage_path('zohoOauth/accent_lesson_record_ids.txt'), json_encode($accent_lesson_record_ids));				
		} else {
			echo 'Id is missing.';
		}
	}		
	
	function fill_arp_data() {		
		
		$accent_lesson_record_ids = json_decode(file_get_contents(storage_path('zohoOauth/accent_lesson_record_ids.txt')), true);	
		$n = 0;
		foreach ($accent_lesson_record_ids as $accent_lesson_record_id) {
			if (($key = array_search($accent_lesson_record_id, $accent_lesson_record_ids)) !== false) {
				$arps_data = file_get_contents('http://old.accent-language.com/migrate_arps_data.php?offset=0&id='.$accent_lesson_record_id.'');
				$arps_data = json_decode($arps_data, true);
				
				//echo '<pre>';print_r($arps_data);echo '</pre>';exit;
				if(!empty($arps_data['arps_data']) && $arps_data['success'] == '1') {
					foreach($arps_data['arps_data'] as $arp_data) {
						echo '<pre>';print_r($arp_data);echo '</pre>';
						$StudentLessonsBooking = StudentLessonsBooking::where('accent_lesson_record_id', $arp_data['accent_lesson_record_id'])->first();	
						$studentBooking_id = $StudentLessonsBooking->id;
						//echo '<br>';
						$order_id = $StudentLessonsBooking->student_lessons_id;
						if(!empty($studentBooking_id)){	
							//echo '<pre>';print_r($studentBooking_id);echo '</pre>';exit;
							$arps['student_lesson_id'] = $order_id;
							$arps['line_1'] = $arp_data['arp1'];
							$arps['line_2'] = $arp_data['arp2'];
							if($arp_data['status'] == 1) {
								$status = 2;
							} else if($arp_data['status'] == 2) {
								$status = 1;
							} else if($arp_data['status'] == 5) {
								$status = 4;
							} else {
								$status = 3;
							}
							$arps['status'] = $status;
							$arps['lesson_booking_id'] = $studentBooking_id;
							StudentLessonsARP::create($arps);
						}
					}
				}
				unset($accent_lesson_record_ids[$key]);
			}
			if($n == 4) {
				break;
			}
			$n++;
		}
		$accent_lesson_record_ids = array_values($accent_lesson_record_ids);
		file_put_contents(storage_path('zohoOauth/accent_lesson_record_ids.txt'), json_encode($accent_lesson_record_ids));	
		//echo '<pre>';print_r($accent_lesson_record_ids);
	}
	
	function updategdrive() {
		$drivefolders = AppHelper::getFolders('0B5qI3k-TXY_FZTk1MzY0MGEtMDY2Yi00ZGNhLTllZTgtOGJlNDc3OGZjM2Q3');
		$student = [];
		if(isset($drivefolders->files)) {
			$folders = $drivefolders->files;
			foreach($folders as $folder) {
				$student[$folder->name] = $folder->id;
			}
		}
		
		$all_users = User::All();
		foreach($all_users as $user) {
			$user_id = $user->id;
			$name = $user->firstname.' '.$user->lastname;
			if(isset($student[$name]) && $user->firstname != '') {
				echo $name.'----';
				echo $drive_folder_id = $student[$name];
				echo '<br>';
				$user->drive_folder_id = $drive_folder_id;
				$user->save();
				//exit;
			}
			//exit;
		}
		//echo '<pre>';print_r($all_users);exit;
	}	
	
	function createfolderongdrive()
	{
		$folderId = '0B5qI3k-TXY_FZTk1MzY0MGEtMDY2Yi00ZGNhLTllZTgtOGJlNDc3OGZjM2Q3';//env('MAIN_FOLDER_ID_GDRIVE');
            $name = 'Surinder Kumar';
           echo $fileId = AppHelper::createFolderInFolder($folderId, $name);
	}
	
	function testemail() {
		$student = User::find(363);
		$teacher = User::find(364);
		
		$shareTemplate = "emails.lession-wrap";
		$shareSubject = "Lesson successfully rescheduled for ".$student->firstname .' '. $student->lastname;
		$shareEmail = 'prashant.mishrra@gmail.com';
		$shdata = [
			'student' => $student,
			'teacher' => $teacher,
			'date' => '2019-12-10',
			'time' => '12:00',
			'lesson' =>  'Test Email',
			'location' =>  'Test Email',
                'site_url' => url('/'),
			//'booking' => $booking
		];

	
		Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($shareEmail, $shareSubject) {
			$m->from('info@accent-language.com', 'Accent Schedule');
			$m->to($shareEmail)->subject($shareSubject);					
			$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
		});
		
		$template = "emails.lessionBooking";
        $subject = "Lesson Rescheduled";

        $tdata = [
            'user' => $teacher,
            'student' => $student,
            'teacher' => $teacher,
			'date' => '2019-12-10',
			'time' => '12:00',
			'lesson' =>  'Test Email2',
			'location' =>  'Test Email2',
                'site_url' => url('/'),
        ];
        dispatch(new SendEmailJob($template, $tdata, $subject, 'user'));            
	}
	
	function sendtestlinemessage() {
		AppHelper::sendLineNotification($line_userId = 'Uaeb57c050913b806dbb0751ee1348130', $user_name = 'Prashant Mishra', $service_name = 'Test Service', $location = 'Skype', $datetime = '2019-12-10 14:40', $user_role = 'teacher', $status = 'new');
		
	}
	
	function zoho()
	{
		header('Content-Type: text/html; charset=utf-8');
		$configuration =array(
						"client_id"=>env('ZOHO_CLIENT_ID'),
						"client_secret"=>env('ZOHO_CLIENT_SECRET'),
						"redirect_uri"=>"https://panaceasoftwares.in",
						"currentUserEmail"=>env('BCC_EMAIL'),
						"token_persistence_path" => storage_path('zohoOauth/'),
					); 
		ZCRMRestClient::initialize($configuration); 
		
		
		/*$oAuthClient = ZohoOAuth::getClientInstance(); 
		$refreshToken = "1000.463a1b0fa5b04e5cab2d002e00c4b54a.0ee4bd3ed8be26511e04b50ad6ec1900"; 
		$userIdentifier = env('BCC_EMAIL');//"provide_user_identifier_like_email_here"; 
		$oAuthTokens = $oAuthClient->generateAccessTokenFromRefreshToken($refreshToken,$userIdentifier);
		echo '<pre>';print_r($oAuthTokens);exit;*/
		
		$rest = ZCRMRestClient::getInstance(); // to get the rest client
        //$modules = $rest->getAllModules()->getData(); // to get the the modules in form of ZCRMModule instances array
		$users = $rest->getCurrentUser()->getData(); // to get the users in form of ZCRMUser instances array
		foreach ($users as $userInstance) {
			echo $userInstance->getId(); // to get the user id
			echo '<br>';
			echo $userInstance->getCountry(); // to get the country of the user
			echo '<br>';
			$roleInstance = $userInstance->getRole(); // to get the role of the user in form of ZCRMRole instance
			echo $roleInstance->getId(); // to get the role id
			echo '<br>';
			echo $roleInstance->getName(); // to get the role name
			echo '<br>';
			$profile = $userInstance->getProfile(); // to get the user's profile in form of ZCRMProfile
            echo $profile_id = $profile->getId(); // to get the profile id
			echo '<br>';
            echo $profile_name = $profile->getName();
		}		
	}	
	
	    public function createZohoUser()
		{
			$output = ZohoHelper::createZohoUser('P', 'M', 'testert2ss.panacea@gmail.com');
			echo '<pre>';
			print_r($output);
			
		}
		
		public function createInvoiceItem()
		{
			$jsondata = '{"name": "Standard","rate": "25000","product_type":"service"}';
			$output = ZohoHelper::createInvoiceItem($jsondata);
			if($output['code'] == 0) {
				echo $id = $output['item']['item_id'];
			}
			echo '<pre>';
			print_r($output);
			
		}
				
		public function createInvoiceItemFromDb()
		{
			$item_id = isset($_REQUEST['item_id']) ? $_REQUEST['item_id'] : 0;
			
			if($item_id > 0) {		
				$i=0;
				$services = Services::where('id', $item_id)->where('zoho_item_id', 0)->orderBy('id', 'ASC')->limit(5)->get();
				if(!empty($services)) {
					foreach($services as $service) {
						echo $service_id = $service->id;
						$title = $service->title;
						$price = $service->price;
						echo ' -- ';
						$jsondata = '{"name": '.$title.',"rate": '.$price.',"product_type":"service"}';
						$output = ZohoHelper::createInvoiceItem($jsondata);
						if($output['code'] == 0) {
							echo $id = $output['item']['item_id'];
							$service->zoho_item_id = $id;
							$service->save();
						}
						$i++;
						echo '<br>';
						if($i==5){	
							//exit;		
						}	
					}
				}	
			}				
		}
		
		public function createPackageItemFromDb()
		{
			$item_id = isset($_REQUEST['item_id']) ? $_REQUEST['item_id'] : 0;
			
			if($item_id > 0) {			
				$i=0;
				$packages = Packages::where('id', $item_id)->where('zoho_item_id', 0)->orderBy('id', 'ASC')->limit(5)->get();
				if(!empty($packages)) {
					foreach($packages as $package) {
						echo $package_id = $package->id;
						$title = $package->title;
						$price = $package->price;
						$description = !empty($package->description) ? $package->description : 'Monthly Subscription';
						echo ' -- ';
						$jsondata = '{"name": '.$title.',"rate": '.$price.',"description":'.$description.',"product_type":"service"}';
						$output = ZohoHelper::createInvoiceItem($jsondata);
						if($output['code'] == 0) {
							echo $id = $output['item']['item_id'];
							$package->zoho_item_id = $id;
							$package->save();
						}
						$i++;
						echo '<br>';
						if($i==5){	
							//exit;		
						}	
					}
				}
			}				
		}
				
		public function createInvoiceCustomerFromDb()
		{
			$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
			
			if($user_id > 0) {	
				$i=0;
				$users = User::where('zoho_user_id', 0)->where('id', $user_id)->orderBy('id', 'ASC')->limit(5)->get();
				if(!empty($users)) {
					foreach($users as $user) {
						echo $user_id = $user->id;
						$firstname = $user->firstname ? $user->firstname : '';
						$lastname = $user->lastname ? $user->lastname : '';
						$name = $firstname.' '.$lastname;
						$company_name = $firstname.' '.$lastname;
						
						if($user->firstname_ja != '' && $user->lastname_ja != '') {
							$name = $user->lastname_ja .' '.$user->firstname_ja;
							$firstname = $user->firstname_ja;
							$lastname = $user->lastname_ja;
						}
						
						$email = $user->email ? $user->email : '';
						$phone = $user->contact_no ? $user->contact_no : '';
						
						echo ' -- ';
						$jsondata = '{"contact_name": "'.$name.'","customer_sub_type": "individual","company_name": "'.$company_name.'","contact_persons": [{"email": "'.$email.'","first_name": "'.$firstname.'","last_name": "'.$lastname.'", "phone":"'.$phone.'"}]}';
						$output = ZohoHelper::createInvoiceCustomer($jsondata);
						echo '<pre>';print_r($output);
						if($output['code'] == 0) {
							echo $id = $output['contact']['contact_id'];
							$user->zoho_user_id = $id;
							$user->save();
						}
						$i++;
						echo '<br>';
						if($i==5){	
							//exit;		
						}	
					}
				}
			}				
		}
		
		public function createInvoiceCustomer()
		{
			$jsondata = '{"contact_name": "P M","contact_persons": [{"email": "testert2ss.panacea@gmail.com","first_name": "P","last_name": "M", "phone":"3345435"}]}';
			$output = ZohoHelper::createInvoiceCustomer($jsondata);
			if($output['code'] == 0) {
				echo $user_id = $output['contact']['contact_id'];
				echo '<br>';
				echo $contact_person_id = $output['contact']['contact_persons'][0]['contact_person_id'];
				$jsondata = '{"contact_persons": [{"contact_person_id": '.$contact_person_id.'}]}';
				$enable_output = ZohoHelper::enableportal($jsondata, $user_id);
			}
			echo '<pre>';
			print_r($output);
			print_r($enable_output);
			
		}
		
		public function enableportal()
		{
			$user_id = '2112484000000093002';
			$jsondata = '{"contact_persons": [{"contact_person_id": 2112484000000093004}]}';
			$output = ZohoHelper::enableportal($jsondata, $user_id);
			echo '<pre>';
			print_r($output);
			
		}
		
		public function get_refresh_token() {
			ZohoHelper::get_refresh_token();
		}
		
		public function createInvoice()
		{
			$date = date('Y-m-d');
			$jsondata = '{"customer_id": "2102930000000124001","date": '.$date.',
				"line_items": [
							{
								"item_id": 2102930000000102001,
								"name": "Test Product",
								"rate": 1,
								"quantity": 1,
								"tax_id": 2102930000000071038,
								"tax_name": "Standard",
								"tax_type": "tax",
								"tax_percentage": 10,
								"item_total": 10
							}
						],
				"status":"paid",		
				"payment_options": {
					"payment_gateways": [{
						"configured": true,
						"additional_field1": "standard",
						"gateway_name": "stripe"
						}]
					}}';
			$output = ZohoHelper::createInvoice($jsondata);
			if($output['code'] == 0) {
				echo $id = $output['invoice']['invoice_id'];
			}
			echo '<pre>';
			print_r($output);
			
		}		
		
		public function updateInvoice()
		{
			$date = date('Y-m-d', strtotime('+2 days'));
			$jsondata = '{"customer_id": "2102930000000107002","date": '.$date.',
				"line_items": [
							{
								"item_id": 2102930000000102001,
								"name": "Test Product",
								"rate": 10,
								"quantity": 1,
								"tax_id": 2102930000000071038,
								"tax_name": "消費税",
								"tax_type": "tax",
								"tax_percentage": 10,
								"item_total": 10
							}
						],
				"payment_options": {
					"payment_gateways": [{
						"configured": true,
						"additional_field1": "standard",
						"gateway_name": "paypal"
						}]
					}
				}';
			$output = ZohoHelper::createInvoice($jsondata);
			if($output['code'] == 0) {
				echo $id = $output['invoice']['invoice_id'];
			}
			echo '<pre>';
			print_r($output);
			
		}
				
		
		public function emailInvoice()
		{
			//$jsondata = '{"contacts":[{"contact_id": 2102930000000101002,"email": true,"snail_mail": false}]}';
			$jsondata = '{"send_from_org_email_id": false,"to_mail_ids": ["panacea.test2@gmail.com"],"cc_mail_ids":["phpjoomlawp@gmail.com"]}';
			$invoice_id = '2112484000000071031';
			$output = ZohoHelper::emailInvoice($jsondata, $invoice_id);
			if($output['code'] == 0) {
				echo 'Invoice Sent.';
			}
			echo '<pre>';
			print_r($output);
			
		}
	
	function update_orders_date() {		
		
		$offset = isset($_REQUEST['offset']) ? $_REQUEST['offset'] : 0;
		$orders = file_get_contents('http://old.accent-language.com/get_orders_migration.php?offset='.$offset.'');
		$orders = json_decode($orders, true);
		
		//echo '<pre>';print_r($orders);echo '</pre>';exit;
		if(!empty($orders['orderData']) && $orders['success'] == '1') {
			$i=0;
			foreach($orders['orderData'] as $order) {
				
				if(1==2 && $order['is_subscription'] == 2 && $order['wp_user_id'] != '') { // regular courses
					
					//echo '<pre>';print_r($order);echo '</pre>';
					$accent_user_id = $order['wp_user_id'];
										
					$user_id = User::select('id')
						->where('accent_user_id', $accent_user_id)
						->value('id');
					$order_date = $order['order_date'];					
					$wp_order_id = $order['wp_order_id'];
					$order_date.'--'.$wp_order_id;
					$StudentLessons = StudentLessons::where('accent_order_id', $wp_order_id)->where('user_id',$user_id)->get();
					if(!empty($StudentLessons)) {
						foreach($StudentLessons as $StudentLesson) {
							$StudentLesson->created_at = $order_date;
							$StudentLesson->save();					
							echo $order_date.'--'.$wp_order_id.'--'.$StudentLesson->id;
							echo '<br>';
							$i++;
							
							if($i==2){	
								//exit;		
							}	
						}
					}					
					
				} else if($order['is_subscription'] == 1 && $order['wp_user_id'] != '') {
					//echo '<pre>';print_r($order);echo '</pre>';
					
					$accent_user_id = $order['wp_user_id'];
										
					$user_id = User::select('id')
						->where('accent_user_id', $accent_user_id)
						->value('id');
					
					$order_date = $order['order_date'];	
					$wp_order_id = $order['wp_order_id'];
					
					$studentPackages = StudentPackages::where('accent_order_id', $wp_order_id)->where('user_id',$user_id)->get();
					if(!empty($studentPackages)) {
						foreach($studentPackages as $studentPackage) {
							$studentPackage->created_at = $order_date;
							$studentPackage->save();					
							echo $order_date.'--'.$wp_order_id.'--'.$studentPackage->id;
							echo '<br>';
							$i++;
							
							if($i==2){	
								exit;		
							}	
						}
					}	
				}	
				
			}
		} else {
			echo 'no record found';
		}		
	}	
	
	function getIcalData() {
		$getIcalData = TeacherIcal::all();
		//$getIcalData = TeacherIcal::where('id', 63)->get();

        $finalArray = [];
        $icalArray = [];

        foreach ($getIcalData as $key => $ical2) {
			if($ical2->teacher_id == 368) {
				//continue;
			}
            $url = $ical2->ical_link;
            $rurl = str_ireplace('webcal://', 'http://', $url);

            //$teacherDetail = TeacherDetail::where('user_id', $ical->teacher_id)->first();
            $getData = @file_get_contents($rurl);
            if($getData){
                $ical = new iCalEasyReader();
                $lines = $ical->load($getData);
                $events = $lines['VEVENT'];

                if (count($events) > 0) {
                    $i = 0;
					$newArray = [];
                    foreach ($events as $event) {
                        if(!empty($event['DTSTART']['value'])){
                            $startDate = $event['DTSTART']['value'];
                        } else {
                            $startDate = $event['DTSTART'];
                        }
                        if(!empty($event['DTEND']['value'])){
                            $endDate = $event['DTEND']['value'];
                        } else {
                            $endDate = $event['DTEND'];
                        }

                        $startDate = date('Y-m-d\TH:i:s', strtotime($startDate));
                        $endDate = date('Y-m-d\TH:i:s', strtotime($endDate));

                        /*$newArray[$i]['title'] = 'BLOCKED';
                        $newArray[$i]['teacher'] = $ical2->teacher_id;
                        $newArray[$i]['start'] = $startDate;
                        $newArray[$i]['end'] = $endDate;
                        $newArray[$i]['data'] = '';
                        $newArray[$i]['url'] = '';*/
                        //$newArray[$i]['backgroundColor'] = !empty($teacherDetail->calendar_color) ? $teacherDetail->calendar_color : 'rgba(0, 45, 88, 1)';
						
						$newArray[] = array('title' => 'BLOCKED', 'teacher' => $ical2->teacher_id, 'start' => $startDate, 'end' => $endDate, 'data' => '', 'url' => '', 'backgroundColor' => !empty($teacherDetail->calendar_color) ? $teacherDetail->calendar_color : 'rgba(0, 45, 88, 1)');
                        $i++;
                    }
                    $icalArray = array_merge($icalArray, $newArray);

                }
            }
        }
		echo '<pre>';print_r($icalArray);echo '</pre>';exit;
	}
	
	function fixarp() {
		//select * from student_lessons_active_recall_pairs where lesson_booking_id = 16290 order by id asc
		$booking_id = isset($_REQUEST['booking_id']) ? $_REQUEST['booking_id'] : 16093;
		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 39511;
		$end = isset($_REQUEST['end']) ? $_REQUEST['end'] : 39522;
		$array = [];
		if($booking_id > 0 && $start > 0 && $end > 0) {
			$arpdata = StudentLessonsARP::where('lesson_booking_id', $booking_id)->whereRaw('id >= '.$start)->whereRaw('id <= '.$end)->get();
			if(!empty($arpdata)) {
				$i = 0;
				foreach($arpdata as $arp) {
					if($i == 0) {
						$line_1 = $arp->line_2;
					}
					if($i > 0) {
						$array[$arp->id] = array('line_1'=>$line_1, 'line_2'=>$arp->line_1);
						$line_2 = $arp->line_2;
						$arpline_1 = $arp->line_1;
						
						$arp->line_1 = $line_1;
						$arp->line_2 = $arpline_1;
						$arp->save();
						
						$line_1 = $line_2;
					}
					$i++;
				}
			}
		}
		echo '<pre>';print_r($array);echo '</pre>';exit;
	}
	
	function delete_duplicate_keywords() {
		$booking_id = isset($_REQUEST['booking_id']) ? $_REQUEST['booking_id'] : 0;
		$delete = isset($_REQUEST['delete']) ? $_REQUEST['delete'] : 'no';
		if($booking_id > 0 && $delete == 'yes') {
			$nrd = DB::delete('DELETE FROM student_lessons_keywords a USING student_lessons_keywords b WHERE a.id < b.id AND a.keyword = b.keyword and a.lesson_booking_id = b.lesson_booking_id and a.lesson_booking_id = '.$booking_id.'');
		}
	}
	
	function testgdrive() {
		// send data on google doc for Amany
		$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
		if($user_id > 0) {	
			$i=0;
			$users = User::where('id', $user_id)->whereNull('drive_folder_id')->orderBy('id', 'ASC')->first();
			if(!empty($users) && empty($users->drive_folder_id)) {
				$fname = $users->firstname;
				$lname = $users->lastname;
				echo $fname.' '.$lname;
				$email = $users->email;
				if($fname != '' && $lname != '' && $email != '') {
					$url = 'https://script.google.com/macros/s/AKfycbyCMA9SMh5ZowFcltLr2c4kkPQNZgIeGNPG8jxiLEho7mOsuHpq/exec?fname='.$fname.'&lname='.$lname.'&email='.$email;
					$curl=curl_init();
					curl_setopt($curl, CURLOPT_URL, $url);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);		
					curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
					$res = curl_exec($curl);
					curl_close($curl);	
					$res = json_decode($res);		
					if(!$res->isError)
					{
						echo '<pre>';print_r($res);		
					}
				}
			} else {
				//echo $fname = $users->firstname;
				
				echo '<br>Google drive is already connected.';
			}			
		}		
	}
	
	function getTravelTime() {
		if(isset($_REQUEST['origin']) && isset($_REQUEST['destination'])) {
			$origin  = isset($_REQUEST['origin']) ? urlencode($_REQUEST['origin']) : '';
			$destination = isset($_REQUEST['destination']) ? urlencode($_REQUEST['destination']) : '';
			$travelTime = AppHelper::calculateTravelTime($origin, $destination);
		}
	}
	
	function testemailattachment() {
		$shareTemplate = "emails.lessionBooking";
		$shareSubject = "Lesson successfully booked for Test user";
		$user = User::find(363);
		$teacher = User::find(364);
		$shdata = [
			'student' => $user,
			'teacher' => $teacher,
			'date' => '2020-02-22',
			'time' => '10:00',
			'lesson' =>  'Test',
			'location' => 'Test',
			'site_url' => url('/'),
			'title' => 'New Appointment',
		];
		$ics = 'BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//104.27.189.195//NONSGML kigkonsult.se iCalcreator 2.16.12//
CALSCALE:GREGORIAN
METHOD:PUBLISH
X-WR-CALNAME:
X-WR-CALDESC:料金プラン・恵比寿教室・オンライン・カフェレッスン・オフィス ・Accent英会話
X-FROM-URL:https://accent-language.com
X-WR-TIMEZONE:Asia/Tokyo
BEGIN:VTIMEZONE
TZID:Asia/Tokyo
X-LIC-LOCATION:Asia/Tokyo
BEGIN:STANDARD
DTSTART:19510909T010000
TZOFFSETFROM:+1000
TZOFFSETTO:+0900
TZNAME:JST
END:STANDARD
END:VTIMEZONE
BEGIN:VEVENT
UID:9915669705dbf682f954954.20778547
DTSTAMP:20191103T235215Z
DESCRIPTION:APPOINTMENT DETAILS\nWhat: Cafe 25分 \nWhen: 11月 9\, 2019 16:10 
 \nWhere: スカイプ・Skype \n\nCLIENT DETAILS\nContact: Kazutaka Sodeyama \nNotes
 : Let’s start at 4:30 at a cafe
DTSTART:20191109T071000Z
DTEND:20191109T073500Z
LOCATION:スカイプ・Skype
SUMMARY:Cafe 25分 - Kazutaka Sodeyama
END:VEVENT
END:VCALENDAR
';
		$shareEmail = 'joomlaphpexpert@gmail.com';
		Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($shareEmail, $shareSubject, $ics) {
			$m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
			$m->to($shareEmail)->subject($shareSubject);
			//$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
			$m->attachData($ics, 'appointment.ics', ['mime' => 'application/octet-stream']);
		});
		
	}
}
