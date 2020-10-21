@extends('admin.layouts.admin',['title'=>'Add Location'])

@section('title','Add Location')

@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> {{ __('labels.add_location')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.locations.index') }}">{{ __('labels.manage_location')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.add_location')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.add_location')}}</h4>
                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                        {!! Form::open(array('route' => 'admin.locations.store','id'=>'create_location','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
                        <fieldset>
                            @include('admin.locations.form',['form' => 'create'])
                        </fieldset>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript" src="{{ asset('assets/admin/validation/jquery.validate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/admin/validation/additional-methods.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
        <script>
            $('#create_location').validate({
                ignore: "",
                rules: {
                    title : {
                        required: true
                    },
                    title_jp : {
                        required: true
                    },
                    seats_available:{
                        required: true
                    },
                    phone_no:{
                        // required: true,
                        number:true,
                        maxlength:15,
                        minlength:6
                    },
                    // address:{
                    //     required: true
                    // },
                    // city:{
                    //     required: true
                    // },
                    // state:{
                    //     required: true
                    // },
                    // country:{
                    //     required: true
                    // },
                    zipcode:{
                        // required: true,
                        number:true,
                        maxlength:7
                    },
                    location_type:{
                        required: true
                    },
                    status:{
                        required: true
                    }
                },
                messages: {
                    title : {
                        required: "Please enter title"
                    },
                    title_jp : {
                        required: "Please enter name in japanese"
                    },
                    seats_available:{
                        required: "Please select seats"
                    },
                    phone_no:{
                        // required: "Please enter phone number",
                        number:"Please enter numeric value only",
                        maxlength: "Phone number maximum 15 digits",
                        minlength: "Phone number minimum 6 digits"
                    },
                    address:{
                        required: "Please enter address"
                    },
                    // city:{
                    //     required: "Please select city"
                    // },
                    // state:{
                    //     required: "Please select state"
                    // },
                    // country:{
                    //     required: "Please select country"
                    // },
                    zipcode:{
                        // required: "Please enter zipcode",
                        number:"Please enter numeric value only",
                        maxlength:"Zipcode maximum 7 digits"
                    },
                    location_type:{
                        required: "Please select location type"
                    },
                    status:{
                        required: "Please select status"
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "body") {
                        error.insertAfter(".panel");
                    }
                    else{
                        error.insertAfter(element);
                    }
                }
            });
            

             $('#city').on('change', function() {
             $('#city-error').hide();
             });
           
             $('#country').on('change', function() {
                $.ajax({
                    url: '{{route("admin.locations.getState")}}',
                    data: 'country_id='+$("#country").val(),
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    dataType : 'JSON',
                    success : function(data){
                        var html  = '<option value="">Select State</option>';
                        $.each(data,function(index,value){
                            html += '<option value="'+index+'">'+value+'</option>';
                        });
                        $("#state").html(html);
                    }
                })
             });
            
             $('#state').on('change', function() {
                $.ajax({
                    url: '{{route("admin.locations.getCity")}}',
                    data: 'state_id='+$("#state").val(),
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    dataType : 'JSON',
                    success : function(data){
                        var html  = '<option value="">Select City</option>';
                        $.each(data,function(index,value){
                            html += '<option value="'+index+'">'+value+'</option>';
                        });
                        $("#city").html(html);
                    }
                })
             });
            
             $('#location_type').on('change', function() {
                 $('#location_type-error').hide();
             });

            $(".select2").select2({
                allowClear: false
            });
        </script>

    @endpush
@endsection