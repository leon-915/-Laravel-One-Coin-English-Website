<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Location\AddRequest;
use App\Http\Requests\Admin\Location\EditRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Locations;
use App\Models\LocationType;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class LocationsController extends Controller
{
    public function index()
    {
        $location_type_list = LocationType::pluck('title', 'title')->toArray();

        return view('admin.locations.index',compact('location_type_list'));
    }

    public function getLocation(Request $request) {

        $location = DB::table('location')
            ->leftJoin('countries', 'location.country', 'countries.id')
            ->leftJoin('states', 'location.state', 'states.id')
            ->leftJoin('cities', 'location.city', 'cities.id')
            ->select('location.*', 'countries.name as country_name', 'states.name as state_name', 'cities.name as city_name');

        return DataTables::of($location)
            ->filter(function ($query) use ($request)
            {
                if (!empty($request->get('title'))) {
                    $query->whereRaw("LOWER(location.title) like '%" . strtolower($request->get('title')) . "%'");
                }
                if (!empty($request->get('location_type'))) {
                    $query->whereRaw("LOWER(location.location_type) like '%" . strtolower($request->get('location_type')) . "%'");
                }
            })
            ->addIndexColumn()
            ->addColumn('case', function ($users) {
                return '<input type="checkbox" name="select" value="'.$users->id.'" onclick="checked_chkbx('.$users->id.')"  class="case" id="chk_'. $users->id .'">';
            })
            ->addColumn('action', function ($location) {
                $editButton = '';

                $editButton .= '<a href="' . route('admin.locations.edit', $location->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';

                $editButton .= '<a id="' . $location->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteLocations"
                data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';

                return $editButton;
            })
            ->editColumn('status', function ($getstatus) {
                return ($getstatus->status == 1) ?
                    '<span class="badge badge-gradient-success badge-pill">Active</span>' :
                    '<span class="badge badge-gradient-danger badge-pill">Inactive</span>';
            })
            ->editColumn('country', function ($location) {
                return (!empty($location->country)) ? $location->country_name : '--';
            })
            ->editColumn('state', function ($location) {
                return (!empty($location->state)) ? $location->state_name : '--';
            })
            ->editColumn('city', function ($location) {
                return (!empty($location->city)) ? $location->city_name : '--';
            })
            ->editColumn('phone_no', function ($location) {
                return (!empty($location->phone_no)) ? $location->phone_no : '--';
            })
            ->editColumn('address', function ($location) {
                return (!empty($location->address)) ? $location->address : '--';
            })
            ->editColumn('zipcode', function ($location) {
                return (!empty($location->zipcode)) ? $location->zipcode : '--';
            })
            ->rawColumns(['case','action','status'])
            ->make(true);
    }

    public function create() {
        $country_list = Country::all()->pluck('name', 'id')->toArray();

        // $state_list = State::all()->pluck('name', 'id')->toArray();
        // $city_list = City::all()->pluck('name', 'id')->toArray();

        $location_type_list = LocationType::where('status', 1)->pluck('title', 'title')->toArray();

        return view('admin.locations.create', compact('country_list', 'location_type_list'));
    }

    public function store(AddRequest $request)
    {
        $input = $request->all();

        Locations::create($input);

        return redirect()->route('admin.locations.index')->with('message', 'Location inserted Successfully');
    }

    public function edit($id)
    {
        $locations = Locations::find($id);

        $country_list = Country::all()->pluck('name', 'id')->toArray();

        $state_list = State::where('country_id', $locations->country)->pluck('name', 'id')->toArray();

        $city_list = City::where('state_id', $locations->state)->pluck('name', 'id')->toArray();

        $location_type_list = LocationType::where('status', 1)->pluck('title', 'title')->toArray();

        return view('admin.locations.edit', compact('locations', 'country_list', 'state_list', 'city_list', 'location_type_list'));
    }

    public function update(EditRequest $request, $id)
    {
        $location = Locations::find($id);

        $input = $request->all();

        $location->update($input);

        return redirect()->route('admin.locations.index')
            ->with('message', 'Location Updated Successfully');
    }

    public function destroy(Request $request, $id)
    {
        if($id == 'all'){
            $locations = Locations::whereIn('id',$request->id)->get()->pluck('id')->toArray();
            foreach ($locations as $location){
                $location = Locations::findOrFail($location);

                if (!empty($location)) {
                    $location->delete();
                }
            }
            if(!empty($locations)){
                return response()->json([
                    'success' => 'success',
                    'message' => 'Location Deleted Successfully.'
                ]);
            } else {
                return response()->json([
                    'success' => 'success',
                    'message' => 'Location not found.'
                ]);
            }
        } else {

            $location = Locations::findOrFail($id);

            if (!empty($location)) {

                $location->delete();

                $request->session()->flash('message', 'Location Deleted Successfully');
                return response()->json(['success' => 'success']);
            }

            $request->session()->flash('message', 'Location not found.');
            return response()->json(['success' => 'success']);
        }

    }

    public function getState(Request $request)
    {
        $state_list = State::where("country_id", $request->country_id)
            ->pluck("name", "id")->toArray();

        return response()->json($state_list);
    }

    public function getCity(Request $request)
    {
        $city_list = City::where("state_id", $request->state_id)
            ->pluck("name", "id");

        return response()->json($city_list);
    }
}
