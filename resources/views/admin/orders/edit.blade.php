@extends('admin.layouts.admin',['title'=>'Edit Order'])
@section('title', 'Edit Order')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.edit_order')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders') }}">{{ __('labels.manage_order')}}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.edit_order')}}</li>
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
                                        <p>{{$product}} </p>
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
                                        ¥  {{number_format($orders->tax)}}
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
                <hr>
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
                <br/>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::model($orders, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'edit_order','route' => ['admin.orders.update', $orders->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-control-label"
                                       for="payment_status">{{ __('labels.payment_status')}}</label>
                                {!! Form::select('payment_status', array('succeeded' => 'Success', 'failed' => 'Failed','pending'=>'Pending'),isset($orders->payment_status) ? $orders->payment_status : '', array('placeholder' => 'Select Status','class' => 'form-control','id' => 'payment_status',"data-plugin" => "selectpicker")) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/orders')."'")) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
