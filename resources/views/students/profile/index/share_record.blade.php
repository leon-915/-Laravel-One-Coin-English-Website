{!! Form::open(array('route' => 'students.profile.share.lesson_record','id'=>'frm_share_record','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
    <div class="row">
        <div class="col-12">
            <div class="plan_header">
                <h2>Share Record </h2>
                <p>Type email and share this lesson record. </p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-12 col-12">
            <div class="form-group">
                <label>Email</label>
                @if($emails->isEmpty())
                    <input type="email" name="email[0]" value="" class="form-control val-email"  placeholder="Write email of your friend" data-email>
                @endif
            </div>
        </div>
        <div class="form-group col-md-6">
            <div class="empty-lable">
                <button type="button" class="add-option btn_sub" onclick="optionAction.addOption()">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="email-container">
        @if(!($emails->isEmpty()))
            @include('students.profile.email.multiple_email')
        @endif
    </div>

    <div class="row">
        <div class="col-12 text-right mt-3">
            <button type="submit" class="btn_sub btnsub_arr" id="sub_button">Share</button>
        </div>
    </div>

    <input type="hidden" name="share_type" value="lessons">

{!! Form::close() !!}
