<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use View;
use File;
use DB;
use Hash;
use Yajra\Datatables\Datatables;
use Auth;
use App\Http\Requests\Admin\StaticPages\AddRequest;
use App\Http\Requests\Admin\StaticPages\EditRequest;

class StaticPageController extends Controller
{
    public function index(Request $request) {

		return view('admin.static-pages.index');
	}

	public function getStaticPages(Request $request)
    {
        $static = StaticPage::orderBy('id')->get();

        return DataTables::of($static)
        	->addIndexColumn()
            ->addColumn('action', function ($static) {
                $editButton = '';

                $editButton .= '<a href="' . route('admin.static-pages.edit', $static->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';

                $editButton .= '<a id="' . $static->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteStaticPage"
                    data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';

                return $editButton;
            })
           	->rawColumns(['action'])
			->make(true);
    }

    public function create() {
		return view('admin.static-pages.create');
	}

	public function store(AddRequest $request) {
		$input = $request->all();

		$page_exists = StaticPage::where('page_name', $input['page_name'])->count();

        if ($page_exists == 1) {
            return redirect(route('static-pages.create'))->withErrors("Page already exists");
        }
        else{
       		$insertData = [
				'page_name' 		=> !empty($input['page_name']) ? $input['page_name'] : '',
				'title' 			=> !empty($input['title']) ? $input['title'] : '',
				'meta_keyword'  	=> !empty($input['meta_keyword']) ? $input['meta_keyword'] : '',
				'meta_description' 	=> !empty($input['meta_description']) ? $input['meta_description'] : '',
				'body' 				=> !empty($input['body']) ? $input['body'] : '',
			];

			$staticPage = StaticPage::create($insertData);

			return redirect()->route('static-pages.index')->with('message', 'Static page inserted Successfully');
        }
	}

	public function edit($id)
    {
        $page = StaticPage::find($id);

        return view('admin.static-pages.edit', compact('page'));
    }

    public function update(EditRequest $request, $id)
    {
        $input = $request->all();
        $static = StaticPage::find($id);
        $page_exists = StaticPage::where('page_name', $input['page_name'])->count();

        if ($static->page_name != $input['page_name'] && $page_exists == 1) {
            return redirect(route('static-pages.edit',$id))->withErrors("Page already exists");
        }
        else {
            $static->update($input);
        }

        return redirect()->route('static-pages.index')->with('message', 'Static Page Updated Successfully');
    }

    public function destroy(Request $request, $id)
    {
        $static = StaticPage::findOrFail($id);
        if (!empty($static)) {
           $static->delete();
            $request->session()->flash('message', 'Static Page Deleted Successfully');
            return response()->json([
                'success' => 'success'
            ]);
        }
        else {
            $request->session()->flash('message', 'Static page not found.');
            return response()->json([
                'success' => 'success'
            ]);
        }
    }

}
