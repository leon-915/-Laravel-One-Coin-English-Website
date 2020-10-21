selected = [];


$(document).on("click", "#deleteAll", function () {
    if (selected.length !== 0) {
        $("#exampleModalPrimary").modal('show');
        console.log('at delete all');
        console.log(selected);
    } else {
        alert('Please select record.')
    }
});

$(document).on("click", ".cancel_delete", function () {
    selected = [];
    $("#checkall").prop('checked', false);
    $(".case").prop('checked', false);
});


$(document).on("click", "#checkall", function () {

    $(".case").prop('checked', $(this).is(':checked'));

    $(oTable.rows().nodes()).find(':checkbox').each(function () {
        $this = $(this);
        if ($('#checkall').is(':checked')) {
            $this.attr('checked', 'checked');
            selected.push($this.val());
        } else {
            $this.removeAttr('checked');
            selected.pop($this.val());
        }
    });
});

$(document).on("click", ".case", function (t) {
    if ($(".case").length == $(".case:checked").length) {
        $("#checkall").prop("checked", true);
    }
    else {
        $("#checkall").prop("checked", false);
    }
});

function checked_chkbx(chk) {
    if ($('#chk_' + chk).is(':checked')) {
        selected.push(chk);
    } else {
        selected.pop(chk);
    }
}

$(document).on("click",".yes_delete",function () {

    let user_id = $(this).attr('id');
    let url = $(this).val();
    if(!user_id){
        if (selected.length !== 0) {
            $.ajax({
                type: "DELETE",
                url: url + '/all',
                data: {"id": selected},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $("#checkall").prop("checked", false);
                    $("#exampleModalPrimary").modal('hide');
                    oTable.draw(true);

                    if(data.success == 'success'){
                        $.toast({
                            heading: 'Success',
                            text: data.message,
                            icon: 'success',
                            position: 'top-right',
                        })
                    } else {
                        $.toast({
                            heading: 'Error',
                            text: data.message,
                            icon: 'error',
                            position: 'top-right',
                        })
                    }

                }
            });
        } else {
            alert('Please select record.');
        }

    }
});
