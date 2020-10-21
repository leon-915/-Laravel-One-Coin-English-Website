
@extends('layouts.app',['title'=>'Teachers List'])
@section('title', 'Teachers')

@section('content')
    <section class="profile_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile_inner tab_pnle_sec">
                        <div class="row">
                            <div class="col-12">
                                <div class="plan_header">
                                    <h2>Teachers</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($teachers as $teacher)
                                <?php
                                    $url = asset('uploads/profile/default.png');
                                    if(!empty($teacher->profile_image)){
                                        $url = asset($teacher->profile_image);
                                    }
                                ?>
                                <div class="card col-4 p-3 text-center">
                                    <img class="card-img-top mx-auto d-block" align="middle" src="{{ $url }}" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">{{$teacher->firstname}} {{$teacher->lastname}}</h5>
                                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        <a href="{{ route('teachers.public.profile',$teacher->id)}}" class="btn btn-primary">Go to Profile</a>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-4">
                                    <a href="{{ route('teachers.public.profile',$teacher->id)}}">
                                      <img src="{{ asset($teacher->profile_image) }}" alt="profile">
                                    </a>
                                    <a class="name" href="{{ route('teachers.public.profile',$teacher->id)}}">{{$teacher->firstname}} {{$teacher->lastname}}</a>
                                </div> --}}
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style type="text/css">
        .card-img-top {
            width: 200px !important;
            height: 200px !important;
            border-radius:50% !important;
            /* border-top-right-radius: calc(.25rem - 1px); */
        }
    </style>
@endsection
