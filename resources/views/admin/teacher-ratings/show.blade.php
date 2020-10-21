<?php
    $comments = '';
?>
@extends('admin.layouts.admin',['title'=>'Rating Details'])
@section('title', 'Rating Details')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Teacher Rating Detail</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.teacher-ratings.index') }}">Teacher Ratings</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Teacher Rating Detail</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <a class="btn btn-inverse-info btn-rounded btn-icon add_data"
                       href="{{ url('admin/teacher-ratings') }}" data-toggle="tooltip" data-placement="top"
                       data-original-title="Back" title="Back">
                        <i class="mdi mdi-arrow-left" aria-hidden="true"></i>
                </a>
                <div class="row">
                   <br>
                    <div class="col-md-6">
                        <p><strong>Teacher Name : </strong> {{$booking['teacher']['firstname']}} {{$booking['teacher']['lastname']}}</p>
                        <p><strong>Student Name : </strong> {{$booking['student']['firstname']}} {{$booking['student']['lastname']}}</p>
                        <p><strong>Service Name : </strong> {{$booking['service']['title']}}</p>
                    </div>
                    <div class="col-md-6">
                        <h4>{{ __('labels.date')}}</h4>
                        <p>{{date('d-M-Y',strtotime($booking->lession_date))}}
                    </div>
                </div>
                <br/>
                <hr class="mt-0">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive view_order_list">
                           
                            @if(count($ratings) > 0)
                                <h4>Rating Detail</h4>
                                <table class="table" id="orderdetail_table">
                                    <thead>
                                    <tr>
                                        <th scope="col"><strong>Title</strong></th>
                                        <th scope="col"><strong>Ratings</strong></th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($ratings as $rating)
                                            @if((empty($rating->comments)) && (!empty($rating->rating_id)))
                                                <tr>
                                                    <td>
                                                        {{$rating['rating']['title']}}
                                                    </td>
                                                    <td class="admin-rating">
                                                        <input id="teacher-rating"
                                                            class="kv-ltr-theme-svg-star rating-loading teacher-ratings-avg" value="{{!empty($rating->ratings) ? $rating->ratings : 0}}" dir="ltr" data-size="xs" readonly="true"><span class="rat-admin">{{!empty($rating->ratings) ? number_format($rating->ratings,1) : 0}}/5</span>
                                                    </td>
                                                </tr>
                                            @else
                                                <?php
                                                    $comments = $rating->comments;
                                                ?>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h4>Not Rated</h4>
                            @endif
                        </div>
                    </div>
                </div>
                <br>
                @if(!empty($comments))
                    <div class="row">
                        <div class="col-md-12">
                             <h4>Comments :  </h4>
                             <p>{{$comments}}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

<style type="text/css">
     .admin-rating {position: relative;}
     .admin-rating .rat-admin{position: relative;right: -105px;top: -15px;}
</style>


    @push('scripts')
        <script src="{{ asset('plugins/star-ratings/js/star-rating.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/star-ratings/themes/krajee-svg/theme.js') }}" type="text/javascript"></script>

        <script>
            $('.kv-ltr-theme-svg-star').rating({
                theme: 'krajee-svg',
                filledStar: '<span class="krajee-icon krajee-icon-star"></span>',
                emptyStar: '<span class="krajee-icon krajee-icon-star"></span>',
                starCaptions: function (rating) {
                    return rating == 1 ? 'One Star' : rating + ' Star';
                }
            });
            $(".clear-rating").hide();
            $(".caption").hide();
        </script>
    @endpush
@endsection

