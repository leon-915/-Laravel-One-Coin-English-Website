
<div class="lesson_record_sec facebook">
    <div class="row">
        <div class="col-md-12">
            <div class="bord">
                <img src="{{asset('images/facebook.png')}}">
                <div class="card custome_nav_inner">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="">
                            <a href="#New" aria-controls="New" role="tab" data-toggle="tab" class="active show" id="new_post">
                                <span>Add New</span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#Messages" id="message" aria-controls="Messages" role="tab" data-toggle="tab">
                                <span>All Messages</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div role="tabpane3" class="tab-pane active show frm" id="New">
                {{-- @if (count($errors) > 0)
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        {{ $error }}
                    </div>
                    @endforeach
                @endif --}}
                <div class="alert alert-danger display-error" style="display: none">
                </div>
                {!! Form::open(array('route' => 'teachers.settings.store.facebook.post','class'=>'cmxform', 'id'=>'frm_facebook','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
                    <h4>{{ __('labels.facebook_message')}}</h4>
                    <div class="form-group full">
                        <label>{{ __('labels.subject_of_message')}}<span>*</span></label>
                        <input type="text" id="fb_subject" name="subject" class="form-control">
                        <label id="subject-error" class="error frm-fb-errors"></label>
                    </div>
                    <div class="form-group full">
                        <label>{{ __('labels.enter_message')}}<span>*</span></label>
                        {!! Form::textarea('message', null, ['id' => 'fb_message', 'rows' => 4, 'cols' => 14, 'class' => 'form-control']) !!}
                        <label id="message-error" class="error frm-fb-errors"></label>
                    </div>
                    <div class="form-group full">
                        <label>{{ __('labels.attachment')}}</label>
                        <div class="file-upload">
                            <div class="file-select">
                                <div class="file-select-button" id="fileName">Choose file</div>
                                <div class="file-select-name" id="noFile">Upload image</div>
                                <input type="file" name="image" class="custom-file-upload" id="chooseFile">
                            </div>
                        </div>
                        <label id="image-error" class="error frm-fb-errors"></label>

                        <label id="image-error" class="error" for="image" style="display: none;"></label>
                    </div>
                    <input type="hidden" name="post_id" id="post_id">

                    <button href="#next" role="menuitem"
                        class="btn_custon post_submit">Submit</button>
                {!! Form::close() !!}
            </div>

            <div role="tabpane3" class="tab-pane msgs" id="Messages">
                <div class="lesson_record_sec">
                    <div class="row">
                        <div class="col-md-12" id="filter_post">
                            <ul class="face_allmessage">
                                <li><a href="#" id="1">Pending</a></li>
                                <li><a href="#" id="2">Approved</a></li>
                                <li><a href="#" id="3">Not Approved</a></li>
                                <li><a href="#" id="4">Archived</a></li>
                            </ul>
                        </div>
                        <input type="hidden" name="filter_id">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive table_custom">
                                <table class="table" id="facebook-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('labels.subject')}}</th>
                                            <th scope="col">{{ __('labels.message')}}</th>
                                            <th scope="col">{{ __('labels.teacher_name')}}</th>
                                            <th scope="col">{{ __('labels.created_date')}}</th>
                                            <th scope="col">{{ __('labels.image')}}</th>
                                            <th scope="col">{{ __('labels.status')}}</th>
                                            <th scope="col">{{ __('labels.action')}}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-danger show" id="deleteConfimModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfimModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-2">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('labels.confirm_delete_facebook_post')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-gradient-primary btn-rounded btn-fw yes_delete">{{ __('labels.submit')}}</button>
                <button type="button" class="btn btn-gradient-secondary btn-rounded btn-fw" data-dismiss="modal">{{ __('labels.cancel')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-danger show" id="csvError" aria-hidden="true" aria-labelledby="csvError"
     role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Error</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="csv-error-body">
                <p>There is some error. Please check and try again </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-gradient-secondary btn-rounded btn-fw" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var facebookTable = '';
    document.addEventListener('DOMContentLoaded', (event) => {
        var required = [];
        var extension = [];
        required.subject = '{{ __("jsValidate.required.subject") }}';
        required.message = '{{ __("jsValidate.required.message") }}';
        extension.image = '{{ __("jsValidate.extension.image") }}';
        $('#frm_facebook').validate({

            ignore: "",
            rules: {
                message : {
                    required: true,
                    maxlength : 1000
                },
                subject:{
                    required: true,
                    maxlength : 191
                },
                image : {
                    extension: "jpg,jpeg,png",
                    filesize: 2097152,
                },

            },
            messages: {
                message : {
                    required : required.message,
                    maxlength: "Please enter less than 1000 characters"
                },
                subject:{
                    required: required.subject,
                    maxlength: "Please enter less than 191 characters"
                },
                image : {
                    extension: extension.image,
                    filesize: "The file size is too big (2MB max)",
                },
            },
        });
    });
</script>
