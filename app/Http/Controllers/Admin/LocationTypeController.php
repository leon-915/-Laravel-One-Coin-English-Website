<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\Admin\LocationType\AddRequest;
use App\Http\Requests\Admin\LocationType\EditRequest;
use App\Models\LocationType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class LocationTypeController extends Controller
{
    public function index()
    {
        return view('admin.location-type.index');
    }

    public function getLocationType()
    {
        $location_type = LocationType::orderBy('id')->get();

        return DataTables::of($location_type)

        ->addIndexColumn()
        /* ->addColumn('action', function ($location_type) {
            $editButton = '';

            $editButton .= '<a href="' . route('admin.location-type.edit', $location_type->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';

            $editButton .= '<a id="' . $location_type->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteStaticPage"
                    data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';

            return $editButton;
        }) */
        ->editColumn('status', function($getstatus) {
            return ($getstatus->status == 1) ?
                '<span class="badge badge-gradient-success badge-pill">Active</span>' :
                '<span class="badge badge-gradient-danger badge-pill">Inactive</span>';
        })
        ->rawColumns([/* 'action', */'status'])

        ->make(true);
    }

    public function create()
    {
        return view('admin.location-type.create');
    }

    public function store(AddRequest $request)
    {
        $input = $request->all();

        LocationType::create($input);

        return redirect()->route('admin.location-type.index')->with('message', 'Location type inserted Successfully');
    }

    public function edit($id)
    {
        $location_types = LocationType::find($id);


        return view('admin.location-type.edit',compact('location_types'));
    }

    public function update(EditRequest $request, $id)
    {
       $input = $request->all();
       $location_type = LocationType::find($id);

       $location_type->update($input);

       return redirect()->route('admin.location-type.index')
                        ->with('message', 'Location Type Updated Successfully');
    }

    public function destroy(Request $request,$id)
    {
       $location_type = LocationType::findOrFail($id);

       if (!empty($location_type)) {

           $location_type->delete();

           $request->session()->flash('message', 'Location Type Deleted Successfully');
           return response()->json(['success' => 'success']);
       }
       else {
           $request->session()->flash('message', 'Location Type not found.');

           return response()->json(['success' => 'success']);
       }
    }
}
