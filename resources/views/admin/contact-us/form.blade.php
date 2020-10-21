
<div class="row">
    <div class="form-group col-md-9 mt-4">
        <label for="name">{{ __('labels.your_name')}}</label>
        {!! Form::text('name', isset($contact_us->name) ? $contact_us->name : '', array('placeholder' => 'Your Name','class'=> 'form-control','id' => 'name' ,'disabled' => 'disabled'))!!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-9">
        <label for="email">{{ __('labels.your_email')}}</label>
        {!! Form::email('email', isset($contact_us->email) ? $contact_us->email : '', array('placeholder' => 'Your Email','class'=> 'form-control','id' => 'email','disabled' => 'disabled'))!!}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-9">
        <label for="subject">{{ __('labels.subject')}}</label>
        {!! Form::text('subject', isset($contact_us->subject) ? $contact_us->subject : '', array('placeholder' => 'Subject','class'=> 'form-control','id' => 'subject','disabled' => 'disabled'))!!}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-9">
        <label for="message">{{ __('labels.your_message')}}</label>
        {!! Form::textarea('message', isset($contact_us->message) ? $contact_us->message : '', array('rows'=>10,'placeholder' => 'Your Message','class'=> 'form-control','id' => 'message','readonly'=>true))!!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-9">
        <label  for="status">{{ __('labels.status')}}</label>
        {!! Form::select('status', array('1' => 'Show', '2' => 'Pending'),isset($contact_us->status) ? $contact_us->status : '', array('class' => 'form-control','id' => 'status',"data-plugin" => "selectpicker",'disabled' => 'disabled')) !!}
    </div>
</div>


<div class="row">
    {{--<div class="form-group col-md-2">--}}
        {{--{!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}--}}
    {{--</div>--}}
    <div class="form-group col-md-2">
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/contact-us')."'")) !!}
    </div>
</div>