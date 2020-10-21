@extends('layouts.app',['title'=>'Teacher - My Account'])
@section('title', 'Teacher - My Account')

@section('content')
    <section class="profile_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile_inner tab_pnle_sec" style="background: #ffffff;">
                        <div class="card custome_nav">
                            <ul class="nav nav-tabs no-mar" role="tablist">
                                <li role="presentation" {{-- class="active" --}}>
                                    <a href="#calender" data-url="{{route('teachers.settings.get.calender')}}" class="setting-tabs {{ ($ref == 'calender') ? 'active' : ''}}" aria-controls="calender" role="tab" data-toggle="tab" >
                                        <span>Teacher Calendar</span>
                                    </a>
                                </li>

                                <li role="presentation">
                                    <a href="#facebook"  data-url="{{route('teachers.settings.get.facebook.post')}}" class="setting-tabs {{ ($ref == 'facebook') ? 'active' : ''}}" aria-controls="facebook" role="tab" data-toggle="tab">
                                        <span>Facebook Page PR</span>
                                    </a>
                                </li>

                                <li role="presentation">
                                    <a href="#lessons-recordes" data-url="{{route('teachers.settings.get.lessons')}}"  class="setting-tabs {{ ($ref == 'lessons-recordes') ? 'active' : ''}}" aria-controls="lessons-recordes" role="tab" data-toggle="tab">
                                        <span>Lesson Records</span>
                                    </a>
                                </li>

                                <li role="presentation">
                                    <a href="#schedule" class="setting-tabs {{ ($ref == 'schedule') ? 'active' : ''}}" data-url="{{route('teachers.settings.get.schedule')}}" aria-controls="schedule" role="tab" data-toggle="tab">
                                        <span>Manage Schedule</span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane" id="lessons-recordes">
                                </div>

                                <div role="tabpane3" class="tab-pane" id="facebook">
                                    @include('teachers.settings.index.facebook-post')
                                </div>

                                <div role="tabpane4" class="tab-pane" id="calender">
                                </div>

                                <div role="tabpane2" class="tab-pane" id="schedule">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src="{{ asset('plugins/fullcalendar/packages/core/main.js') }}"></script>
        <script src="{{ asset('plugins/fullcalendar/packages/interaction/main.js') }}"></script>
        <script src="{{ asset('plugins/fullcalendar/packages/daygrid/main.js') }}"></script>
        <script src="{{ asset('plugins/fullcalendar/packages/timegrid/main.js') }}"></script>
        <script src="{{ asset('plugins/fullcalendar/packages/list/main.js') }}"></script>
        <script src="{{ asset('plugins/listswap/jquery.listswap.min.js') }}"></script>
        <script src="{{ asset('js/jquery.timepicker.js') }}"></script>

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
            let cloader = <?= json_encode(View::make('layouts.partials.loader')->render()) ?>;
            let curUrl = "{{ route('teachers.settings.index') }}";
            let lessonListUrl = "{{ route('teachers.settings.get.lessons.list') }}";
            let fbPostListUrl = "{{ route('teachers.settings.get.facebook.post.list') }}";
            let cTab = "{{ $ref }}";
            let excpHtml = <?= json_encode(View::make('teachers.settings.index.schedule.exception')->render()) ?>;
        </script>
        <script src="{{ asset('js/teacher/settings.js') }}"></script>
    @endpush
@endsection
