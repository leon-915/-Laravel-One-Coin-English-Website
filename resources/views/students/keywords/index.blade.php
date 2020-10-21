@extends('layouts.app',['title'=> __('labels.stu_reservation')])
@section('title', __('labels.stu_reservation'))
@section('content')

<section class="profile_sec reservation_sec">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="profile_inner tab_pnle_sec">

                   {{--  @include('students.reservation.index.top-search') --}}

                    <div class="card custome_nav">
                        <ul class="tabs_li nav nav-tabs one-page-tab" role="tablist">
                            <li role="presentation" class="">
                                <a href="{{ route('students.onepage.index') }}" class="onepage-tabs" aria-controls="home" role="tab" data-toggle="tab">
                                    <span>{{__('labels.stu_one_page_report')}}</span>
                                </a>
                            </li>

                            <li role="presentation" class="">
                                <a href="{{ route('students.reservation.index') }}" class="onepage-tabs" aria-controls="profile" role="tab" data-toggle="tab">
                                    <span>{{__('labels.stu_reservation_lesson_record')}}</span>
                                </a>
                            </li>

                            <li role="presentation" class="">
                                <a href="#messages" class="active onepage-tabs" aria-controls="messages" role="tab" data-toggle="tab">
                                    <span>{{__('labels.stu_keyword_phrases')}}</span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="messages">
                                @include('students.keywords.index.keywords')
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
        $(document).on('click','.char-search', function(e){
            e.preventDefault();
            var char = $(this).data('char');
            if(char == '∞'){
                $('#search-keyword').val('');
            } else {
                $('#search-keyword').val(char);
            }
            $('#search-keyword').trigger('keyup');
        });

        $(document).on('keyup','#search-keyword' ,function(e){
            e.preventDefault();

            if (typeof KTable !== 'undefined'){
                console.log('KTable triggered')
                KTable.draw(true);
            }
        });
    </script>
    <script>
        $(document).on('change','input[name=radio-search-by]',function(e){
            e.preventDefault();
            var searchby = $(this).val();
            if(searchby == 'keyword'){
                $('#search-query').attr('placeholder',"{{__('labels.stu_search_in_english')}}");
            } else if (searchby == 'onepage') {
                $('#search-query').attr('placeholder',"{{__('labels.stu_e_g_YYMMDD')}}");
            } else {
                $('#search-query').attr('placeholder',"{{__('labels.stu_search_in_english')}}");
            }
        });

        $('#frm-keyword-search').on('submit',function (e) {
            e.preventDefault();
            var frmData = $(this).serialize();
            var searchType = $(".radio-search-type:checked").val();
            var query = $('#search-query').val();

            if(!query){
                return;
            }

            if(searchType == 'keyword'){
                $.ajax({
                    url : "<?= route('students.get.keywords.search.keywordonepage') ?>",
                    data:$(this).serialize(),
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    dataType: 'JSON',
                    beforeSend: function () {
                        $('#keyword-search-table-container').html('');
                        $('.app-loader').removeClass('d-none');
                    },
                    success: function (res) {
                        $('.app-loader').addClass('d-none');
                        if (res.type == 'success') {
                            if (typeof OTable !== 'undefined'){
                                delete OTable;
                            }
                            if (typeof KTable !== 'undefined'){
                                delete KTable;
                            }
                            $('#keyword-search-table-container').html(res.html);
                        }
                    }
                });
            } else if (searchType == 'onepage') {
                $.ajax({
                    url : "<?= route('students.get.keywords.search.onepage') ?>",
                    data:$(this).serialize(),
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    dataType: 'JSON',
                    beforeSend: function () {
                        $('#keyword-search-table-container').html('');
                        $('.app-loader').removeClass('d-none');
                    },
                    success: function (res) {
                        $('.app-loader').addClass('d-none');
                        if (res.type == 'success') {
                            if (typeof KTable !== 'undefined'){
                                delete KTable;
                            }
                            if (typeof KOTable !== 'undefined'){
                                delete KOTable;
                            }
                            $('#keyword-search-table-container').html(res.html);
                        }
                    }
                });
            }
        });
    </script>

    <script>
        KTable = null;
        KTable = $('#keyword-table').DataTable({
            dom: "<'row mt-4'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-3'l><'col-sm-12 col-md-3 text-right'B>>"+
                    "<'row'<'col-sm-12'tr>>"+
                    "<'row'<'col-sm-12 col-md-7 text-left'i><'col-sm-12 col-md-5 text-right'B>>"+
                    "<'row'<'col-sm-12 col-md-12'p>>",
            processing: true,
            serverSide: true,
            searching: false,
            language: {
                'loadingRecords': '&nbsp;',
                'processing': '<div class="jumping-dots-loader"><span></span><span></span><span></span></div>',
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>",
                }
            },
            buttons: [
                {
                    extend: 'csv',
                    text: '<i class="fas fa-file-download"></i>'
                },
                {
                    extend: 'excel',
                    text: '<i class="far fa-file-excel"></i>'
                },
            ],
            ajax: {
                url: '<?= route("students.get.keywords.list") ?>',
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: function (d) {
                    d.search = $('input[name=search]').val();
                },
                dataSrc: function ( json ) {
                    $('#keyword-seach-text').removeClass('d-none');
                    return json.data;
                }
            },
            order: [[0,'DESC']],
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex','orderable':false,'searchable':false},
                {data: 'keyword', name: 'keyword', 'orderable':false,'searchable':true},
                {data: 'translate', name: 'translate', 'orderable':false,'searchable':false},
                {data: 'topic', name: 'topic', 'orderable':false,'searchable':false},
                {data: 'lession_date', name: 'lession_date', 'orderable':false,'searchable':false}
            ]
        });

        <?php if(!empty($squery)) { ?>
            $(document).ready(function(){
                $('#search-keyword').val('<?= $squery ?>');
                $('#search-keyword').trigger('keyup');
            });
        <?php } ?>
    </script>

    <script>
        $(document).on('click', '.onepage-tabs',function(e){
            e.preventDefault();
            window.location.href = $(this).attr('href');
        });
    </script>
@endpush

@endsection
