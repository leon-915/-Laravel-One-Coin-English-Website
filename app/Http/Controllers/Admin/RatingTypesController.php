<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\RatingTypes\AddRequest;
use App\Http\Requests\Admin\RatingTypes\EditRequest;
use App\Models\RatingTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class RatingTypesController extends Controller
{
    public function index()
    {
        $rating_types = RatingTypes::all();

        return view('admin.rating-types.index', compact('rating_types'));
    }

    public function getRatingTypes()
    {
        $rating_types = RatingTypes::orderBy('id')->get();

        return DataTables::of($rating_types)
            ->addIndexColumn()
            ->addColumn('case', function ($users) {
                return '<input type="checkbox" name="select" value="'.$users->id.'" onclick="checked_chkbx('.$users->id.')"  class="case" id="chk_'. $users->id .'">';
            })
            ->addColumn('action', function ($rating_types) {
                $editButton = '';

                $editButton .= '<a href="' . route('admin.rating-types.edit', $rating_types->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';

                $editButton .= '<a id="' . $rating_types->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteRatingType"
                    data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';

                return $editButton;
            })
            ->editColumn('status', function ($getstatus) {
                return ($getstatus->status == 1) ?
                    '<span class="badge badge-gradient-success badge-pill">Active</span>' :
                    '<span class="badge badge-gradient-danger badge-pill">Inactive</span>';
            })
            ->rawColumns(['case','action', 'status'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.rating-types.create');
    }

    public function store(AddRequest $request)
    {
        $input = $request->all();

        RatingTypes::create($input);

        return redirect()->route('admin.rating-types.index')->with('message', 'Rating Type Inserted Successfully');
    }

    public function edit($id)
    {
        $rating_types = RatingTypes::find($id);

        return view('admin.rating-types.edit', compact('rating_types'));
    }

    public function update(EditRequest $request, $id)
    {
        $input = $request->all();

        $rating_types = RatingTypes::find($id);

        $rating_types->update($input);

        return redirect()->route('admin.rating-types.index')
            ->with('message', 'Rating Type Updated Successfully');
    }

    public function destroy(Request $request, $id)
    {
        if ($id == 'all') {
            $rating_types = RatingTypes::whereIn('id', $request->id)->get()->pluck('id')->toArray();
            foreach ($rating_types as $type) {
                $rating_type = RatingTypes::findOrFail($type);
                if (!empty($rating_type)) {
                    $rating_type->delete();
                }
            }
            if (!empty($rating_types)) {
                return response()->json([
                    'success' => 'success',
                    'message' => 'Rating Type Deleted Successfully'
                ]);
            } else {
                return response()->json([
                    'success' => 'success',
                    'message' => 'Rating Type Not Found'
                ]);
            }
        } else {
            $rating_types = RatingTypes::findOrFail($id);

            if (!empty($rating_types)) {
                $rating_types->delete();

                $request->session()->flash('message', 'Rating Type Deleted Successfully');
                return response()->json(['success' => 'success']);
            } else {
                $request->session()->flash('message', 'Rating Type Not Found.');

                return response()->json(['success' => 'success']);
            }
        }
    }
}
