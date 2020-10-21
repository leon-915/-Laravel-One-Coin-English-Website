<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TeacherDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherAttachment;
use File;
use App\Models\TeacherFacebookPost;
use Yajra\DataTables\DataTables;
use App\User;
use DB;
use App\Http\Requests\Teacher\Settings\FacebookPostRequest;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use App\Helpers\ZohoHelper;

class FacebookPostController extends Controller
{
    public function index(Request $request) {

		return view('admin.facebook-posts.index');
	}

	public function getFacebookPosts(Request $request) {

        $posts = TeacherFacebookPost::select([
                            'teacher_facebook_post.*',
                            DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS teacher_name"),

                        ])
                        ->leftJoin('users','users.id','teacher_facebook_post.user_id');
                        //->orderBy('teacher_facebook_post.id','DESC');


        return Datatables::of($posts)
			->filter(function ($query) use ($request) {
				if (!empty($request->get('status'))) {
					$query->where("teacher_facebook_post.status" , $request->get('status'));
				}
			})
			->addIndexColumn()
            ->addColumn('case', function ($users) {
                return '<input type="checkbox" name="select" value="'.$users->id.'" onclick="checked_chkbx('.$users->id.')"  class="case" id="chk_'. $users->id .'">';
            })
			->editColumn('status', function ($posts) {
				if ($posts->status == '1') {
                    return '<span class="badge badge badge-gradient-warning badge-pill">Pending</span>';
                }else if ($posts->status == '2') {
					return '<span class="badge badge-gradient-success badge-pill">Approved</span>';
				} else if ($posts->status == '3') {
					return '<span class="badge badge-gradient-danger badge-pill">Not Approved</span>';
				}else if ($posts->status == '4') {
                    return '<span class="badge badge-gradient-primary badge-pill">Archived</span>';
                }
            })
            ->editColumn('image', function ($posts) {
				if ($posts->image) {
					return '<image src="'.asset($posts->image).'" height="50" width="50">';
				}/* else {
				return '<image src="'.asset('uploads/profile/default.png').'" height="50" width="50">';
				}*/
            })
			->addColumn('action', function ($posts) {
				$editButton = '';
				//$authUser = auth()->user();
                if($posts->status != 4){
                    $editButton .= '<a href="' . route('admin.facebook-posts.edit', $posts->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';
    				$editButton .= '<a id="' . $posts->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteFacebookPost"
    				   data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';
                }

				return $editButton;
			})
			->rawColumns(['case','status', 'action','image'])
			->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create() {
        $teachers = User::select( DB::raw("CONCAT(firstname,' ',lastname) as name"), 'id' )
        				->where('user_type','teacher')
						->orderBy('name')
						->pluck('name','id');
        return view('admin.facebook-posts.create',compact('teachers'));
    }*/

    /*public function store(FacebookPostRequest $request) {
        $input = $request->all();


        $fb = new TeacherFacebookPost;


        $fb->subject = !empty($input['subject']) ? $input['subject'] : '';
        $fb->message = !empty($input['message']) ? $input['message'] : '';
        $fb->image = '';

        if ($request->has('image')) {
            $file = $request->file('image');

            $file_name = time() . $file->getClientOriginalName();

            $input['image'] = $file_name;
            $file_path = 'uploads/users/teachers/facebook';
            $move = $file->move($file_path, $file_name);

            if($move){
                $fb->image = $file_path.'/'.$file_name;
            }

        }
        $fb->save();
        $request->session()->flash('message', 'Facebook Post Created Successfully');
        return response()->json(['type' => 'success', 'message' => 'Facebook Post Created Successfully', 'redirect' => route('admin.facebook-posts.index')]);
    }*/

    public function edit($id) {
        $post = TeacherFacebookPost::find($id);
        return view('admin.facebook-posts.edit', compact('post'));
    }

    public function update(Request $request, $id) {
        $input = $request->all();
        $post = TeacherFacebookPost::find($id);
        $request->validate([
            'subject' => 'required',
            'message' => 'required',
        ]);


        $update = [
            'subject' => !empty($request->subject) ? $request->subject : '',
            'message' =>  !empty($request->message) ? $request->message : '',
            'status' => $request->status
        ];

        if($request->status == 2){

            $app_id = config('services.facebook.app_id');
            $app_secret = config('services.facebook.app_secret');
            $page_id = config('services.facebook.page_id');
            //$pgToken = config('services.facebook.access_token');
			$access_token = ZohoHelper::get_fb_access_token();
            $fbP = new Facebook([
                'app_id' => $app_id,
                'app_secret' => $app_secret,
                'default_graph_version' => 'v3.3',
            ]);

            $array = [];
            $array['message'] = $input['message'];
            if(!empty($post['image'])) {
                /*$array['published'] = 'false';
                $array['url'] = url($post['image']);
               // $array['caption'] = "Image";
                try {
                    // Returns a `Facebook\FacebookResponse` object
                    $response = $fbP->post(
                        '/'.$page_id.'/photos',
                        $array,
                        $pgToken
                    );
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }*/

				try {
					$data = [
					  'message' => $input['message'],
					  'source' => $fbP->fileToUpload(url($post['image'])),
					];
					
					//echo '<pre>';print_r($data);exit;
					$response = $fbP->post('/me/photos', $data, $access_token);
				} catch(Facebook\Exceptions\FacebookResponseException $e) {
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }
                $graphNode = $response->getGraphNode();

            } else {
                try {
                    // Returns a `Facebook\FacebookResponse` object
                    $response = $fbP->post(
                        '/'.$page_id.'/feed',
                        $array,
                        $access_token
                    );
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }
                $graphNode = $response->getGraphNode();

            }
			//echo '<pre>';print_r($graphNode);
        }

        $post->update($update);

        return redirect(route('admin.facebook-posts.index'))->with('message', 'Facebook Post Updated Successfully');
    }

    public function destroy(Request $request, $id)
    {
        if ($id == 'all') {
            $fb_posts= TeacherFacebookPost::whereIn('id', $request->id)->get()->pluck('id')->toArray();
            foreach ($fb_posts as $fb_post_id) {
                $fb_post = TeacherFacebookPost::findOrFail($fb_post_id);
                if (!empty($fb_post)) {
                    $fb_post->update(['status' => 4]);
                }
            }
            if (!empty($fb_posts)) {
                return response()->json([
                    'success' => 'success',
                    'message' => 'Post Deleted Successfully'
                ]);
            } else {
                return response()->json([
                    'success' => 'success',
                    'message' => 'Post not found'
                ]);
            }
        } else {
            $post = TeacherFacebookPost::findOrFail($id);
            $post->update(['status' => 4]);
            $request->session()->flash('message', 'Post Deleted Successfully.');
            return response()->json([
                'type' => 'success'
            ]);
            //return redirect(route('admin.facebook-posts.index'))->with('message', 'Facebook Post Updated Successfully');
        }
    }
}
