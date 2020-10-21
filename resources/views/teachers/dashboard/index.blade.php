@extends('layouts.app',['title'=>'Teacher Dashboard'])
@section('title', 'Teacher Dashboard')

@section('content')
    <section class="profile_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile_inner tab_pnle_sec">
                        {{-- <div class="top_search_sec">
                            @include('teachers.dashboard.index.keyword-search')
                        </div> --}}
                        <div class="card custome_nav">
                            <ul class="nav nav-tabs no-mar" role="tablist">
                                <li role="presentation">
                                    <a href="#management" data-url="{{ route('teachers.dashboard.get.tops') }}"
                                       aria-controls="management" role="tab" data-toggle="tab"
                                       class="setting-tabs {{ ($ref == 'management') ? 'active' : ''}}">
                                        <span>Management Dashboard</span>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#canvas" aria-controls="canvas" role="tab" data-toggle="tab"
                                       data-url="{{ route('teachers.dashboard.get.onepage') }}"
                                       class="setting-tabs {{ ($ref == 'canvas') ? 'active' : ''}}">
                                        <span>Onepage Canvas</span>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#keywords" aria-controls="keywords"
                                       data-url="{{ route('teachers.dashboard.get.keywords') }}" role="tab"
                                       data-toggle="tab" class="setting-tabs {{ ($ref == 'keywords') ? 'active' : ''}}">
                                        <span>Keywords & Phrases</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpane1" class="tab-pane {{ ($ref == 'management') ? 'active' : ''}}"
                                     id="management">
                                </div>
                                <div role="tabpane3" class="tab-pane {{ ($ref == 'canvas') ? 'active' : ''}}"
                                     id="canvas">
                                </div>
                                <div role="tabpane2" class="tab-pane {{ ($ref == 'keywords') ? 'active' : ''}}"
                                     id="keywords"></div>
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
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
        <script src="{{ asset('js/jquery.form.min.js') }}"></script>
        <script src="{{ asset('js/forms.js') }}"></script>

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
            let startSessionUrl = "{{ route('teachers.dashboard.start.session') }}";
            let cTab = "{{ $ref }}";


        </script>
        <script src="{{ asset('js/teacher/dashboard.js') }}"></script>
        <script src="{{ asset('js/teacher/onepage.js') }}"></script>
        <script src="{{ asset('onepage/js/simple-undo.js') }}"></script>
		<script type="text/javascript">
		function show_japanes_text(span_id) {

            $('#' + span_id).toggle();
            if ($('.' + span_id).text() == 'Read More') {

            $('.' + span_id).text('Read Less');
            } else {

            $('.' + span_id).text('Read More');
            }
        }
		</script>
    @endpush
@endsection
