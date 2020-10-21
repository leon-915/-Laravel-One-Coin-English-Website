@extends('emails.layout')
@section('title')
    <title> Lokalingo | Order Status </title>
@endsection
@section('content')
    <?php
        $user       = $data['user'];
        $order = $data['order'];
    ?>
    <h1 style="font-size: 25px; color: #212529; font-weight: 500; margin: 0; padding: 20px 0;"> Order Status </h1>
    <div class="course" style="padding-bottom: 25px;">
        <h3 style="color: #484848; font-size: 18px; margin-bottom: 0; font-weight: 700;"><b> Hi {{ $user->firstname .' '. $user->lastname}} , </b></h3>
        <table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
            <tbody>

                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Order Id </b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $order['id'] }}</td>
                </tr>

                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Date </b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ date('d-m-Y',strtotime($order['created_at']))}}</td>
                </tr>

                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Retailer Name </b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $order['retailer']['firstname'] .' '. $order['retailer']['lastname'] }}</td>
                </tr>

                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Organization Name </b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $order['retailer']['organization'] }}</td>
                </tr>

                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Store Name </b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $order['retailer']['store_name'] }}</td>
                </tr>

                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Category </b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $order['product']['category']['parent']['name']  }} </td>
                </tr>

                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Sub Category </b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px">  {{ $order['product']['category']['name'] }} </td>
                </tr>

                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>RRP </b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px">  ${{ $order['product']['rrp'] }} </td>
                </tr>

                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Wholesale Price </b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px">  ${{ $order['product']['wholesale_price'] }} </td>
                </tr>

                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Product Title </b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px">  {{ $order['product']['name'] }} </td>
                </tr>

                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Barcode </b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px">  {{ $order['product']['barcode'] }} </td>
                </tr>

                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Status </b></td>
                    @if($order['status'] == 1)
                        <td  style="border-top: 1px solid #dee2e6; padding: 5px; color: #007bff;"> Pending </td>
                    @elseif($order['status'] == 2)
                        <td style="border-top: 1px solid #dee2e6; padding: 5px; color: #17a2b8"> In Progress </td>
                    @elseif($order['status'] == 3)
                        <td  style="border-top: 1px solid #dee2e6; padding: 5px;color:  #28a745"> Completed </td>
                    @elseif($order['status'] == 4)
                        <td  style="border-top: 1px solid #dee2e6; padding: 5px; color: #ffc107"> Cancelled </td>
                    @endif
                </tr>

                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Size </b></td>
                    <td>
                        <ul style="list-style-type: none;padding: 0px;">
                            @foreach($order['details'] as $detail)
                                @if(!empty($detail['variants']['size']))
                                    <li style="border-top: 1px solid #dee2e6; padding: 5px">  {{ $detail['variants']['size']['name']  }} - {{ $detail['qty'] }} </li>
                                @endif
                            @endforeach
                        </ul>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

@endsection


