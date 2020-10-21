<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Services\AddRequest;
use App\Http\Requests\Admin\Services\EditRequest;
use App\Models\Locations;
use App\Models\Packages;
use App\Models\ServiceLocations;
use App\Models\ServiceCategories;
use App\Models\ServicePackages;
use App\Models\Services;
use App\Models\Categories;
use App\Models\TeacherDetail;
use App\Models\TeacherServices;
use App\User;
use App\Helpers\ZohoHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ServicesController extends Controller
{
    public function index()
    {
        return view('admin.services.index');
    }

    public function getService(Request $request) {
        $services = Services::whereRaw('service_type IS NULL')
		->select('services.*');;

        return DataTables::of($services)
		 ->filter(function ($query) use ($request)
            {
                if (!empty($request->get('title'))) {
                    $query->whereRaw("LOWER(services.title) like '%" . strtolower($request->get('title')) . "%'");
                }
                if (!empty($request->get('year')) && $request->get('year') > 2000) {
                    $query->whereRaw('id in (select distinct service_id from student_lessons_bookings where date_part(\'year\', lession_date) = '.$request->get('year').')');
                }
            })
			->addIndexColumn()
            ->addColumn('case', function ($users) {
                return '<input type="checkbox" name="select" value="'.$users->id.'" onclick="checked_chkbx('.$users->id.')"  class="case" id="chk_'. $users->id .'">';
            })
            ->addColumn('action', function ($services) {
                $editButton = '';

                $editButton .= '<a href="' . route('admin.services.edit', $services->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';

                $editButton .= '<a id="' . $services->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteService"
                    data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';

                return $editButton;
            })
            ->editColumn('status', function ($getStatus) {
                return ($getStatus->status == 1) ?
                    '<span class="badge badge-gradient-success badge-pill">Active</span>' :
                    '<span class="badge badge-gradient-danger badge-pill">Inactive</span>';
            })
			
            ->editColumn('padding_minutes', function ($services) {
                return (!empty($services->padding_minutes) ? $services->padding_minutes . ' Minutes' : '-');
            })
            ->editColumn('padding_type', function ($services) {
                if ($services->padding_type == 1) {
                    return 'Before';
                } elseif ($services->padding_type == 2) {
                    return 'After';
                } else {
                    return 'Before & After';
                }
            })
            ->editColumn('flexible_appointment_start_time', function ($services) {
                return (!empty($services->flexible_appointment_start_time) ? $services->flexible_appointment_start_time . ' Minutes' : '-');
            })
            ->editColumn('receive_credit_on_booking_type', function ($services) {
                return (!empty($services->receive_credit_on_booking_type == 1) ? 'Fixed' : 'Percent');
            })
            ->editColumn('prepayment_type', function ($services) {
                if (!empty($services->prepayment_type == 1)) {
                    return 'Fix Booking Fee';
                } elseif (!empty($services->prepayment_type == 2)) {
                    return 'Percent Of Service Value';
                } else {
                    return '-';
                }
            })
            ->editColumn('prepayment', function ($services) {
                if (!empty($services->prepayment)) {
                    if ($services->prepayment_type == 2) {
                        return $services->prepayment . ' %';
                    } else if ($services->prepayment_type == 1) {
                        return '¥ ' . $services->prepayment;
                    }
                }
                return '0';
            })
            ->editColumn('is_system_service', function ($services) {
                return (!empty($services->is_system_service == 1) ? 'Yes' : 'No');
            })
            ->editColumn('no_of_days', function ($services) {
                return (!empty($services->no_of_days) ? $services->no_of_days.' days' : '-');
            })
            ->editColumn('price', function ($services) {
                return (!empty($services->price) ? '¥  '.$services->price: '¥  '.'0');
            })
            ->editColumn('receive_credit_on_booking', function ($services) {
                if (!empty($services->receive_credit_on_booking)) {
                    if ($services->receive_credit_on_booking_type == 2) {
                        return $services->receive_credit_on_booking . ' %';
                    } else if ($services->receive_credit_on_booking_type == 1) {
                        return '¥ ' . $services->receive_credit_on_booking;
                    }
                }
            })
           /* ->editColumn('length', function ($services) {
                return (!empty($services->length ) ? $services->length.' '.$services->length_type: '');
            })*/
            ->rawColumns(['case','action','status'])
            ->make(true);
    }

    public function create()
    {
        $packages = Packages::where('status', 1)->pluck('title', 'id');

        $locations = Locations::where('status', 1)->pluck('title', 'id');		
		$categories = Categories::where('status', 1)->pluck('title_en', 'id');
		
        $teachers = DB::table('users')
                        ->select(DB::raw("CONCAT(firstname, ' ',lastname) AS teacher"),'id')
                        ->where('user_type','teacher')
                        ->where('status', 1)
                        ->pluck('teacher','id');


        $appointment_time = array();
        foreach (range(5, 60, 5) as $time) {
            $appointment_time[$time] = $time . ' Minutes';
        }
        return view('admin.services.create', compact('packages', 'categories', 'locations', 'appointment_time','teachers'));
    }

    public function store(AddRequest $request)
    {
        $input = $request->all();
		$title = $input['title'];
		$price = !empty($input['price']) ? $input['price'] : 0;
		$description = !empty($input['description']) ? $input['description'] : '';

        $service = new Services();
        $service->title = $title;
        $service->description = $description;
        $service->length = $input['length'];
        $service->length_type = $input['length_type'];
        $service->padding_minutes = $input['padding_minutes'];
        $service->padding_type = $input['padding_type'];
        $service->price = $price;
        $service->no_of_days = !empty($input['no_of_days']) ? $input['no_of_days'] : 0;
//        $service->capacity = $input['capacity'];
        $service->is_flexible_appointment_start_time = !empty($input['is_flexible_appointment_start_time']) ? $input['is_flexible_appointment_start_time'] : null;
        $service->flexible_appointment_start_time = !empty($input['flexible_appointment_start_time']) ? $input['flexible_appointment_start_time'] : null;
        $service->is_system_service = !empty($input['is_system_service']) ? $input['is_system_service'] : 2;
        if(!empty($input['is_system_service'])){
            $service->is_available_in_trial = 0;
        }else{
            $service->is_available_in_trial = !empty($input['is_available_in_trial']) ? $input['is_available_in_trial'] : 0;
        }
		
		$service->is_reg_fee_required = !empty($input['is_reg_fee_required']) ? $input['is_reg_fee_required'] : 0;
		$service->is_onepage_fee_required = !empty($input['is_onepage_fee_required']) ? $input['is_onepage_fee_required'] : 0;
        $service->receive_credit_on_booking = $input['receive_credit_on_booking'];
        $service->receive_credit_on_booking_type = $input['receive_credit_on_booking_type'];
        $service->service_name_en = $input['service_name_en'];
        //$service->prepayment_type = !empty($input['prepayment_type']) ? $input['prepayment_type'] : null;
        //$service->prepayment = $input['prepayment'];
        $service->available_lessons = $input['available_lessons'];
        $service->status = $input['status'];
        $service->hide_price = !empty($input['hide_price']) ? $input['hide_price'] : 0;
        //$service->category_ids = !empty($input['category_id']) ? implode(',', $input['category_id']) : '';
        $service->save();
		$service_id = $service->id;
        if ($request->has('category_ids') && !empty($request->category_ids)) {
            $category_ids = $input['category_ids'];
            

            if (!empty($category_ids)) {
                foreach ($category_ids as $category_id) {
                    $category = new ServiceCategories();
                    $category->service_id = $service_id;
                    $category->category_id = $category_id;
                    $category->save();
                }
            }
        }
		
		if ($request->has('location_id') && !empty($request->location_id)) {
            $location_ids = $input['location_id'];

            if (!empty($location_ids)) {
                foreach ($location_ids as $location_id) {
                    $location = new ServiceLocations();
                    $location->service_id = $service_id;
                    $location->location_id = $location_id;
                    $location->save();
                }
            }
        }
        if ($request->has('package_id') && !empty($request->package_id)) {
            $package_ids = $input['package_id'];

            if (!empty($package_ids)) {
                foreach ($package_ids as $package_id) {
                    $package = new ServicePackages();
                    $package->service_id = $service_id;
                    $package->package_id = $package_id;
                    $package->save();
                }
            }
        }
        if ($request->has('teacher_id') && !empty($request->teacher_id)) {
            $teacher_ids = $input['teacher_id'];

            if (!empty($teacher_ids)) {
                foreach ($teacher_ids as $teacher_id) {
                    $teacher = new TeacherServices();
                    $teacher->service_id = $service_id;
                    $teacher->teacher_id = $teacher_id;
                    $teacher->save();
                }
            }
        }
		
		// create zoho 
		if(env('IS_ZOHO_ENABLED') == 1) {
			$jsondata = '{"name": '.$title.',"rate": '.$price.',"description":'.$description.',"product_type":"service", "tax_id":'.config('services.zcrm.zoho_tax_id').'}';
			$output = ZohoHelper::createInvoiceItem($jsondata);
			if($output['code'] == 0) {
				$zoho_item_id = $output['item']['item_id'];
				$services = Services::find($service_id);
				$services->zoho_item_id = $zoho_item_id;
				$services->save();
			}
		}

        return redirect()->route('admin.services.index')->with('message', 'Service Inserted Successfully');

    }

    public function edit($id)
    {
        $services = Services::find($id);

        $service_packages = ServicePackages::where('service_id',$services->id)->where('is_deleted',0)->pluck('package_id')->toArray();
        $service_location = ServiceLocations::where('service_id',$services->id)->where('is_deleted',0)->pluck('location_id')->toArray();
        $teacher_service = TeacherServices::where('service_id',$services->id)->where('is_deleted',0)->pluck('teacher_id')->toArray();
		$service_categories = ServiceCategories::where('service_id',$services->id)->where('is_deleted',0)->pluck('category_id')->toArray();

        $packages = Packages::where('status', 1)->pluck('title', 'id');
        $locations = Locations::where('status', 1)->pluck('title', 'id');		
		$categories = Categories::where('status', 1)->pluck('title_en', 'id');
//        $teachers = User::where('status', 1)->where('user_type','teacher')->pluck('firstname', 'id');
        $teachers = DB::table('users')
            ->select(DB::raw("CONCAT(firstname, ' ',lastname) AS teacher"),'id')
            ->where('user_type','teacher')
            ->where('status', 1)
            ->pluck('teacher','id');

        $appointment_time = array();
        foreach (range(5, 60, 5) as $time) {
            $appointment_time[$time] = $time . ' Minutes';
        }

        return view('admin.services.edit', compact('services', 'categories', 'service_categories', 'packages', 'locations', 'appointment_time','teachers','service_packages','service_location','teacher_service'));
    }

    public function update(EditRequest $request, $id)
    {
        $input = $request->all();
        
        $services = Services::where('id',$id)->first();

        $serviceData = [
            'title' => !empty($input['title']) ? $input['title'] : '',
            'description' => !empty($input['description']) ? $input['description'] : '',
            'length' => !empty($input['length']) ? $input['length'] : null,
            'length_type' => !empty($input['length_type']) ? $input['length_type'] : 1,
            'padding_minutes' => !empty($input['padding_minutes']) ? $input['padding_minutes'] : 0,
            'padding_type' => !empty($input['padding_type']) ? $input['padding_type'] : 1,
            'price' => !empty($input['price']) ? $input['price'] : 0,
            'no_of_days' => !empty($input['no_of_days']) ? $input['no_of_days'] : 0,
            'is_flexible_appointment_start_time' => !empty($input['is_flexible_appointment_start_time']) ? 1 : 2,
            'flexible_appointment_start_time' => !empty($input['flexible_appointment_start_time']) ? $input['flexible_appointment_start_time'] : 0,
            'is_system_service' => !empty($input['is_system_service']) ? 1 : 2,
            'receive_credit_on_booking' => !empty($input['receive_credit_on_booking']) ? $input['receive_credit_on_booking'] : 0,
            'receive_credit_on_booking_type' => !empty($input['receive_credit_on_booking_type']) ? $input['receive_credit_on_booking_type'] : 0,
            'service_name_en' => !empty($input['service_name_en']) ? $input['service_name_en'] : '',
            //'prepayment_type' => !empty($input['prepayment_type']) ? $input['prepayment_type'] : 0,
            //'prepayment' => !empty($input['prepayment']) ? $input['prepayment'] : null,
            'available_lessons' => !empty($input['available_lessons']) ? $input['available_lessons'] : 0,
            'status' => !empty($input['status']) ? $input['status'] : 0,
            'is_available_in_trial' => !empty($input['is_available_in_trial']) ? $input['is_available_in_trial'] : 0,
            'is_reg_fee_required' => !empty($input['is_reg_fee_required']) ? $input['is_reg_fee_required'] : 0,
            'is_onepage_fee_required' => !empty($input['is_onepage_fee_required']) ? $input['is_onepage_fee_required'] : 0,
            'hide_price' => !empty($input['hide_price']) ? $input['hide_price'] : 0,
            //'category_ids' => !empty($input['category_id']) ? implode(',', $input['category_id']) : '',
        ];

        if(!empty($input['is_system_service'])){
            $serviceData['is_available_in_trial'] = 0;
        }

        // if (!empty($input['package_id'])){
        //     $serviceData['no_of_days'] = 0;
        //     $serviceData['available_lessons'] = null;
        // }

        // if (!empty('is_system_service')){
        //     $serviceData['no_of_days'] = 0;
        //     $serviceData['available_lessons'] = null;
        // }

        $services->update($serviceData);
    
        if ($services){

            if (!empty($input['category_id'])){
                $oldCategories = ServiceCategories::where('service_id',$services->id)->pluck('category_id');
                $oldCat = ServiceCategories::where('service_id',$services->id)->get();

                if ($oldCategories){
                    $oldCategories = $oldCategories->toArray();
                }

                $deleteArray = array_diff($oldCategories,$input['category_id']);
                $insertArray = array_diff($input['category_id'],$oldCategories);

                ServiceCategories::where('service_id',$services->id)->whereIn('category_id',$deleteArray)
                                    ->update(['is_deleted' => 1]);

                ServiceCategories::where('service_id',$services->id)->whereNotIn('category_id',$deleteArray)
                    ->update(['is_deleted' => 0]);

                foreach ($insertArray as $Lkey => $category_id){
                    ServiceCategories::create([
                            'service_id' => $services->id,
                            'category_id' => $category_id,
                            'is_deleted' => 0
                    ]);
                }
            } else{
                $oldCategories = ServiceCategories::where('service_id',$services->id)->pluck('category_id');
                if (!empty($oldCategories)){
                    if ($oldCategories){
                        $oldCategories = $oldCategories->toArray();
                    }
                    ServiceCategories::where('service_id',$services->id)
                                    ->whereIn('category_id',$oldCategories)
                                    ->update(['is_deleted' => 1]);
                }
            }
			
			if (!empty($input['location_id'])){
                $oldLocations = ServiceLocations::where('service_id',$services->id)->pluck('location_id');
                $oldLoc = ServiceLocations::where('service_id',$services->id)->get();

                if ($oldLocations){
                    $oldLocations = $oldLocations->toArray();
                }

                $deleteArray = array_diff($oldLocations,$input['location_id']);
                $insertArray = array_diff($input['location_id'],$oldLocations);

                ServiceLocations::where('service_id',$services->id)->whereIn('location_id',$deleteArray)
                                    ->update(['is_deleted' => 1]);

                ServiceLocations::where('service_id',$services->id)->whereNotIn('location_id',$deleteArray)
                    ->update(['is_deleted' => 0]);

                foreach ($insertArray as $Lkey => $location_id){
                    ServiceLocations::create([
                            'service_id' => $services->id,
                            'location_id' => $location_id,
                            'is_deleted' => 0
                    ]);
                }
            } else{
                $oldLocations = ServiceLocations::where('service_id',$services->id)->pluck('location_id');
                if (!empty($oldLocations)){
                    if ($oldLocations){
                        $oldLocations = $oldLocations->toArray();
                    }
                    ServiceLocations::where('service_id',$services->id)
                                    ->whereIn('location_id',$oldLocations)
                                    ->update(['is_deleted' => 1]);
                }
            }

            if (!empty($input['package_id'])){
                $oldPackages = ServicePackages::where('service_id',$services->id)->pluck('package_id');
                $oldPack = ServicePackages::where('service_id',$services->id)->get();

                if ($oldPackages){
                    $oldPackages = $oldPackages->toArray();
                }

                $deleteArray = array_diff($oldPackages,$input['package_id']);
                $insertArray = array_diff($input['package_id'],$oldPackages);

                ServicePackages::where('service_id',$services->id)->whereIn('package_id',$deleteArray)
                    ->update(['is_deleted' => 1]);

                ServicePackages::where('service_id',$services->id)->whereNotIn('package_id',$deleteArray)
                    ->update(['is_deleted' => 0]);

                foreach ($insertArray as $Pkey => $package_id){
                    ServicePackages::create([
                        'service_id' => $services->id,
                        'package_id' => $package_id,
                        'is_deleted' => 0
                    ]);
                }
            } else {
                $oldPackages = ServicePackages::where('service_id',$services->id)->pluck('package_id');
                if (!empty($oldPackages)){
                    if ($oldPackages){
                        $oldPackages = $oldPackages->toArray();
                    }

                    ServicePackages::where('service_id',$services->id)
                        ->whereIn('package_id',$oldPackages)
                        ->update(['is_deleted' => 1]);

                }
            }

            if (!empty($input['teacher_id'])){

                $oldTeachers = TeacherServices::where('service_id',$services->id)->pluck('teacher_id');
                $oldLoc = TeacherServices::where('service_id',$services->id)->get();

                if ($oldTeachers){
                    $oldTeachers = $oldTeachers->toArray();
                }

                $deleteArray = array_diff($oldTeachers,$input['teacher_id']);
                $insertArray = array_diff($input['teacher_id'],$oldTeachers);

                TeacherServices::where('service_id',$services->id)->whereIn('teacher_id',$deleteArray)
                    ->update(['is_deleted' => 1]);

                TeacherServices::where('service_id',$services->id)->whereNotIn('teacher_id',$deleteArray)
                    ->update(['is_deleted' => 0]);

                foreach ($insertArray as $Tkey => $teacher_id){
                    TeacherServices::create([
                        'service_id' => $services->id,
                        'teacher_id' => $teacher_id,
                        'is_deleted' => 0
                    ]);
                }
            }
            else{
                $oldTeachers = TeacherServices::where('service_id',$services->id)->pluck('teacher_id');
                if (!empty($oldTeachers)){

                    if ($oldTeachers){
                        $oldTeachers = $oldTeachers->toArray();
                    }
                    TeacherServices::where('service_id',$services->id)
                        ->whereIn('teacher_id',$oldTeachers)
                        ->update(['is_deleted' => 1]);
                }
            }
        }
        return redirect()->route('admin.services.index')
                         ->with('message', 'Service Updated Successfully');
    }

    public function destroy(Request $request, $id)
    {
        if($id == 'all'){
            $services = Services::whereIn('id',$request->id)->get()->pluck('id')->toArray();
            foreach ($services as $service_id){
                $service = Services::findOrFail($service_id);

                if (!empty($service)) {
                    $service->delete();
                }
            }
            if(!empty($services)){
                return response()->json([
                    'success' => 'success',
                    'message' => 'Service Deleted Successfully.'
                ]);
            } else {
                return response()->json([
                    'success' => 'success',
                    'message' => 'Service not found.'
                ]);
            }
        } else {
            $service = Services::findOrFail($id);

            if (!empty($service)) {
                $service->delete();

                $request->session()->flash('message', 'Service Deleted Successfully');
                return response()->json(['success' => 'success']);
            } else {
                $request->session()->flash('message', 'Service not found.');
                return response()->json(['success' => 'success']);
            }
        }
    }
}
