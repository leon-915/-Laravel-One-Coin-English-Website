<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\OnePageLevelsPoints\AddRequest;
use App\Http\Requests\Admin\OnePageLevelsPoints\EditRequest;
use App\Models\OnePageLevels;
use App\Models\OnePageLevelsPoints;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class OnePageLevelsPointsController extends Controller
{
    public function index()
    {
        $levels_points = OnePageLevelsPoints::all();

        return view('admin.one-page-levels-points.index', compact('levels_points'));
    }

    public function getLevelsPoints()
    {
        $levels_points = DB::table('one_page_levels_points')
            ->join('one_page_levels' ,'one_page_levels_points.level_id', '=' ,'one_page_levels.id')
            ->select('one_page_levels_points.*','one_page_levels.name as level_name');

        return DataTables::of($levels_points)
            ->addIndexColumn()
            ->addColumn('case', function ($users) {
                return '<input type="checkbox" name="select" value="'.$users->id.'" onclick="checked_chkbx('.$users->id.')"  class="case" id="chk_'. $users->id .'">';
            })
            ->addColumn('action', function ($levels_points) {
                $editButton = '';

                $editButton .= '<a href="' . route('admin.one-page-points.edit', $levels_points->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';

                $editButton .= '<a id="' . $levels_points->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteOnePageLevelsPoints"
                    data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';

                return $editButton;
            })
            ->editColumn('status', function ($getstatus) {
                return ($getstatus->status == 1) ?
                    '<span class="badge badge-gradient-success badge-pill">Active</span>' :
                    '<span class="badge badge-gradient-danger badge-pill">Inactive</span>';
            })
            ->editColumn('level_id', function ($levels_points) {
                return (!empty($levels_points->level_id)) ? $levels_points->level_name : '';
            })

            ->rawColumns(['case','action','status'])
            ->make(true);
    }

    public function create()
    {
        $levels = OnePageLevels::where('status',1)->pluck('name','id');

        $rating_point = array('CA' => 'CA','F&P'=>'F&P','LC'=>'LC','V'=>'V','G&A'=>'G&A');

        return view('admin.one-page-levels-points.create',compact('levels','rating_point'));
    }

    public function store(AddRequest $request)
    {
        $input = $request->all();

        OnePageLevelsPoints::create($input);

        return redirect()->route('admin.one-page-points.index')->with('message', 'One Page Levels Point Inserted Successfully');
    }

    public function edit($id)
    {
        $levels_points = OnePageLevelsPoints::find($id);

        $levels = OnePageLevels::where('status',1)->pluck('name','id');

        $rating_point = array('CA' => 'CA','F&P'=>'F&P','LC'=>'LC','V'=>'V','G&A'=>'G&A');

        return view('admin.one-page-levels-points.edit', compact('levels_points','levels','rating_point'));
    }

    public function update(EditRequest $request, $id)
    {
        $input = $request->all();

        $levels_points = OnePageLevelsPoints::find($id);

        $levels_points->update($input);

        return redirect()->route('admin.one-page-points.index')
            ->with('message', 'One Page Levels Point Updated Successfully');
    }

    public function destroy(Request $request, $id)
    {
        if ($id == 'all') {
            $levels_points = OnePageLevelsPoints::whereIn('id', $request->id)->get()->pluck('id')->toArray();
            foreach ($levels_points as $level) {
                $levels_point = OnePageLevelsPoints::findOrFail($level);
                if (!empty($levels_point)) {
                    $levels_point->delete();
                }
            }
            if (!empty($levels_points)) {
                return response()->json([
                    'success' => 'success',
                    'message' => 'One Page Levels Point Deleted Successfully'
                ]);
            } else {
                return response()->json([
                    'success' => 'success',
                    'message' => 'One Page Levels Point Not Found'
                ]);
            }
        } else {
            $levels_points = OnePageLevelsPoints::findOrFail($id);

            if (!empty($levels_points)) {
                $levels_points->delete();

                $request->session()->flash('message', 'One Page Levels Point Deleted Successfully');
                return response()->json(['success' => 'success']);
            } else {
                $request->session()->flash('message', 'One Page Levels Point Not Found.');

                return response()->json(['success' => 'success']);
            }
        }
    }
}
