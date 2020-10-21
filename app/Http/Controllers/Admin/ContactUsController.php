<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class ContactUsController extends Controller
{
    public function index()
    {
        return view('admin.contact-us.index');
    }

    public function getContactUs()
    {
        $contact_us = ContactUs::query();

        return DataTables::of($contact_us)
            ->addIndexColumn()
            ->addColumn('action', function ($contact_us) {
                $editButton = '';

                $editButton .= '<a href="' . route('admin.contact-us.edit', $contact_us->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';

                $editButton .= '<a id="' . $contact_us->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteContactUs"
                    data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';

                return $editButton;
            })
            ->editColumn('status', function ($contact_us) {
                return ($contact_us->status == 1) ?
                    '<span class="badge badge-gradient-success badge-pill">Show</span>' :
                    '<span class="badge badge-gradient-primary badge-pill">Pending</span>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function edit($id)
    {
        $contact_us = ContactUs::find($id);

        $contact_us->status = 1;
        $contact_us->save();

        return view('admin.contact-us.edit', compact('contact_us'));
    }

    public function destroy(Request $request, $id)
    {
        $contact_us = ContactUs::findOrFail($id);

        if (!empty($contact_us)) {

            $contact_us->delete();

            $request->session()->flash('message', 'ContactUs Deleted Successfully');
            return response()->json(['success' => 'success']);
        } else {
            $request->session()->flash('message', 'Contact Not Found.');
            return response()->json(['success' => 'success']);
        }
    }
}
