@extends('layouts.app',['title'=> __('labels.stu_job_post')])
@section('title', __('labels.stu_job_post'))
@section('content')
    <section class="profile_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile_inner tab_pnle_sec">
                        <div class="card custome_nav">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation">
                                    <a href="#new_job" aria-controls="newjob" role="tab" data-toggle="tab" class="active">
                                        <span>{{__('labels.stu_new_job')}}</span>
                                    </a>
                                </li>

                                <li role="presentation">
                                    <a href="{{route('students.post.job.form')}}" aria-controls="createJob" role="tab" data-toggle="tab" class="active">
                                        <span>{{__('labels.stu_create_job')}}</span>
                                    </a>
                                </li>

                                <li role="presentation">
                                    <a href="{{route('students.post.job.history')}}" aria-controls="history" role="tab" data-toggle="tab">
                                        <span>{{__('labels.stu_history')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="new_job">
                                @yield('datacontent')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection