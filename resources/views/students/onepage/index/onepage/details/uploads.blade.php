<div class="card">
    <div class="card-header" id="heading-7">
        <h5 class="mb-0">
            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-7"
               aria-expanded="false" aria-controls="collapse-7">
                Upload アップロード
            </a>
        </h5>
    </div>
    <div id="collapse-7" class="collapse" data-parent="#accordion" aria-labelledby="heading-7">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="plan_header">
                        <h2>{{__('labels.stu_upload_document')}}</h2>
                        <p>
                            {{__('labels.stu_lorem_ipsum')}}
                        </p>
                    </div>
                </div>
            </div>

            <div class="upload_image">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="drag_main">
                            <div class="Drag_files">
                                <div class="demo-droppable">
                                    <img src="{{ asset('images/canvas_drag.png') }}" alt="drag">
                                    {{__('labels.stu_drag_your_file')}}...
                                </div>
                                <div class="output"></div>
                            </div>
                            <div class="drag_add">
                                <span>... {{__('labels.stu_find_document_your_device')}}</span>
                                <input name="file[]" type="file" style="display:none" class="upload_to_drive" multiple>
                                <a style="cursor:pointer;" class="freetrial_btn" id="up_drive">{{__('labels.stu_add_files')}}</a>
                                <p>{{__('labels.stu_max_file_size')}} : <b>{{__('labels.stu_50_mb')}}</b></p>
                            </div>
                        </div>
                        <input type="hidden" class="active_folder" value="{{$open_folder_id}}">
                    </div>

                    <div class="col-lg-9">
                        <div class="upload_folder">
                            @include('students.onepage.index.onepage.details.drive')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


