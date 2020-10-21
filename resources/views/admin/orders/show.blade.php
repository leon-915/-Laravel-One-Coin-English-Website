@extends('admin.layouts.admin',['title'=>'Order Details'])
@section('title', 'Order Details')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.order_detail')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders') }}">{{ __('labels.manage_order')}}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.order_detail')}}</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <a class="btn btn-inverse-info btn-rounded btn-icon add_data"
                           href="{{ url('admin/orders') }}" data-toggle="tooltip" data-placement="top"
                           data-original-title="Back" title="Back">
                            <i class="mdi mdi-arrow-left" aria-hidden="true"></i>
                        </a><br>

                        <div class="table-responsive view_order_list">
                            <table class="table" id="orderdetail_table">
                                <thead>
                                <tr>
                                    <th scope="col"><strong>{{ __('labels.product')}}</strong></th>
                                    <th scope="col"><strong>{{ __('labels.total')}}</strong></th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td>
                                        {{$product}}
                                    </td>
                                    <td>¥ {{$orders->subtotal}}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('labels.card_sub_total')}} :</strong></td>
                                    <td>¥  {{$orders->subtotal}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>{{ __('labels.discount')}}  :</strong>
                                    </td>
                                    <td>
                                        ¥  {{number_format($orders->discount)}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>{{ __('labels.tax')}}  :</strong>
                                    </td>
                                    <td>
                                        ¥  {{number_format($orders->tax,2)}}
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>{{ __('labels.order_total')}}  :</strong></td>
                                    <td>¥  {{$orders->amount}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br/>
                <hr class="mt-0">
                <div class="row">
                    <div class="col-md-6">
                        <h4>{{ __('labels.customer_detail')}}</h4>
                        <p><strong>{{ __('labels.order_user_id')}} : </strong> {{$user_email->username}}</p>
                        <p><strong>{{ __('labels.email')}} : </strong> {{$user_email->email}}</p>
                    </div>
                    <div class="col-md-6">
                        <h4>{{ __('labels.date')}}</h4>
                        <p>{{date_format($orders->created_at, "d-M-Y")}}

                    </div>
                </div>

                <hr class="mt-0">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Freshbook Invoice Detail</h4>
                        <p><strong>Status : </strong> {{!empty($orders->freshbook_invoice_status) ? $orders->freshbook_invoice_status : ''  }}</p>
                        <p><strong>Invoice ID : </strong> <a href="https://accentinc.freshbooks.com/showInvoice?invoiceid={{$orders->freshbook_invoice_id}}">
                            {{!empty($orders->freshbook_invoice_id) ? $orders->freshbook_invoice_id : '' }}</a></p>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
