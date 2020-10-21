<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Coupons\AddRequest;
use App\Http\Requests\Admin\Coupons\EditRequest;
use App\Models\Coupons;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class CouponsController extends Controller
{
    public function index()
    {
        return view('admin.coupons.index');
    }

    public function getCoupons()
    {
        $coupons = Coupons::orderBy('id')->get();

        return DataTables::of($coupons)
            ->addIndexColumn()
            ->addColumn('case', function ($users) {
                return '<input type="checkbox" name="select" value="'.$users->id.'" onclick="checked_chkbx('.$users->id.')"  class="case" id="chk_'. $users->id .'">';
            })
            ->addColumn('action', function ($coupons) {
                $editButton = '';

                $editButton .= '<a href="' . route('admin.coupons.edit', $coupons->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';

                $editButton .= '<a id="' . $coupons->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteCoupon"
                    data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';

                return $editButton;
            })
            ->editColumn('status', function ($coupons) {
                if ($coupons->status == 1) {
                    if (strtotime($coupons->to_date) >= strtotime(date('Y-m-d'))) {
                        return '<span class="badge badge-gradient-success badge-pill">Active</span>';
                    } else {
                        return '<span class="badge badge-gradient-danger badge-pill">Expire</span>';
                    }
                } else if ($coupons->status == 2) {
                    return '<span class="badge badge-gradient-danger badge-pill">Inactive</span>';
                }
            })
            ->editColumn('discount_type', function ($coupons) {
                return ($coupons->discount_type == 1) ? 'Fixed' : 'Percentage';
            })
            ->editColumn('discount', function ($coupons) {
                if (!empty($coupons->discount)) {
                    if ($coupons->discount_type == 2) {
                        return $coupons->discount . ' %';
                    } else if ($coupons->discount_type == 1) {
                        return '¥ ' . $coupons->discount;
                    }
                }
            })
            ->rawColumns(['case','action', 'status'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(AddRequest $request)
    {
        $input = $request->all();

        $data = [
            'coupon_code' => !empty($input['coupon_code']) ? $input['coupon_code'] : '',
            'status' => !empty($input['status']) ? $input['status'] : 1,
            'discount_type' => !empty($input['discount_type']) ? $input['discount_type'] : 1,
            'discount' => !empty($input['discount']) ? $input['discount'] : 0,
            'usage_limit_per_coupon' => !empty($input['usage_limit_per_coupon']) ? $input['usage_limit_per_coupon'] : 0,
            'usage_limit_per_user' => !empty($input['usage_limit_per_user']) ? $input['usage_limit_per_user'] : 0,
            'from_date' => !empty($input['from_date']) ? $input['from_date'] : '',
            'to_date' => !empty($input['to_date']) ? $input['to_date'] : '',
        ];

        Coupons::create($data);
        return redirect()->route('admin.coupons.index')->with('message', 'Coupon inserted Successfully');
    }

    public function edit($id)
    {
        $coupons = Coupons::find($id);
        return view('admin.coupons.edit', compact('coupons'));
    }

    public function update(EditRequest $request, $id)
    {
        $input = $request->all();
        $coupons = Coupons::find($id);

        $data = [
            'coupon_code' => !empty($input['coupon_code']) ? $input['coupon_code'] : '',
            'status' => !empty($input['status']) ? $input['status'] : 1,
            'discount_type' => !empty($input['discount_type']) ? $input['discount_type'] : 1,
            'discount' => !empty($input['discount']) ? $input['discount'] : 0,
            'usage_limit_per_coupon' => !empty($input['usage_limit_per_coupon']) ? $input['usage_limit_per_coupon'] : 0,
            'usage_limit_per_user' => !empty($input['usage_limit_per_user']) ? $input['usage_limit_per_user'] : 0,
            'from_date' => !empty($input['from_date']) ? $input['from_date'] : '',
            'to_date' => !empty($input['to_date']) ? $input['to_date'] : '',
        ];

        $coupons->update($data);

        return redirect()->route('admin.coupons.index')
            ->with('message', 'Coupon Updated Successfully');
    }

    public function destroy(Request $request, $id)
    {
        if ($id == 'all') {
            $coupons = Coupons::whereIn('id', $request->id)->get()->pluck('id')->toArray();
            foreach ($coupons as $coupon_id) {
                $coupon = Coupons::findOrFail($coupon_id);
                if (!empty($coupon)) {
                    $coupon->delete();
                }
            }
            if (!empty($coupons)) {
                return response()->json([
                    'success' => 'success',
                    'message' => 'Coupon Deleted Successfully'
                ]);
            } else {
                return response()->json([
                    'success' => 'success',
                    'message' => 'Coupon not found'
                ]);
            }
        } else {
            $coupons = Coupons::findOrFail($id);

            if (!empty($coupons)) {
                $coupons->delete();
                $request->session()->flash('message', 'Coupon Deleted Successfully');
                return response()->json(['success' => 'success']);
            } else {
                $request->session()->flash('message', 'Coupon not found.');
                return response()->json(['success' => 'success']);
            }
        }
    }
}
