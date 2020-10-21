<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Badges\AddRequest;
use App\Http\Requests\Admin\Badges\EditRequest;
use App\Models\Badges;
use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class BadgesController extends Controller
{

    public function index()
    {
        return view('admin.badges.index');
    }

    public function getBadges()
    {
        $badges = Badges::orderBy('id')->get();

        return DataTables::of($badges)
            ->addIndexColumn()
            ->addColumn('action', function ($badges) {
                $editButton = '';

                $editButton .= '<a href="' . route('admin.badges.edit', $badges->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';

                $editButton .= '<a id="' . $badges->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteBadges"
                    data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';

                return $editButton;
            })
            ->editColumn('status', function ($getstatus) {
                return ($getstatus->status == 1) ?
                    '<span class="badge badge-gradient-success badge-pill">Active</span>' :
                    '<span class="badge badge-gradient-danger badge-pill">Inactive</span>';
            })
            ->editColumn('image', function ($badges) {
                if ($badges->image) {
                    return '<image src="' . asset($badges->image) . '" height="100" width="100">';
                } else {
                    return '<image src="' . asset('uploads/profile/default.png') . '" height="50" width="50">';
                }
            })
            ->rawColumns(['action', 'image', 'status'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.badges.create');
    }

    public function store(AddRequest $request)
    {
        $input = $request->all();

        if ($request->has('image')) {
            $file = $request->file('image');
            $file_name = time() . $file->getClientOriginalName();
            $input['image'] = $file_name;
            $file_path = 'uploads/badges';
            $move = $file->move($file_path, $file_name);

            if ($move) {
                $input['image'] = $file_path . '/' . $file_name;
            }
        }
        Badges::create($input);
        return redirect()->route('admin.badges.index')->with('message', 'Badge Inserted Successfully');
    }

    public function edit($id)
    {
        $badges = Badges::find($id);

        return view('admin.badges.edit', compact('badges'));
    }

    public function update(EditRequest   $request, $id)
    {
        $input = $request->all();
        $badges = Badges::find($id);

        if ($request->has('image')) {
            $file = $request->file('image');
            $file_name = time() . $file->getClientOriginalName();
            $input['image'] = $file_name;
            $file_path = 'uploads/badges';
            $move = $file->move($file_path, $file_name);

            if(file_exists(public_path($badges->image))){
                File::delete(public_path($badges->image));
            }
            if($move){
                $input['image'] = $file_path.'/'.$file_name;
            }
        }
        $badges->update($input);

        return redirect()->route('admin.badges.index')
            ->with('message', ' Badge Updated Successfully');
    }

    public function destroy(Request $request, $id)
    {
        $badges = Badges::findOrFail($id);

        if (!empty($badges)) {

            if(file_exists(public_path($badges->image))){
                File::delete(public_path($badges->image));
            }

            $badges->delete();

            $request->session()->flash('message', 'Badge Deleted Successfully');
            return response()->json(['success' => 'success']);
        } else {
            $request->session()->flash('message', 'Badge Not Found.');

            return response()->json(['success' => 'success']);
        }
    }
}
