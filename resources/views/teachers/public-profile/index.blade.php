@extends('layouts.app',['title'=>'Teacher Profile'])
@section('title', 'Teacher Profile')

@section('content')
    <section class="profile_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile_inner tab_pnle_sec">
                        <div class="card custome_nav">
                            <!--ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class=""><a href="#Schedule" aria-controls="management"
                                        role="tab" data-toggle="tab" class=""> <span>Schedule</span></a></li>

                                <li role="presentation" class=""><a href="#Profile" aria-controls="order_D"
                                        role="tab" data-toggle="tab" class="active show"><span>Profile</span></a>
                                </li>
                            </ul-->

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div id="Schedule">
                                    @include('teachers.public-profile.index.schedule')
                                </div> <!-- tab over -->

                                <div id="Profile">
                                    @include('teachers.public-profile.index.profile')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .clear-rating.clear-rating-active {
            display: none;
        }
        #teaching_category .badge{
            margin-right: 10px;
             line-height: 20px;
            padding: 5px;
            min-width: 90px;
        }
    </style>
    @push('scripts')
        <script src="{{ asset('plugins/star-ratings/js/star-rating.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/star-ratings/themes/krajee-svg/theme.js') }}" type="text/javascript"></script>
        @if(Session::has('message'))
            <script>
                $.toast({
                    heading: 'Success',
                    text: "<?= Session::get('message') ?>",
                    icon: 'success',
                    position: 'top-right',
                    hideAfter : 10000
                })
            </script>
        @endif

        @if(Session::has('error'))
            <script>
                $.toast({
                    heading: 'Error',
                    text: "<?= Session::get('error') ?>",
                    icon: 'error',
                    position: 'top-right',
                })
            </script>
        @endif
        <script>
            $('.teacher-ratings-avg').rating({
                theme: 'krajee-svg',
                filledStar: '<span class="krajee-icon krajee-icon-star"></span>',
                emptyStar: '<span class="krajee-icon krajee-icon-star"></span>',
                starCaptions: function (rating) {
                    return rating == 1 ? 'One Star' : rating + ' Star';
                }
            });

            @foreach($ratingTypes as $ratt)
            $('#rating-{{ $ratt['rating']['id'] }}').rating({
                theme: 'krajee-svg',
                filledStar: '<span class="krajee-icon krajee-icon-star"></span>',
                emptyStar: '<span class="krajee-icon krajee-icon-star"></span>',
                starCaptions: function (rating) {
                    var cap = '';
                    if(rating >=1 && rating < 2)
                        cap = '{{$ratt['desc_star1']}}';
                    else if(rating >=2 && rating < 3)
                        cap = '{{$ratt['desc_star2']}}';
                    else if(rating >=3 && rating < 4)
                        cap = '{{$ratt['desc_star3']}}';
                    else if(rating >=4 && rating < 5)
                        cap = '{{$ratt['desc_star4']}}';
                    else if(rating == 5)
                        cap = '{{$ratt['desc_star5']}}';

                    return cap;
                    //return rating == 1 ? 'One Star' : rating + ' Star';
                }
            });
            @endforeach

            $(".clear-rating").hide();
            $(".rated .caption").hide();

            $(document).on('click','#btn_submit', function(e){
                e.preventDefault();
                e.stopPropagation();

                //var starData = $('#teacher-star-ratings input').serialize();
                var starData = $('#teacher_rate').serialize();
                $.ajax({
                    url: '{{route('teachers.rating')}}',
                    type: "POST",
                    dataType: "json",
                    data: starData,
                    //contentType: false,
                    cache: false,
                    //processData:false,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function(){
                        $('.app-loader').removeClass('d-none');
                    },
                    success : function(res){
                        // localtion.reload();
                        $('.app-loader').addClass('d-none');
                        if(res.type == 'success'){
                            setTimeout(function(){// wait for 5 secs(2)
                                location.reload(); // then reload the page.(3)
                            }, 1000);
                            $.toast({
                                heading: 'Success',
                                text: res.message,
                                position: 'top-right',
                                icon: 'success'
                            });
                            $('#'+res.replace).html(res.html);
                        }
                    }
                });
            });
			
			function make_teacher_fav(teacher_id){
                var starData = {
                    teacher_id: teacher_id,
				}
				
				$.ajax({
                    url: '{{route('teachers.favorite')}}',
                    type: "POST",
                    data: starData,
                    cache: false,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function(){
                        $('.app-loader').removeClass('d-none');
                    },
                    success : function(res){
                        // localtion.reload();
                        $('.app-loader').addClass('d-none');
                        if(res.type == 'success'){
                            setTimeout(function(){// wait for 5 secs(2)
                                location.reload(); // then reload the page.(3)
                            }, 1000);
                            $.toast({
                                heading: 'Success',
                                text: res.message,
                                position: 'top-right',
                                icon: 'success'
                            });
                        }
                    }
                });
            }
			
			
			
			function make_teacher_un_fav(teacher_id){
                var starData = {
                    teacher_id: teacher_id,
				}
				
				$.ajax({
                    url: '{{route('teachers.unfavorite')}}',
                    type: "POST",
                    data: starData,
                    cache: false,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function(){
                        $('.app-loader').removeClass('d-none');
                    },
                    success : function(res){
                        // localtion.reload();
                        $('.app-loader').addClass('d-none');
                        if(res.type == 'success'){
                            setTimeout(function(){// wait for 5 secs(2)
                                location.reload(); // then reload the page.(3)
                            }, 1000);
                            $.toast({
                                heading: 'Success',
                                text: res.message,
                                position: 'top-right',
                                icon: 'success'
                            });
                        }
                    }
                });
            }

        </script>
    @endpush
@endsection
