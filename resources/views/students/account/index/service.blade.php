<div class="accent_plan accent_classroom_tbl">
    <div class="row">
        <div class="col-md-12">
            <div class="accent_title">
                <h1>{{__('labels.stu_accent_lesson_service')}}</h1>
                <p>{{__('labels.stu_lorem_ipsum')}}
            </div>
        </div>
    </div>

    <div class="regular_course">
       {{--  @if($user->one_time_fees == 0)
        <div class="row">
        <div class="col-12">
        <p>You have't paid one time registration fees yet , please pay first to book lession</p>
        </div>
        </div>
        @elseif($user->yearly_one_page_fees == 0)
        <div class="row">
        <div class="col-12">
        <p>You have't paid yearly one page fees , please pay first to book lession</p>
        </div>
        </div>
        @else --}}

        <div class="row">
            <div class="col-12">
                <div class="table-responsive view_order_list clearfix">
                	<div class="table-inner-container">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{__('labels.stu_regular_cource')}}</th>
                                <th>{{__('labels.stu_price')}}</th>
                                <th>{{__('labels.stu_duration')}}</th>
                                <th>{{__('labels.stu_available_booking')}}</th>
                                <th>{{__('labels.dash_action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($services as $service)
                                    @if ($service->service_type == 'onepage')
                                        @if(!empty(Auth::user()->onepage_start_date) && !empty(Auth::user()->onepage_end_date))
                                            @if(time() > strtotime(Auth::user()->onepage_end_date))
                                                @include('students.account.index.service.item')
                                            @endif
                                        @else
                                            @include('students.account.index.service.item')
                                        @endif
                                    @elseif ($service->service_type == 'registration')
                                        @if(Auth::user()->is_registerfee_paid == 0)
                                            @include('students.account.index.service.item')
                                        @endif
                                    @elseif ($service->service_type == 'credit')
                                    @elseif ($service->service_type == 'onbreak')
                                    @else
                                        @include('students.account.index.service.item')
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="price_point clearfix">
                        <div class="row">
                            <div class="col-12">
                                <p>
                                    * {{__('labels.stu_service_p1')}}
                                </p>
                                <p>
                                    * {{__('labels.stu_service_p2')}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

