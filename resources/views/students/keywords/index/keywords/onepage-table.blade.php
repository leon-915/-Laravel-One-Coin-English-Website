<div class="row">
    <div class="col-12">
        <input type="hidden" id="search-keyword" name="search" value="{{ $squery }}">
        <div class="table-responsive keyword_table">
            <table class="table" id="onepage-table" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">{{__('labels.stu_sr_no')}}</th>
                        <th scope="col">{{__('labels.stu_title')}}</th>
                        <th scope="col">{{__('labels.stu_topic')}}</th>
                        <th scope="col">{{__('labels.stu_student')}}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    OTable = null;
    OTable = $('#onepage-table').DataTable({
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
            url: '<?= route("students.get.onepage.list") ?>',
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
            {data: 'onepage_title', name: 'onepage_title', 'orderable':false,'searchable':true},
            {data: 'topic', name: 'topic', 'orderable':false,'searchable':false},
            {data: 'student', name: 'student', 'orderable':false,'searchable':false},
            /* {data: 'action', name: 'action', 'orderable':false,'searchable':false}, */
        ]
    });
</script>
