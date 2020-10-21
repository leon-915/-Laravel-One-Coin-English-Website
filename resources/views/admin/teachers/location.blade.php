<?php
    $statusNo = $teacher['status'];
    $status = "";
    if($statusNo == 1){ $status = "Active"; }
    if($statusNo == 2){ $status = "Pending"; }
    if($statusNo == 3){ $status = "Inactive"; }
    if($statusNo == 4){ $status = "Delete"; }
    if($statusNo == 5){ $status = "Approved"; }
    if($statusNo == 6){ $status = "Archived"; }
?>
@extends('admin.layouts.admin',['title'=>'Locations & Services'])

@section('title','Locations & Services')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Locations & Services </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.teachers.index') }}">Manage Teachers</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Locations & Services</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Locations & Services</h4>

                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {{ $error }}
                            </div>
                            @endforeach
                        @endif

                     {{--    <div class="row">
                            <div class="form-group col-6">
                                <label class="form-control-label" for="name">Teacher Name</label>
                                <p>{{ $teacher['firstname']}}  {{ $teacher['lastname']}}</p>
                            </div>
                            <div class="form-group col-6">
                              <label class="form-control-label" for="email">Email</label>
                                <p>{{ $teacher['email']}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                               <label class="form-control-label" for="contact_no">Contact Number</label><br>
                                <p>{{ $teacher['contact_no']}}</p>
                            </div>
                            <div class="form-group col-6">
                              <label class="form-control-label" for="status">Status</label>
                                <p>{{ $status}}</p>
                            </div>
                        </div>
 --}}
                         {!! Form::model($teacher, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'teacher_location','route' => ['add.location.service', $teacher['id']],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}

                            <div class="row mb-2">
                                <div class="form-group col-12 mb-0">
                                    <label class="form-control-label">Locations</label>
                                    <br>
                                    <input type="text" id="location_search" placeholder="Type here to search in below locations" class="form-control mb-2">

                                    <div class="row chk-fix-scroll register-locations  ml-0 mr-0">
                                        <div class="col-12">
                                            @foreach($locations as $key => $location)
                                                <div class="form-check form-check-info">
                                                    <label class="form-check-label" data-text="{{ $location }}">{{$location}}
                                                        <input type="checkbox"  class="available-size name form-check-input" <?= (!empty($teacherLocations) && in_array($key,$teacherLocations)) ? 'checked' : '' ?> name="locations[]" value="<?= $key ?>">
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label id="locations-error" for="locations[]" class="error"></label>
                                </div>
                            </div>

                             <div class="row mb-2">
                                <div class="form-group col-12 mb-0">
                                    <label class="form-control-label">Services</label>
                                    <br>
                                    <input type="text" id="service_search" placeholder="Type here to search in below services" class="form-control mb-2">

                                    <div class="row chk-fix-scroll register-services  ml-0 mr-0">
                                        <div class="col-12">
                                            @foreach($services as $key => $service)
                                                <div class="form-check form-check-info">
                                                    <label class="form-check-label" data-text="{{ $service }}">{{$service}}
                                                        <input type="checkbox"  class="available-size name form-check-input" <?= (!empty($teacherServices) && in_array($key,$teacherServices)) ? 'checked' : '' ?> name="services[]" value="<?= $key ?>">
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label id="services-error" for="services[]" class="error"></label>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="form-group col-12 mb-0">
                                    <br>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                    <input class="available-size name form-check-input" <?=            $teacherDetail['is_available_in_trial'] == 1 ? 'checked' : '' ?> name="is_available_in_trial" type="checkbox" value="1">
                                                     Is available in trial?
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label id="is_available_in_trial-error" for="is_available_in_trial" class="error"></label>
                                </div>
                            </div>


                            <div class="row">

                                <div class="form-group col-md-2">
                                    {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
                                </div>
                                <div class="form-group col-md-2">
                                    {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/teachers')."'")) !!}
                                </div>
                            </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">
        span.text-label {
            padding-right: 5px;
        }

        .form-group label {
            font-size: 14px;
            line-height: 1;
            vertical-align: top;
            margin-bottom: .5rem;
            font-weight: 600;
        }

        .form-group p {
            font-size: 14px;
        }

        .chk-fix-scroll{
            max-height: 200px;
            overflow-y:scroll;
            border: 1px solid;
            border-radius: 5px;
        }

    </style>
    @push('scripts')
        <script>
            $(document).on("keyup", "#location_search",function() {
                var value = this.value.toLowerCase().trim();
                $(".register-locations label").show().filter(function() {
                    return $(this).data('text').toLowerCase().trim().indexOf(value) == -1;
                }).hide();
            });

            $(document).on("keyup", "#service_search",function() {
                var value = this.value.toLowerCase().trim();
                $(".register-services label").show().filter(function() {
                    return $(this).data('text').toLowerCase().trim().indexOf(value) == -1;
                }).hide();
            });
        </script>
    @endpush
@endsection
