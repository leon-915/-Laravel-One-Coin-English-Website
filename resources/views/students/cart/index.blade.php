@extends('layouts.app',['title'=> __('labels.stu_cart')])
@section('title', __('labels.stu_cart'))
@section('content')
    <section class="profile_sec my_card">
        <div class="container">
            <div class="my_card_sec">
                <div class="row">
                    <div class="col-12">
                        <div class="card_title">
                            <h3>{{__('labels.stu_my_cart')}}</h3>
                            <p>{{__('labels.stu_see_all_select_product')}}</p>
                            @if (count($errors) > 0)
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        {{ $error }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-12">
                        <div class="table-responsive view_order_list clearfix">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">{{__('labels.stu_product_name')}}</th>
                                    {{-- <th scope="col">Ddl</th> --}}
                                    <th scope="col">{{__('labels.stu_cart_subtotal')}}</th>
                                    <th scope="col">{{__('labels.stu_total_amount')}}</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $total = 0;?>
                                @if(count($cartDetail) > 0)
                                    @foreach($cartDetail as $cart)
                                        <?php
                                            $price = (int)$cart->service->price;
                                            $available_lessons = (int)$cart->service->available_lessons;
                                            $amount = (int)$price;
                                            $total += $amount;
                                        ?>
                                        <tr>
                                            <td scope="row">{{$cart->service->title}}</td>
                                            <td>
                                                ¥{{number_format($amount)}}</td>
                                            <td>
                                                ¥{{number_format($amount)}}</td>
                                            <td>
                                                <a href="{{url('student/delete-cart/'.$cart->id)}}" title="Remove item">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td scope="row" colspan="5">
                                            <p>{{__('labels.stu_cart_is_empty')}}
                                                <div class="col-12 text-right mt-3">
                                                    <a href ="{{ url('pricing') }}" class="btn_custon">{{__('labels.btn_back')}}</a>
                                                </div>
                                            </p>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <?php $taxPer = App\Models\Settings::getSettings('tax'); ?>
                            <?php $tax = ($total * $taxPer) / 100; ?>
                            <?php $netAmount = $total + $tax; ?>
                            @if(count($cartDetail) > 0)
                                <div class="card_total">
                                    <div class="total_left">
                                        <p>{{__('labels.stu_total_items')}} :<span> {{count($cartDetail)}} </span></p>
                                    </div>
                                    <div class="total_right">
                                        <p>{{__('labels.stu_sub_total')}}: <span> ¥{{number_format($total)}} </span></p>
                                        <p>{{__('labels.stu_discount')}}: <span class="discount"> ¥{{number_format($discount)}} </span></p>
                                        <p id="app-coupon-code"></p>
                                        <p>{{__('labels.stu_tax')}}({{$taxPer}}%) : <span id="tax"> ¥{{$tax}}</span></p>
                                        <p>{{__('labels.stu_total_amount')}} : <span class="net_amount">  ¥{{number_format($netAmount,2)}} </span>
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if(count($cartDetail) > 0)
                    <div class="cart_bottom_btn">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="coupon_code"
                                           placeholder="{{__('labels.stu_enter_coupon_code')}}"/>
                                    <label class="coupon_er"></label>
                                </div>
                                {{--<input type="hidden" id="valid_coupon" value="">--}}
                            </div>

                            <div class="col-lg-3 col-md-3 col-12">
                                <button class="btn_custon" id="validate_coupon">{{__('labels.btn_apply_coupon')}}</button>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">

                                @if(empty($default_payment_getway))
                                    {{-- <button class="btn_custon" id="pay_with_card">Pay with Card</button> --}}
                                @else
                                    {{-- @if(in_array('stripe',$default_payment_getway))
                                        <button class="btn_custon" id="pay_with_card">Pay with Card</button>
                                    @endif --}}

                                    @if(in_array('paypal',$default_payment_getway))
                                        <button class="btn_custon" id="pay_with_paypal">{{__('labels.btn_pay_with_paypal')}}</button>
                                    @endif
									
									@if(in_array('direct_bank_transfer',$default_payment_getway))
                                        <button class="btn_custon" id="direct_bank_transfer">{{__('labels.btn_pay_with_bank_transfer')}}</button>
                                    @endif
                                @endif


                            </div>
                                <div class="col-12 text-right mt-3">
                                    <a href ="{{ url('pricing') }}" class="btn_custon">{{__('labels.btn_back')}}</a>
                                </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    @push('scripts')
        <script src="https://checkout.stripe.com/checkout.js"></script>

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
            var setLineNotificationFlag = '{{ route('students.cart.stripePayment') }}';
            var netAmount = parseInt('{{$total}}');
            var discount = 0;
            var valid_coupon = '';
            var totalAmount = parseInt('{{$total}}');
            var one_page_fee = '{{$one_page_fee}}';
            var tax = '{{$tax}}';
            var taxPercent = '{{$taxPer}}';
            //var finalAmount = (parseInt('{{$total}}') + parseInt(one_page_fee)) - parseInt(discount);
            var finalAmount = (parseInt('{{$total}}') + parseInt({{ $tax }})) - parseInt(discount);

            $('#validate_coupon').click(function () {
                var coupon = $('#coupon_code').val();

                if (!coupon) {
                    $('.coupon_er').text("{{__('labels.stu_please_enter_coupon_code')}}");
                } else {
                    var data = {
                        coupon: coupon
                    }
                    let cloader = <?= json_encode(View::make('layouts.partials.loader')->render()) ?>;
                    $.ajax({
                        url: '{{route('students.cart.validateCoupon')}}',
                        dataType: 'JSON',
                        type: 'POST',
                        data: data,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        beforeSend: function () {
                            $('.coupon_er').html(cloader);
                            $('#app-coupon-code').html('');
                        },
                        success: function (resp) {
                            if (resp.type == 'success') {
                                if (resp.discount_type == 1) {
                                    discount = resp.discount;
                                } else {
                                    discount = ((totalAmount * parseInt(resp.discount)) / 100);
                                }

                                if (resp.discount >= parseInt(totalAmount)) {
                                    $('.coupon_er').text("{{__('labels.stu_coupon_code_not_valid')}}");
                                    return false;
                                } else {
                                    //netAmount = (parseInt(totalAmount) - parseInt(discount)) + parseInt(one_page_fee);
                                    //netAmount = (parseInt(totalAmount) + parseInt(tax) - parseInt(discount));
									
									netAmount = (parseInt(totalAmount) - parseInt(discount)) + parseInt(one_page_fee);
									tax = ((parseInt(netAmount) * taxPercent) / 100);
                                    netAmount = (parseInt(netAmount) + tax);
                                    if (resp.discount_type == 1) {
                                        $('.discount').text('¥' + discount + '(Fix)');
                                    } else {
                                        $('.discount').text('¥' + discount + ' (' + parseInt(resp.discount) + '%)');
                                    }
                                    $('#tax').text('¥' + tax);
                                    $('.net_amount').text('¥' + netAmount);
                                    $('#app-coupon-code').html('Applied Coupon Code : <span>' + coupon + '</span>');
                                    $.toast({
                                        heading: 'Success',
                                        text: "{{__('labels.stu_coupon_code_applied_success')}}",
                                        icon: 'success',
                                        position: 'top-right',
                                    })
                                    $('.coupon_er').text('');
                                    valid_coupon = coupon;
                                }
                            } else {
                                $('.coupon_er').text(resp.message);
                            }
                        }
                    });
                }

            });


            $('#pay_with_card').click(function (e) {

                let data = {
                    name: 'Lokalongo',
                    description: 'checkout',
                    //amount: (parseInt('{{$total}}') + parseInt(one_page_fee)) - parseInt(discount),
                    amount: (parseInt('{{$total}}') + parseInt('{{$tax}}')) - parseInt(discount),
                    currency: 'JPY'
                }


                handler.open(data);
                e.preventDefault();
            });


            $('#pay_with_paypal').click(function () {
                var newdata = {
                    valid_coupon: valid_coupon,
                    discount: discount,
                    //netAmount: (parseInt('{{$total}}') + parseInt(one_page_fee)) - parseInt(discount),
                    netAmount: netAmount,
                    subtotal: totalAmount,
                    //one_page_fee: one_page_fee
                    one_page_fee: 0,
                    tax: tax
                }

                $.ajax({
                    url: '{{route('students.cart.paypalPayment')}}',
                    type: 'POST',
                    data: newdata,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        $('.app-loader').removeClass('d-none');
                    },
                    success: function (result) {
                        $('.app-loader').addClass('d-none');
                        if (result.status == 'success') {
                            window.location.href = result.redirectUrl;
                        } else if(result.status == 'servicemissing') {
							
								$.toast({
									heading: "{{__('jsValidate.required.payment_faild')}}",
									text: "{{__('jsValidate.required.something_wrong')}}",
									icon: 'fail',
									position: 'top-right',
								})
								//window.location.href = {{  url('/student/cart') }};
								location.reload();
							
						} else {
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
			
			$('#direct_bank_transfer').click(function () {
                var newdata = {
                    valid_coupon: valid_coupon,
                    discount: discount,
                    //netAmount: (parseInt('{{$total}}') + parseInt(one_page_fee)) - parseInt(discount),
                    netAmount: netAmount,
                    subtotal: totalAmount,
                    //one_page_fee: one_page_fee
                    one_page_fee: 0,
                    tax: tax
                }

                $.ajax({
                    url: '{{route('students.cart.bankPayment')}}',
                    type: 'POST',
                    data: newdata,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        $('.app-loader').removeClass('d-none');
                    },
                    success: function (result) {
                        $('.app-loader').addClass('d-none');
                        if (result.status == 'success') {
                            window.location.href = result.redirectUrl;
                        } else {
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

            var handler = StripeCheckout.configure({
                key: 'pk_test_TYooMQauvdEDq54NiTphI7jx',
                image: '{{asset('images/accent-dots-copy.png')}}',
                locale: 'auto',
                token: function (token) {

                    var data = {
                        token_id: token.id,
                        valid_coupon: valid_coupon,
                        discount: discount,
                        //netAmount: (parseInt('{{$total}}') + parseInt(one_page_fee)) - parseInt(discount),
                        netAmount: (parseInt('{{$total}}') + parseInt('{{$tax}}')) - parseInt(discount),
                        subtotal: totalAmount,
                        one_page_fee: one_page_fee,
                        tax: parseInt(tax)
                    }


                    $.ajax({
                        url: setLineNotificationFlag,
                        type: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function () {
                            $('.app-loader').removeClass('d-none');
                        },
                        success: function (result) {
                            $('.app-loader').addClass('d-none');
                            if (result.status == 'success') {
                                $.toast({
                                    heading: 'Success',
                                    text: "{{__('labels.stu_payment_done_success')}}",
                                    icon: 'success',
                                    position: 'top-right',
                                })
                            } else {
                                $.toast({
                                    heading: 'Fail',
                                    text: "{{__('labels.stu_payment_failed')}}",
                                    icon: 'fail',
                                    position: 'top-right',
                                })
                            }

                            setTimeout(function () {
                                window.location.href = '{{route('students.dashboard.index')}}';
                            }, 2000);
                        }
                    });
                }
            });
        </script>
    @endpush
    <style>

        .cart_bottom_btn .btn_custon {
            display: inline-block;
            margin-right: 10px;
            margin-top: 0;
        }

    </style>
@endsection


