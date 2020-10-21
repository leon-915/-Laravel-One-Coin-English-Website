@extends('layouts.app',['title'=> __('labels.stu_reservation')])
@section('title', __('labels.stu_reservation'))
@section('content')
<?php
    $credit_balance = !empty($studentDetails->credit_balance) ? $studentDetails->credit_balance : '0';
    $reward_balance = !empty($studentDetails->reward_balance) ? $studentDetails->reward_balance : '0';
    $total_balance  = $credit_balance+$reward_balance;
?>
<section class="profile_sec reservation_sec">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="profile_inner tab_pnle_sec">
                    <div class="card custome_nav acc-student one-page-acc">
                        <ul class="tabs_li nav nav-tabs one-page-tab" role="tablist">
                            <li role="presentation" class="">
                                <a href="{{ route('students.onepage.index') }}" class="onepage-tabs" aria-controls="home" role="tab" data-toggle="tab" >
                                    <span>{{__('labels.stu_one_page_report')}}</span>
                                </a>
                            </li>

                            <li role="presentation" class="">
                                <a href="#profile" aria-controls="profile" class="onepage-tabs active" role="tab" data-toggle="tab">
                                    <span>{{__('labels.stu_reservation_lesson_record')}}</span>
                                </a>
                            </li>

                            <li role="presentation" class="">
                                <a href="{{ route('students.keywords.index') }}" class="onepage-tabs" aria-controls="messages" role="tab" data-toggle="tab">
                                    <span>{{__('labels.stu_keyword_phrases')}}</span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="profile">
                                @include('students.reservation.index.reservation')
                            </div>
                        </div> <!-- tab-content over -->
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
</style>

@push('scripts')

    <script src="{{ asset('plugins/star-ratings/js/star-rating.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/star-ratings/themes/krajee-svg/theme.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.js"></script>

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
    @include('students.reservation.index.js')
    @if($package)
        @include('students.reservation.index.chart.subscription-chart-js')
        @include('students.reservation.index.chart.reward-chart-js')
    @else
        @include('students.reservation.index.chart.lesson-chart-js')
    @endif
    <script type="text/javascript">
        $(document).on('submit','#stepTwo',function(e){
            e.preventDefault();
            var data = $(this).serialize();
            var action = $(this).attr('action');
            var form = $(this);
            var redirectUrl = '<?= route('students.dashboard.index') ?>';

            $.ajax({
                url : action,
                data : data,
                dataType: 'JSON',
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                beforeSend: function () {
                   $('.app-loader').removeClass('d-none');
                },
                success: function (result) {
                    $('.app-loader').addClass('d-none');

                    if (result.type == 'success') {

                        $.toast({
                            heading: 'Success',
                            text: result.message,
                            icon: 'success',
                            position: 'top-right',
                            afterHidden: function () {
                                window.location.href = redirectUrl;
                            }
                        });

                    } else {
                        $.toast({
                            heading: 'Error',
                            text: result.message,
                            icon: 'error',
                            position: 'top-right',
                        })
                    }
                }, error :function(res){
                    $('.app-loader').addClass('d-none');
                    $.each(res.responseJSON.errors,function(key, value){
                        $.toast({
                            heading: 'Error',
                            text: value,
                            icon: 'error',
                            position: 'top-right',
                        })
                    });
                }
            });
        });
    </script>
@endpush

@endsection
