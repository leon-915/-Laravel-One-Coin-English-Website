<div class="row">
    <div class="col-12">
        @include('teachers.dashboard.index.alpha-search')
    </div>
</div>
<div class="row clearfix keyword-sec">
    <div class="col-4" id="keyword-seach-text" style="position: relative;top: 22px;z-index: 50;">
        <div class="form-group has-search custom_search custom_search_keyword mb-3">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control" id="search-keyword" name="search" placeholder="Search keyword">
        </div>
    </div>
    <div class="col-12" style="margin-top: -50px;">
        <div class="table-responsive keyword_table">
        	<div class="lesson-teacher-table">
                <table class="table" id="keyword-table" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">Sr.No</th>
                            <th scope="col">Keyword</th>
                            <th scope="col">Translation</th>
                            <th scope="col">Topic</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-12">
        @include('teachers.dashboard.index.alpha-search')
    </div>
</div>

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
            url: '<?= route("teachers.dashboard.get.keywords.list") ?>',
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
            // {data: 'id', name: 'id','orderable':false,'searchable':false},
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
