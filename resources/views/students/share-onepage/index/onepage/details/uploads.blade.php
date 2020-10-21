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
                        <h2>{{__('labels.upload_document')}}</h2>
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
                                <img src="{{ asset('images/canvas_drag.png') }}" alt="drag">
                               {{__('labels.stu_drag_your_file')}}...
                            </div>
                            <div class="drag_add">
                                <span>...  {{__('labels.stu_find_document_your_device')}}</span>
                                <a href="#" class="freetrial_btn">
                                    {{__('labels.stu_add_files')}}
                                </a>
                                <p> {{__('labels.stu_max_file_size')}} : <b> {{__('labels.stu_50_mb')}}</b></p>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-9">
                        <div class="upload_folder">
                            <div class="upload_header">
                                <div class="breadcum_left">
                                    <span>
                                        <i class="fas fa-home"></i> {{__('labels.stu_start')}}
                                        <i class="fas fa-angle-double-left"></i>
                                    </span>
                                    <ul class="bread_cum">
                                        <li>{{__('labels.stu_Eca_Ahmer')}} | </li>
                                        <li>Localingo {{__('labels.home_one_page')}}</li>
                                    </ul>
                                </div>
                                <div class="bred_icon">
                                    <a href=""><i class="fas fa-search"></i></a>
                                    <a href=""><i class="fas fa-cog"></i></a>
                                    <a href=""><i class="fas fa-redo"></i></a>
                                </div>
                            </div>

                            <div class="file">
                                <div class="file_inner prev">
                                    <img src="{{ asset('images/canvas_folder.png') }}" alt="file">
                                    <p>{{__('labels.stu_previous_folder')}}</p>
                                </div>
                                <div class="file_inner">
                                    <span>
                                        <img src="{{ asset('images/canvas_icon1.png') }}" alt="file">
                                    </span>
                                    <p>{{__('labels.stu_Eca_Ahmer')}}</p>
                                </div>
                                <div class="file_inner">
                                    <span>
                                        <img src="{{ asset('images/canvas_icon1.png') }}" alt="file">
                                    </span>
                                    <p>{{__('labels.stu_Eca_Ahmer')}}</p>
                                </div>
                                <div class="file_inner">
                                    <span>
                                        <img src="{{ asset('images/canvas_icon1.png') }}" alt="file">
                                    </span>
                                    <p>{{__('labels.stu_Eca_Ahmer')}}</p>
                                </div>
                                <div class="file_inner">
                                    <span>
                                        <img src="{{ asset('images/canvas_icon1.png') }}" alt="file">
                                    </span>
                                    <p>{{__('labels.stu_Eca_Ahmer')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
