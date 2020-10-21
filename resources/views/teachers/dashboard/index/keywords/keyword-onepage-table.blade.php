<div class="row">
    <div class="col-12">
        <input type="hidden" id="search-keyword" name="search" value="{{ $squery }}">
        <div class="table-responsive keyword_table">
            <table class="table" id="keyword-onepage-table" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Sr No</th>
                        <th scope="col">Topic</th>
                        <th scope="col">Topic JP</th>
                        <th scope="col">Student</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    KOTable = null;
    KOTable = $('#keyword-onepage-table').DataTable({
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
            url: '<?= route("teachers.dashboard.get.keywordonepage.list") ?>',
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: function (d) {
                d.search = $('input[name=search]').val();
            },
            dataSrc: function ( json ) {
                return json.data;
            }
        },
        order: [[0,'DESC']],
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex','orderable':false,'searchable':false},
            {data: 'topic', name: 'topic', 'orderable':false,'searchable':false},
            {data: 'translate', name: 'translate', 'orderable':false,'searchable':false},
            {data: 'student', name: 'student', 'orderable':false,'searchable':false},
            {data: 'action', name: 'action', 'orderable':false,'searchable':false},
        ]
    });
</script>
