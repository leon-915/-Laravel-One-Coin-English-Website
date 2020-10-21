<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\OnePageLevel\AddRequest;
use App\Http\Requests\Admin\OnePageLevel\EditRequest;
use App\Models\OnePageLevels;
use App\Models\StudentLessons;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class OnePageLevelsController extends Controller
{
    public function index()
    {
        $one_page_levels = OnePageLevels::all();

        return view('admin.one-page-levels.index', compact('one_page_levels'));
    }

    public function getLevels()
    {
        $one_page_levels = OnePageLevels::orderBy('id')->get();

        return DataTables::of($one_page_levels)
            ->addIndexColumn()
            ->addColumn('case', function ($users) {
                return '<input type="checkbox" name="select" value="'.$users->id.'" onclick="checked_chkbx('.$users->id.')"  class="case" id="chk_'. $users->id .'">';
            })
            ->addColumn('action', function ($one_page_levels) {
                $editButton = '';

                $editButton .= '<a href="' . route('admin.one-page-levels.edit', $one_page_levels->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';

                $editButton .= '<a id="' . $one_page_levels->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteOnePageLevel"
                    data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';

                return $editButton;
            })
            ->editColumn('status', function ($getstatus) {
                return ($getstatus->status == 1) ?
                    '<span class="badge badge-gradient-success badge-pill">Active</span>' :
                    '<span class="badge badge-gradient-danger badge-pill">Inactive</span>';
            })
            ->rawColumns(['case','action','status'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.one-page-levels.create');
    }

    public function store(AddRequest $request)
    {
        $input = $request->all();

        OnePageLevels::create($input);

        return redirect()->route('admin.one-page-levels.index')->with('message', 'One Page Level Inserted Successfully');
    }

    public function edit($id)
    {
        $one_page_levels = OnePageLevels::find($id);

        return view('admin.one-page-levels.edit', compact('one_page_levels'));
    }

    public function update(EditRequest $request, $id)
    {
        $input = $request->all();

        $one_page_levels = OnePageLevels::find($id);

        $one_page_levels->update($input);

        return redirect()->route('admin.one-page-levels.index')
            ->with('message', 'One Page Level Updated Successfully');
    }

    public function destroy(Request $request, $id)
    {

        if ($id == 'all') {
            $one_page_levels = OnePageLevels::whereIn('id', $request->id)->get()->pluck('id')->toArray();
            $cnt = 0;
            foreach ($one_page_levels as $level) {
                $student_level_count = StudentLessons::where('student_level_id',$level)->count();
                if(empty($student_level_count)){
                    $one_page_level = OnePageLevels::findOrFail($level);
                    if (!empty($one_page_level)) {
                        $one_page_level->delete();
                        $cnt++;
                    }
                }
            }
            if ($cnt) {
                return response()->json([
                    'success' => 'success',
                    'message' => 'One Page Level Deleted Successfully'
                ]);
            } else {

                if($student_level_count){
                    return response()->json([
                        'success' => 'fail',
                        'message' => 'Cant delete, This level is associated with student lesson'
                    ]);
                } else {
                    return response()->json([
                        'success' => 'fail',
                        'message' => 'One Page Level Not Found'
                    ]);
                }
            }
        } else {

            $student_level_count = StudentLessons::where('student_level_id',$id)->count();
            if(!empty($student_level_count)){
                $request->session()->flash('error', 'Cant delete, This level is associated with student lesson');
                return response()->json(['success' => 'success']);
            } else {
                $one_page_level = OnePageLevels::findOrFail($id);
                if (!empty($one_page_level)) {
                    $one_page_level->delete();
                }
                $request->session()->flash('message', 'One Page Level Deleted Successfully');
                return response()->json(['success' => 'success']);
            }

        }
    }
}
