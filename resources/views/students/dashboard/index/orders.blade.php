<div class="order_details_sec">
    <div class="row">
        <div class="col-12 col-lg-6 cpl-md-12">
            <div class="plan_header">
                <h2>{{__('labels.dash_recent_order')}}</h2>
                <p>{{__('labels.dash_recent_order_details')}}</p>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="table-responsive view_order_list no-overflow clearfix">
            	<div class="table-inner-container view-order">
                    <table class="table"  id="order_table">
                        <thead>
                        <tr>
                            <th scope="col">{{__('labels.dash_sr_no')}}</th>
                            <th scope="col">{{__('labels.dash_product')}}</th>
                            <th scope="col">{{__('labels.dash_date')}}</th>
                            {{-- <th scope="col">{{__('labels.status')}}</th> --}}
                            <th scope="col">{{__('labels.dash_total')}}</th>
                            <th scope="col">{{__('labels.dash_lesson_package_status')}}</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        {{--<tbody>--}}
                        {{--<tr>--}}
                            {{--<td scope="row">#50375</td>--}}
                            {{--<td>July 9, 2019</td>--}}
                            {{--<td>Completed</td>--}}
                            {{--<td>¥0 for 1 item</td>--}}
                            {{--<td>Scheduled</td>--}}
                            {{--<td><a href="">View Details</a></td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td scope="row">#50375</td>--}}
                            {{--<td>July 9, 2019</td>--}}
                            {{--<td>Completed</td>--}}
                            {{--<td>¥0 for 1 item</td>--}}
                            {{--<td>Scheduled</td>--}}
                            {{--<td><a href="">View Details</a></td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td scope="row">#50375</td>--}}
                            {{--<td>July 9, 2019</td>--}}
                            {{--<td>Completed</td>--}}
                            {{--<td>¥0 for 1 item</td>--}}
                            {{--<td>Scheduled</td>--}}
                            {{--<td><a href="">View Details</a></td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td scope="row">#50375</td>--}}
                            {{--<td>July 9, 2019</td>--}}
                            {{--<td>Completed</td>--}}
                            {{--<td>¥0 for 1 item</td>--}}
                            {{--<td>Scheduled</td>--}}
                            {{--<td><a href="">View Details</a></td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td scope="row">#50375</td>--}}
                            {{--<td>July 9, 2019</td>--}}
                            {{--<td>Completed</td>--}}
                            {{--<td>¥0 for 1 item</td>--}}
                            {{--<td>Scheduled</td>--}}
                            {{--<td><a href="">View Details</a></td>--}}
                        {{--</tr>--}}
                        {{--</tbody>--}}
                    </table>
                </div>
            </div>

        </div>
        <div class="col-12">
            <p class="subscribe_text clearfix">{{__('labels.dash_order_other_subscriptions')}} <a href="{{ route('pricing.index') }}"   class="blue_colr"> {{__('labels.dash_here')}} </a></p>
        </div>
    </div>

</div>
