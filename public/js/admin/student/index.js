var oTable =  $('#students-table').DataTable({
    processing: true,
    serverSide: true,
    searching: false,
    buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
       language: {
        'loadingRecords': '&nbsp;',
        'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
    },
    ajax: {
        url: getListUrl,
        type: 'POST',
        headers: {'X-CSRF-TOKEN': csrfToken},
        data: function (d) {
            d.firstname = $('input[name=firstname]').val();
            d.lastname = $('input[name=lastname]').val();
            d.email = $('input[name=email]').val();
            d.status = $('select[name=status]').val();
             }
    },
    /*columnDefs: [
        {
        "aTargets": [ 6 ],
        "mRender": function ( data, type, full ) {
                  return '<img src="'+ data +'">';
                 }
        }
    ],*/
    order: [[ 1, "desc" ]],
    columns: [
        { data: 'case', name: 'case',orderable: false, searchable: false},
        { data: 'id', name: 'id'},
        { data: 'firstname', name: 'firstname' },
        { data: 'lastname', name: 'lastname' },
        { data: 'email', name: 'email' },
        { data: 'contact_no', name: 'contact_no'},
        { data: 'status', name: 'status'},
      /*  { data: 'profile_image',name:'profile_image',orderable: false, searchable: false},*/
       /* { data: 'service', name: 'service'},*/
        { data: 'action', name: 'action',orderable: false, searchable: false}
    ]

});


$(document).on("click",".deleteStudent",function () {
    var student_id = $(this).attr('id');
    $(".yes_delete").attr('id',student_id);
    $("#exampleModalPrimary").modal('show');
});

$(document).on("click",".yes_delete",function () {
    let student_id = $(this).attr('id');
    if(student_id){
        $.ajax({
            url: indexUrl +'/'+ student_id,
            type: 'DELETE',
            headers: {
                'X-CSRF-Token': csrfToken
            },
            success: function(result) {
                window.location = indexUrl;
            }
        });
    }
});

$(document).on('keyup','#student-search input',function(e){
    oTable.draw(true);
    e.preventDefault();
});

$(document).on('change','#student-search select',function(e){
    oTable.draw(true);
    e.preventDefault();
});
