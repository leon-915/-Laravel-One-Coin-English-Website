<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AppHelper;
use App\Http\Requests\Admin\Packages\AddRequest;
use App\Http\Requests\Admin\Packages\EditRequest;
use App\Models\Packages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class PackagesController extends Controller
{
    public function index() {
        return view('admin.packages.index');
    }

    public function getPackage() {
        $packages = Packages::orderBy('id')->get();

        return DataTables::of($packages)

            ->addIndexColumn()
            ->addColumn('case', function ($users) {
                return '<input type="checkbox" name="select" value="'.$users->id.'" onclick="checked_chkbx('.$users->id.')"  class="case" id="chk_'. $users->id .'">';
            })
            ->addColumn('action',function ($packages){

                $editButton = '';

                $editButton .= '<a href="' . route('admin.packages.edit', $packages->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';

                $editButton .= '<a id="' . $packages->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deletePackage"
                    data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';

                return $editButton;
            })
            ->editColumn('status',function ($getStatus){
                return ($getStatus->status == 1) ?
                    '<span class="badge badge-gradient-success badge-pill">Active</span>' :
                    '<span class="badge badge-gradient-danger badge-pill">Inactive</span>';
            })
            ->editColumn('price',function ($packages){
                return ($packages->price) ? '¥ '. $packages->price : '¥ '.'0';
            })
            ->editColumn('registration_fee',function ($packages){
                return ($packages->registration_fee) ? '¥ '. $packages->registration_fee : '¥ '.'0';
            })
            ->editColumn('onepage_fee',function ($packages){
                return ($packages->onepage_fee) ? '¥ '. $packages->onepage_fee : '¥ '.'0';
            })
            ->editColumn('duration_of_lesson',function ($packages){
                return ($packages->duration_of_lesson) ? $packages->duration_of_lesson .'  Minute' : '';
            })
            ->rawColumns(['case','action','status'])
            ->make(true);
    }

    public function create() {
       return view('admin.packages.create');
    }

    public function store(AddRequest $request) {
        $input = $request->all();

        $package = Packages::create($input);

        $id = $package->id;

        $packageData = Packages::find($id);

        $patchedPlan = AppHelper::createPlan([
            'id' => $id,
            'name' => $input['title'],
            'description' => json_encode($packageData->toArray()),
            'amount' => round($input['price']),
        ]);

        $packageData->paypal_plan_id = $patchedPlan->getId();
        $packageData->paypal_response = $patchedPlan->toJSON();
        $packageData->save();

       return redirect()->route('admin.packages.index')->with('message', 'Package inserted Successfully');
    }

    public function edit($id) {
        $packages = Packages::find($id);
        return view('admin.packages.edit',compact('packages'));
    }

    public function update(EditRequest $request, $id) {
        $input = $request->all();

        $package = Packages::find($id);

        $package->update($input);

        $package = Packages::find($id);

        // $patchedPlan = AppHelper::createPlan([
        //     'id' => $id,
        //     'name' => $input['title'],
        //     'description' => json_encode($package->toArray()),
        //     'amount' => $input['price'],
        // ]);

        // $package->paypal_plan_id = $patchedPlan->getId();
        // $package->paypal_response = $patchedPlan->toJSON();
        // $package->save();

        return redirect()->route('admin.packages.index')
                         ->with('message', 'Package Updated Successfully');
    }

    public function destroy(Request $request,$id) {
        if($id == 'all'){
            $packages = Packages::whereIn('id',$request->id)->get()->pluck('id')->toArray();
            foreach ($packages as $package_id){
                $package = Packages::findOrFail($package_id);
                if (!empty($package)) {
                    $package->delete();
                }
            }
            if(!empty($packages)){
                return response()->json([
                    'success' => 'success',
                    'message' => 'Package Deleted Successfully.'
                ]);
            } else {
                return response()->json([
                    'success' => 'success',
                    'message' => 'Package not found.'
                ]);
            }

        } else {

            $package = Packages::findOrFail($id);

            if (!empty($package)) {

                $package->delete();

                $request->session()->flash('message', 'Package Deleted Successfully');
                return response()->json(['success' => 'success']);
            }
            else {
                $request->session()->flash('message', 'Package not found.');
                return response()->json(['success' => 'success']);
            }
        }

    }
}
