<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Categories\AddRequest;
use App\Http\Requests\Admin\Categories\EditRequest;
use App\Models\Categories;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    public function index()
    {
        return view('admin.categories.index');
    }

    public function getCategories() {
        $categories = Categories::All();

        return DataTables::of($categories)
            ->addColumn('case', function ($users) {
                return '<input type="checkbox" name="select" value="'.$users->id.'" onclick="checked_chkbx('.$users->id.')"  class="case" id="chk_'. $users->id .'">';
            })
            ->addColumn('action', function ($categories) {
                $editButton = '';

                $editButton .= '<a href="' . route('admin.categories.edit', $categories->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';

                $editButton .= '<a id="' . $categories->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteService"
                    data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';

                return $editButton;
            })
            ->editColumn('status', function ($getStatus) {
                return ($getStatus->status == 1) ?
                    '<span class="badge badge-gradient-success badge-pill">Active</span>' :
                    '<span class="badge badge-gradient-danger badge-pill">Inactive</span>';
            })
            ->rawColumns(['case','action','status'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(AddRequest $request)
    {
        $input = $request->all();

        $categories = new Categories();
        $categories->title_en = $input['title_en'];
        $categories->title_ja = $input['title_ja'];
        $categories->status = $input['status'];
        $categories->save();
		
        return redirect()->route('admin.categories.index')->with('message', 'Category Inserted Successfully');

    }

    public function edit($id)
    {
        $categories = Categories::find($id);

        return view('admin.categories.edit', compact('categories'));
    }

    public function update(EditRequest $request, $id)
    {
        $input = $request->all();
        
        $categories = Categories::where('id',$id)->first();

        $categoryData = [
            'title_en' => !empty($input['title_en']) ? $input['title_en'] : '',
            'title_ja' => !empty($input['title_ja']) ? $input['title_ja'] : '',
            'status' => !empty($input['status']) ? $input['status'] : 0,
        ];

        $categories->update($categoryData);
    
       
        return redirect()->route('admin.categories.index')
                         ->with('message', 'Category Updated Successfully');
    }

    public function destroy(Request $request, $id)
    {
        if($id == 'all'){
            $categories = Categories::whereIn('id',$request->id)->get()->pluck('id')->toArray();
            foreach ($categories as $category_id){
                $category = categories::findOrFail($category_id);

                if (!empty($category)) {
                    $category->delete();
                }
            }
            if(!empty($categories)){
                return response()->json([
                    'success' => 'success',
                    'message' => 'Category Deleted Successfully.'
                ]);
            } else {
                return response()->json([
                    'success' => 'success',
                    'message' => 'Category not found.'
                ]);
            }
        } else {
            $category = categories::findOrFail($id);

            if (!empty($category)) {
                $category->delete();

                $request->session()->flash('message', 'Category Deleted Successfully');
                return response()->json(['success' => 'success']);
            } else {
                $request->session()->flash('message', 'Category not found.');
                return response()->json(['success' => 'success']);
            }
        }
    }
}
