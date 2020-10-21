@extends('admin.layouts.admin',['title'=>'Student Packages'])
@section('title', 'Student Packages')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.student_packages')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item" aria-current="page">
                        <a href="{{ route('admin.student.lesson.records.index') }}">{{ __('labels.student_lesson_records')}}</a>
                    </li>
                    <li class="breadcrumb-item">{{ __('labels.student_packages')}}</li>
                </ol>
            </nav>
        </div>

{{--{{dd($courses)}}--}}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    {{--<div class="col-12 text-right mb-3">--}}
                        {{--<a class="btn btn-inverse-info btn-rounded btn-icon"--}}
                           {{--href="{{url('admin/student-lesson-records')}}" data-toggle="tooltip" data-placement="top"--}}
                           {{--data-original-title="Add Service" title="Add Service" style="line-height: 41px;">--}}
                            {{--<i class="mdi mdi-arrow-left" aria-hidden="true"></i>--}}
                        {{--</a>--}}
                    {{--</div>--}}
                    <div class="col-12">
                        <table class="table" id="">
                            <thead class="bg-info text-white">
                            <tr>
                                <th>#</th>
                                <th>{{ __('labels.service_id')}}</th>
                                <th>{{ __('labels.start_date')}}</th>
                                <th>{{ __('labels.expire_date')}}</th>
									{{--<th>{{ __('labels.available_lessons')}}</th>--}}
                                <!--th>{{ __('labels.action')}}</th-->
                            </tr>
                            </thead>
                            <tbody>
							<?php
							$i = 1;
							?>
							@if(!empty($packages))
                                @foreach($packages as $key => $stLe)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td><a href="{{route('admin.student.lesson.records.packagebookings').'?id='.$stLe['id'].'&user_id='.$stLe['user_id']}}">{{$stLe['package']['title']}}</a></td>
                                        <td>{{ date('Y-m-d', strtotime($stLe['start_date'])) }}</td>
                                        <td>{{ date('Y-m-d', strtotime($stLe['end_date'])) }}</td>
											{{--<td>{{$stLe['service']['available_lessons']}}</td>--}}
                                        <!--td> <a href="{{ route('admin.student.lessons.edit',$stLe['id'])."?ref=lessonrecord&user_id=".$stLe['user_id']
                                                }}" class="btn btn-outline-info btn-rounded btn-icon edit-row"
                                                title="Edit" data-toggle="tooltip" title="Edit" data-original-title="Edit">
                                                <i class="mdi mdi-pencil-box" aria-hidden="true"></i>
                                            </a>
                                        </td-->
										<?php
										$i++;
										?>
                                    </tr>
                                @endforeach                            
                            @endif
							

                            @if(!empty($courses))
                                @foreach($courses as $key => $stLe)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td><a href="{{route('admin.student.lesson.records.bookings').'?id='.$stLe['id'].'&user_id='.$stLe['user_id']}}">{{$stLe['service']['title']}}</a></td>
                                        <td>{{$stLe['start_date']}}</td>
                                        <td>{{$stLe['expire_date']}}</td>
											{{--<td>{{$stLe['service']['available_lessons']}}</td>--}}
                                        <!--td> <a href="{{ route('admin.student.lessons.edit',$stLe['id'])."?ref=lessonrecord&user_id=".$stLe['user_id']
                                                }}" class="btn btn-outline-info btn-rounded btn-icon edit-row"
                                                title="Edit" data-toggle="tooltip" title="Edit" data-original-title="Edit">
                                                <i class="mdi mdi-pencil-box" aria-hidden="true"></i>
                                            </a>
                                        </td-->
										<?php
										$i++;
										?>
                                    </tr>
                                @endforeach
                            @endif
							
							@if(empty($courses) && empty($packages))
								<tr style="text-align: center">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>No records found</td>
                                </tr>
							@endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection