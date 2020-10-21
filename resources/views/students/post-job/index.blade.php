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
                                    <a href="#newjob" aria-controls="newjob" role="tab" data-toggle="tab" class="active">
                                        <span>{{__('labels.stu_new_job')}}</span>
                                    </a>
                                </li>

                                <li role="presentation">
                                    <a href="{{route('students.post.job.form')}}">
                                        <span>{{__('labels.stu_create_job')}}</span>
                                    </a></li>
                                <li role="presentation">
                                    <a href="{{route('students.post.job.history')}}">
                                        <span>{{__('labels.stu_history')}}</span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpane1" class="tab-pane active" id="newjob">
                                    @include('students.post-job.tabs.jobdata')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')

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
        
        <script type="text/javascript">

            //set content bottom padding
            $("#content").css("padding-bottom", $("footer").outerHeight() + 'px');
            $("#content").css("padding-top", $("header").outerHeight() + 'px');

            $(document).on("click", ".open_detail", function (e) {
                console.log(123);
                e.preventDefault();
                $('.history_detail').removeClass('d-none');
                $('.history').addClass('d-none');
                $('.history_detail').show();
            });

            $(document).on("click", "#cancel-edit-job", function (e) {
                e.preventDefault();
                $('.history_detail').addClass('d-none');
                $('.history').removeClass('d-none');
            });

            $(document).ready(function () {
                // $("#new_job").on("click", function(){
                //     //alert("hello");
                //     $(".post_add_remove").slideToggle("fast");
                // });

                $("#open_detail").on("click", function () {
                    //alert("hello");
                    $(".order_details_sec.history").slideToggle("fast");
                    $(".order_details_sec.history_detail").slideToggle("fast");
                });
            });

        </script>

        <script>

            /* chart.js chart examples */
            // chart colors
            var colors = ['#062039', '#032e56', '#125a93', '#1ba1d7', '#ddebfc', '#e1e1e1'];
            var cornerRadius = 20;

            /* 3 donut charts */
            var donutOptions = {
                cutoutPercentage: 85,
                legend: {position: 'bottom', padding: 20, labels: {pointStyle: 'circle', usePointStyle: true}}
            };

            // donut 3
            var chDonutData3 = {
                labels: ['1 TecherStudent - Classroom', '2 IBC060_TWE', '3 Talent 60 - 24 - 90', '4 IBC060 - 12 - 90', '5-Aktana . 24 . 90', 'Others'],
                datasets: [
                    {
                        backgroundColor: colors.slice(0, 6),
                        borderWidth: 0,
                        data: [16, 16, 16, 16, 16, 16]
                    }
                ]
            };
            var chDonut3 = document.getElementById("chDonut3");
            if (chDonut3) {
                new Chart(chDonut3, {
                    type: 'pie',
                    data: chDonutData3,
                    options: donutOptions

                });
            }
            // donut 3
            var chDonutData4 = {
                labels: ['1 TecherStudent - Classroom', '2 IBC060_TWE', '3 Talent 60 - 24 - 90', '4 IBC060 - 12 - 90', '5-Aktana . 24 . 90', 'Others'],
                datasets: [
                    {
                        backgroundColor: colors.slice(0, 6),
                        borderWidth: 0,
                        data: [16, 16, 16, 16, 16, 16]

                    }
                ]
            };
            var chDonut4 = document.getElementById("chDonut4");
            if (chDonut4) {
                new Chart(chDonut4, {
                    type: 'pie',
                    data: chDonutData4,
                    options: donutOptions

                });
            }
        </script>
    @endpush
@endsection