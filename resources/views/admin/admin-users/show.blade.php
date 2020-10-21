<div class="panel">
    <div class="panel-heading">
        {{--<h3 class="panel-title">User Detail</h3>--}}
    </div>
    <div class="panel-body container-fluid">
        <table class="table table-hover table-striped w-full">
            <tr>
                <td>
                    Name
                </td>
                <td>
                    {{$user->name}}
                </td>
            </tr>
            <tr>
                <td>
                    Email
                </td>
                <td>
                    {{$user->email}}
                </td>
            </tr>
            @if(isset($user->image) && !empty($user->image))
            <tr>
                <td>
                    Image
                </td>
                <td>
                    <img src="{{asset('uploads/user/'.$user->image.'')}}" style="height:22px;width:30px">
                </td>
            </tr>
            @endif
            <tr>
                <td>
                   Status
                </td>
                <td>
                    @if($user->status == 1)
                        <span class="badge badge-success">Active</span>
                    @elseif($user->status == 2)
                        <span class="badge badge-danger">Inactive</span>
                    @elseif($user->status == 3)
                        <span class="badge badge-warning">Suspended</span>
                    @endif
                </td>
            </tr>
        </table>
        {{--<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>--}}
    </div>
</div>
