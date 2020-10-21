<script>
    let tab = "{{$ref}}";
    let cloader = <?= json_encode(View::make('layouts.partials.loader')->render()) ?>;
    let dis = $('a[aria-controls=' + tab + ']');
    let curl = dis.data('url');

    let tax = <?= (App\Models\Settings::getSettings('tax')) ? App\Models\Settings::getSettings('tax') : 0 ?>;

    var package_id = 0;

    // var setLineNotificationFlag = '{{ route('students.account.payment') }}';
    // var handler = StripeCheckout.configure({
    //     key: 'pk_test_TYooMQauvdEDq54NiTphI7jx',
    //     image: '{{asset('images/accent-dots-copy.png')}}',
    //     locale: 'auto',
    //     token: function (token) {
    //         // You can access the token ID with `token.id`.
    //         // Get the token ID to your server-side code for use.
    //         $.ajax({
    //             url: setLineNotificationFlag,
    //             type: 'POST',
    //             data: 'token_id=' + token.id + '&package_id=' + package_id,
    //             headers: {
    //                 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             beforeSend: function () {
    //                 $('.app-loader').removeClass('d-none');
    //             },
    //             success: function (result) {
    //                 $('.app-loader').addClass('d-none');
    //                 $('#qrModal').modal('hide');
    //                 $.toast({
    //                     heading: 'Success',
    //                     text: "Package subscription successfull",
    //                     icon: 'success',
    //                     position: 'top-right',
    //                 })
    //             }
    //         });
    //     }
    // });


    // document.getElementById('plan-0').addEventListener('click', function (e) {
    //     // Open Checkout with further options:
    //     package_id = $('#plan-0').data('package-id');

    //     var amtwtax = $("#plan-price-0").val();
    //     var taxamt = amtwtax*tax/100;
    //     var amt = (parseFloat(amtwtax)+parseFloat(taxamt));

    //     handler.open({
    //         name: $("#plan-name-0").val(),
    //         description: '¥'+amtwtax + ' + ' +tax + '% Tax included.',
    //         amount: amt,
    //         currency: 'JPY'
    //     });
    //     e.preventDefault();
    // });
    // document.getElementById('plan-1').addEventListener('click', function (e) {
    //     // Open Checkout with further options:
    //     package_id = $('#plan-1').data('package-id');

    //     var amtwtax = $("#plan-price-1").val();
    //     var taxamt = amtwtax*tax/100;
    //     var amt = (parseFloat(amtwtax)+parseFloat(taxamt));

    //     handler.open({
    //         name: $("#plan-name-1").val(),
    //         description: '¥'+amtwtax + ' + ' +tax + '% Tax included.',
    //         amount: amt,
    //         currency: 'JPY'
    //     });
    //     e.preventDefault();
    // });
    // document.getElementById('plan-2').addEventListener('click', function (e) {
    //     // Open Checkout with further options:
    //     package_id = $('#plan-2').data('package-id');

    //     var amtwtax = $("#plan-price-2").val();
    //     var taxamt = amtwtax*tax/100;
    //     var amt = (parseFloat(amtwtax)+parseFloat(taxamt));

    //     handler.open({
    //         name: $("#plan-name-2").val(),
    //         description: '¥'+amtwtax + ' + ' +tax + '% Tax included.',
    //         amount: amt,
    //         currency: 'JPY'
    //     });
    //     e.preventDefault();
    // });

    // $(document).on('click','.buy_package',function(e){
    //     e.preventDefault();
    //     var id = $(this).data('id');
    //     package_id = $('#plan-'+id).data('package-id');
    //     var amtwtax = $("#plan-price-"+id).val();
    //     var taxamt = amtwtax*tax/100;
    //     var amt = (parseFloat(amtwtax)+parseFloat(taxamt));

    //     var newdata ={
    //         name : $("#plan-name-"+id).val(),
    //         description : '¥'+amtwtax + ' + ' +tax + '% Tax included.',
    //         subtotal : amtwtax,
    //         tax : taxamt,
    //         netAmount: amt,
    //         currency: 'JPY',
    //         package_id : package_id
    //     }

    //     $.ajax({
    //         url: '{{route('students.account.paypalPayment')}}',
    //         type: 'POST',
    //         data: newdata,
    //         headers: {
    //             'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         beforeSend: function () {
    //             $('.app-loader').removeClass('d-none');
    //         },
    //         success: function (result) {
    //             $('.app-loader').addClass('d-none');
    //             if (result.status == 'success') {
    //                 window.location.href = result.redirectUrl;
    //             } else {
    //                 $.toast({
    //                     heading: 'Payment Failed',
    //                     text: "Something wrong! Please try again.",
    //                     icon: 'fail',
    //                     position: 'top-right',
    //                 })
    //             }
    //         }
    //     });
    // });


    $(document).on('click','.buy_package',function(e){
        e.preventDefault();
        var id = $(this).data('id');
        package_id = $('#plan-'+id).data('package-id');
        var amtwtax = $("#plan-price-"+id).val();
        var taxamt = amtwtax*tax/100;
        var amt = (parseFloat(amtwtax)+parseFloat(taxamt));

        var newdata ={
            name : $("#plan-name-"+id).val(),
            description : '¥'+amtwtax + ' + ' +tax + '% Tax included.',
            subtotal : amtwtax,
            tax : taxamt,
            netAmount: amt,
            currency: 'JPY',
            package_id : package_id
        }

        $.ajax({
            url: '{{route('students.package.subscription')}}',
            type: 'POST',
            data: newdata,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $('.app-loader').removeClass('d-none');
            },
            success: function (result) {
                if (result.status == 'success') {
                    window.location.href = result.redirectUrl;
                } else {
                    $('.app-loader').addClass('d-none');
                    $.toast({
                        heading: "{{__('jsValidate.required.payment_faild')}}",
                        text: "{{__('jsValidate.required.something_wrong')}}",
                        icon: 'fail',
                        position: 'top-right',
                    })
                }
            }
        });
    });

    // document.getElementById('plan-3').addEventListener('click', function (e) {
    //     // Open Checkout with further options:
    //     package_id = $('#plan-3').data('package-id');
    //     var amtwtax = $("#plan-price-3").val();
    //     var taxamt = amtwtax*tax/100;
    //     var amt = (parseFloat(amtwtax)+parseFloat(taxamt));

    //     var newdata ={
    //         name : $("#plan-name-3").val(),
    //         description : '¥'+amtwtax + ' + ' +tax + '% Tax included.',
    //         subtotal : amtwtax,
    //         tax : taxamt,
    //         netAmount: amt,
    //         currency: 'JPY',
    //         package_id : package_id
    //     }

    //     $.ajax({
    //         url: '{{route('students.account.paypalPayment')}}',
    //         type: 'POST',
    //         data: newdata,
    //         headers: {
    //             'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         beforeSend: function () {
    //             $('.app-loader').removeClass('d-none');
    //         },
    //         success: function (result) {
    //             $('.app-loader').addClass('d-none');
    //             if (result.status == 'success') {
    //                 window.location.href = result.redirectUrl;
    //             } else {
    //                 $.toast({
    //                     heading: 'Payment Failed',
    //                     text: "Something wrong! Please try again.",
    //                     icon: 'fail',
    //                     position: 'top-right',
    //                 })
    //             }
    //         }
    //     });

    //     // handler.open({
    //     //     name: $("#plan-name-3").val(),
    //     //     description: '¥'+amtwtax + ' + ' +tax + '% Tax included.',
    //     //     amount: amt,
    //     //     currency: 'JPY'
    //     // });
    //     e.preventDefault();
    // });

    // Close Checkout on page navigation:
    window.addEventListener('popstate', function (res) {
        handler.close();
    });
</script>
