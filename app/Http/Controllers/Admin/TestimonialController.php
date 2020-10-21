<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Testimonial\AddRequest;
use App\Http\Requests\Admin\Testimonial\EditRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class TestimonialController extends Controller
{
    public function index()
    {
        return view('admin.testimonial.index');
    }

    public function getTestimonial()
    {
        $testimonial = Testimonial::orderBy('id')->get();

        return DataTables::of($testimonial)
            ->addIndexColumn()
            ->addColumn('action', function ($testimonial) {
                $editButton = '';

                $editButton .= '<a href="' . route('admin.testimonial.edit', $testimonial->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';

                $editButton .= '<a id="' . $testimonial->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteTestimonial"
                    data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';

                return $editButton;
            })
            ->editColumn('status', function ($getstatus) {
                return ($getstatus->status == 1) ?
                    '<span class="badge badge-gradient-success badge-pill">Active</span>' :
                    '<span class="badge badge-gradient-danger badge-pill">Inactive</span>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.testimonial.create');
    }

    public function store(AddRequest $request)
    {
        $input = $request->all();

        Testimonial::create($input);

        return redirect()->route('admin.testimonial.index')->with('message','Testimonial Created Successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $testimonial = Testimonial::find($id);

        return view('admin.testimonial.edit',compact('testimonial'));
    }

    public function update(EditRequest $request, $id)
    {
        $input = $request->all();

        $testimonial = Testimonial::find($id);

        $testimonial->update($input);

        return redirect()->route('admin.testimonial.index')->with('message','Testimonial Updated Successfully');
    }

    public function destroy(Request $request,$id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if (!empty($testimonial)){

            $testimonial->delete();

            $request->session()->flash('message', 'Testimonial Deleted Successfully');
            return response()->json(['success' => 'success']);
        }
        else {
            $request->session()->flash('message', 'Testimonial Not Found');
            return response()->json(['success' => 'success']);
        }
    }
}
