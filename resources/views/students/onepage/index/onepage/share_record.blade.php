{!! Form::open(array('route' => 'students.profile.share.lesson_record','id'=>'frm_share_record','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
    <div class="row">
        <div class="col-12">
            <div class="plan_header">
                <h2>{{__('labels.stu_share_record')}}</h2>
                <p>{{__('labels.stu_type_email_share_record')}}</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-9 col-md-9 col-lg-6">
            <div class="form-group">
                <label>{{__('labels.stu_email')}}<span class="vali">*</span></label>

                @if($emails->isEmpty())
                    <input type="email" name="email[0]" value="" class="form-control val-email"  placeholder="{{__('labels.stu_write_email_to_friend')}}" data-email>
                @endif
            </div>
        </div>
        <div class="form-group col-3 col-md-3 col-lg-1">
            <div class="empty-lable">
                <button type="button" class="add-option btn_sub" onclick="optionAction.addOption()">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="email-container">
        @if(!($emails->isEmpty()))
            @include('students.dashboard.index.email.multiple_email')
        @endif
    </div>

    <div class="row">
        <div class="col-12 text-right mt-3">
            <button type="submit" class="btn_sub btnsub_arr" id="sub_button">{{__('labels.btn_share')}}</button>
        </div>
    </div>

    <input type="hidden" name="share_type" value="onepage">

{!! Form::close() !!}

