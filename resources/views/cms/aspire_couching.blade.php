
@extends('layouts.app',['title'=>'Aspire Coaching'])
@section('title', 'Aspire Coaching')
@section('content')

    <section class="sub_page_padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4 class="sub_page_header"><img src="{{asset('images/aspire_small.png')}}">Aspire</h4>
                </div>
            </div>
            <div class="aboutus_detail_box">
                <div class="business_sec">
                    <div class="row">
                        <div class="col-12">
                            <div class="prvcy_margin">
                                <h5>{{__('labels.aspire_head')}}</h5>
                                <p>{{__('labels.aspire_head_q1')}}</p>
                                <p>1) {{__('labels.aspire_head_q1_a1')}}</p>
                                <p>2) {{__('labels.aspire_head_q1_a2')}}</p>
                                <p>3) {{__('labels.aspire_head_q1_a3')}}</p>
                            </div>
                            <div class="prvcy_margin">
                                <p>{{__('labels.aspire_head_q2')}}</p>
                                <p>1) {{__('labels.aspire_head_q2_a1')}}</p>
                                <p>2) {{__('labels.aspire_head_q2_a2')}}</p>
                                <p>3) {{__('labels.aspire_head_q2_a3')}}</p>
                                <p>4) {{__('labels.aspire_head_q2_a4')}}</p>
                                <p>5) {{__('labels.aspire_head_q2_a5')}}</p>
                            </div>
                            <div class="prvcy_margin">
                                <p>{{__('labels.aspire_head_q3')}}</p>
                                <p>1) {{__('labels.aspire_head_q3_a1')}}</p>
                                <p>2) {{__('labels.aspire_head_q3_a2')}}</p>
                                <p>3) {{__('labels.aspire_head_q3_a3')}}</p>
                                <p>4) {{__('labels.aspire_head_q3_a4')}}</p>
                                <p>5) {{__('labels.aspire_head_q3_a5')}}</p>
                                <p>6) {{__('labels.aspire_head_q3_a6')}}</p>
                                <p>7) {{__('labels.aspire_head_q3_a7')}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="business_sec">
                    <div class="row">
                        <div class="col-12">
                            <div class="prvcy_margin">
                                <h5>{{__('labels.aspire_international_couching')}}</h5>
                                <p>{{__('labels.aspire_international_couching_detail')}}</p>
                            </div>
                            <div class="prvcy_margin">
                                <h5>{{__('labels.aspire_couching_learning')}}</h5>
                                <p>{{__('labels.aspire_couching_learning_detail')}}</p>
                            </div>
                            <div class="graph_section">
                                <img src="{{asset('images/graph_1.png')}}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="business_sec">
                    <div class="row">
                        <div class="col-12">
                            <div class="prvcy_margin">
                                <h5>{{__('labels.aspire_cource_at_aspire')}}</h5>
                                <p>{{__('labels.aspire_cource_at_aspire_detail_1')}}</p>
                                <p>{{__('labels.aspire_cource_at_aspire_detail_2')}}</p>
                                <p>{{__('labels.aspire_cource_at_aspire_detail_3')}}</p>
                                <p>{{__('labels.aspire_cource_at_aspire_detail_4')}}</p>

                                <p>{{__('labels.aspire_monday_and_friday')}}</p>
                                <p>1) {{__('labels.aspire_monday_and_friday_1')}}</p>
                                <p>2) {{__('labels.aspire_monday_and_friday_2')}}</p>
                            </div>
                            <div class="calnder_section">
                                <ul class="days_bar">
                                    <li>{{__('labels.aspire_mon')}}</li>
                                    <li>{{__('labels.aspire_tue')}}</li>
                                    <li>{{__('labels.aspire_wed')}}</li>
                                    <li>{{__('labels.aspire_thu')}}</li>
                                    <li>{{__('labels.aspire_fri')}}</li>
                                    <li>{{__('labels.aspire_sat')}}</li>
                                    <li>{{__('labels.aspire_sun')}}</li>
                                </ul>
                                <ul class="time_bar">
                                    <li class="t-grey">{{__('labels.aspire_10_to_15_min')}}</li>
                                    <li class="t-yellow">{{__('labels.aspire_60_min')}}</li>
                                    <li class="t-grey">{{__('labels.aspire_10_to_15_min')}}</li>
                                    <li class="t-yellow">{{__('labels.aspire_60_min')}}</li>
                                    <li class="t-grey">{{__('labels.aspire_10_to_15_min')}}</li>
                                    <li class="t-pink">-</li>
                                    <li class="t-pink">-</li>
                                </ul>
                                <p>*{{__('labels.aspire_days_detail_1')}}</p>
                                <p>*{{__('labels.aspire_days_detail_2')}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="business_sec">
                    <div class="row">
                        <div class="col-12">
                            <div class="prvcy_margin">
                                <h5>{{__('labels.aspire_typical_session_comprice')}}</h5>
                                <p>{{__('labels.aspire_typical_session_comprice_detail')}}</p>
                                <p>1) {{__('labels.aspire_typical_session_comprice_detail_1')}}</p>
                                <p>2) {{__('labels.aspire_typical_session_comprice_detail_2')}}</p>
                                <p>3) {{__('labels.aspire_typical_session_comprice_detail_4')}}</p>
                                <p>4) {{__('labels.aspire_typical_session_comprice_detail_5')}}</p>
                                <p>5) {{__('labels.aspire_typical_session_comprice_detail_6')}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="business_sec">
                    <div class="row">
                        <div class="col-12">
                            <div class="prvcy_margin">
                                <h5>{{__('labels.aspire_curriculums')}}</h5>
                                <p>{{__('labels.aspire_curriculums_detail')}}</p>

                                <p>1) {{__('labels.aspire_curriculums_detail_1')}}</p>
                                <p>{{__('labels.aspire_key_concept')}}</p>
                                <p>- {{__('labels.aspire_curriculums_detail_1_a1')}}</p>
                                <p>- {{__('labels.aspire_curriculums_detail_1_a2')}}</p>
                                <p>- {{__('labels.aspire_curriculums_detail_1_a3')}}</p>

                                <p>2) {{__('labels.aspire_curriculums_detail_2')}}</p>
                                <p>- {{__('labels.aspire_curriculums_detail_2_a1')}}</p>
                                <p>- {{__('labels.aspire_curriculums_detail_2_a2')}}</p>
                                <p>- {{__('labels.aspire_curriculums_detail_2_a3')}}L</p>

                                <p>3) {{__('labels.aspire_curriculums_detail_3')}}</p>
                                <p>{{__('labels.aspire_key_concept')}}</p>
                                <p>- {{__('labels.aspire_curriculums_detail_3_a1')}}</p>
                                <p>- {{__('labels.aspire_curriculums_detail_3_a2')}}</p>
                                <p>- {{__('labels.aspire_curriculums_detail_3_a3')}}</p>
                                <p>- {{__('labels.aspire_curriculums_detail_3_a4')}}</p>
                                <p>- {{__('labels.aspire_curriculums_detail_3_a5')}}</p>
                                <p>- {{__('labels.aspire_curriculums_detail_3_a6')}}</p>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="business_sec">
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-2">
                            <img src="{{asset('images/ryan.png')}}" class="pro_img"><p class="pro_name">{{__('labels.ryan_ahamer')}}</p>
                        </div>
                        <div class="col-12 col-md-8 col-lg-10">
                            <div class="prvcy_margin">
                                <h5>{{__('labels.aspire_who_is_couch')}}</h5>
                                <p>{{__('labels.aspire_who_is_couch_detail')}}</p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-9 col-md-12">
                            <div class="coach_table table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('labels.aspire_time')}}</th>
                                        <th scope="col">{{__('labels.aspire_mon')}}</th>
                                        <th scope="col">{{__('labels.aspire_tue')}}</th>
                                        <th scope="col">{{__('labels.aspire_wed')}}</th>
                                        <th scope="col">{{__('labels.aspire_thu')}}</th>
                                        <th scope="col">{{__('labels.aspire_fri')}}</th>
                                        <th scope="col">{{__('labels.aspire_sat')}}</th>
                                        <th scope="col">{{__('labels.aspire_sun')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>7:00 - 8:00</td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>
                                    <tr>
                                        <td>8:00 - 9:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>
                                    <tr>
                                        <td>9:00 - 10:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>
                                    <tr>
                                        <td>10:00 - 11:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>
                                    <tr>
                                        <td>11:00 - 12:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>
                                    <tr>
                                        <td>12:00 - 13:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>
                                    <tr>
                                        <td>13:00 - 14:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>
                                    <tr>
                                        <td>14:00 - 15:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>
                                    <tr>
                                        <td>15:00 - 16:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>
                                    <tr>
                                        <td>16:00 - 17:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>
                                    <tr>
                                        <td>17:00 - 18:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>
                                    <tr>
                                        <td>18:00 - 19:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>
                                    <tr>
                                        <td>19:00 - 20:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>
                                    <tr>
                                        <td>20:00 - 21:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>
                                    <tr>
                                        <td>21:00 - 22:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="business_sec">
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-2">
                            <img src="{{asset('images/julio.png')}}" class="pro_img"><p class="pro_name">{{__('labels.julio_david')}}</p>
                        </div>
                        <div class="col-12 col-md-8 col-lg-10">
                            <div class="prvcy_margin">
                                <h5>{{__('labels.aspire_who_business_instructor')}}</h5>
                                <p>{{__('labels.aspire_who_business_instructor_detail')}}</p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-9 col-md-12">
                            <div class="coach_table table-responsive">

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('labels.aspire_time')}}</th>
                                        <th scope="col">{{__('labels.aspire_mon')}}</th>
                                        <th scope="col">{{__('labels.aspire_tue')}}</th>
                                        <th scope="col">{{__('labels.aspire_wed')}}</th>
                                        <th scope="col">{{__('labels.aspire_thu')}}</th>
                                        <th scope="col">{{__('labels.aspire_fri')}}</th>
                                        <th scope="col">{{__('labels.aspire_sat')}}</th>
                                        <th scope="col">{{__('labels.aspire_sun')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>7:00 - 8:00</td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>
                                    <tr>
                                        <td>8:00 - 9:00</td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>
                                    <tr>
                                        <td>9:00 - 10:00</td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>
                                    <tr>
                                        <td>10:00 - 11:00</td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                    </tr>
                                    <tr>
                                        <td>11:00 - 12:00</td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                    </tr>
                                    <tr>
                                        <td>12:00 - 13:00</td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                    </tr>
                                    <tr>
                                        <td>13:00 - 14:00</td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                    </tr>
                                    <tr>
                                        <td>14:00 - 15:00</td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                    </tr>
                                    <tr>
                                        <td>15:00 - 16:00</td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                    </tr>
                                    <tr>
                                        <td>16:00 - 17:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                    </tr>
                                    <tr>
                                        <td>17:00 - 18:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                    </tr>
                                    <tr>
                                        <td>18:00 - 19:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                    </tr>
                                    <tr>
                                        <td>19:00 - 20:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                    </tr>
                                    <tr>
                                        <td>20:00 - 21:00</td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_blue"></span></td>
                                    </tr>
                                    <tr>
                                        <td>21:00 - 22:00</td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                        <td><span class="dots_grey"></span></td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="business_sec">
                    <div class="aspire_logos">
                        <p><img src="{{asset('images/aspire5.png')}}"></p>
                        <p><img src="{{asset('images/aspire1.png')}}"></p>
                        <p><img src="{{asset('images/aspire2.png')}}"></p>
                        <p><img src="{{asset('images/aspire3.png')}}"></p>
                        <p><img src="{{asset('images/aspire4.png')}}"></p>
                    </div>
                </div>

                <div class="business_sec testi">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="pricing">{{__('labels.aspire_testimonial')}}</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="bs-example custom_Ac">
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h2 class="mb-0">
                                                <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"><i class="fa fa-plus"></i> 実践を想定したレッスンだから、上達がそのまま仕事の成果になってます。</button>
                                            </h2>
                                        </div>
                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="acc-container" style="display: block;">
                                                    <b> Q: どのようなタイミングで、自身の成長を感じましたか? </b>
                                                    <p>
                                                        A: ある日、突然ですが、仕事で電話会議をしている時に、相手の会話が聞けている事にビックリしました。日々の繰り返しにより英会話のリズムに慣れてきているのだと思います。</p>

                                                    <b> Q: どのようなコーチングが実践につながっていると感じますか? </b>
                                                    <p>
                                                        A: 実践では電話会議が主体であり、日々のコーチングも電話会議を前提にしています。実践に近いテーマを選び、聞く、伝える、確認するを如何に正しくコンパクトにできるかを常に意識するようになりました。</p>

                                                    <b> Q: 成長のスピードについての印象はありますか?</b>
                                                    <p>
                                                        A: 英語でイメージし、そのまま英語で表現する。が、自分にとっての成長のポイントと思います。これを日々意識して繰り返す事により、段々と英語が身についてきている事を実感しています。</p>

                                                    <b> Q: ​ほかにAccentが効果的だと感じる側面はありますか? </b>
                                                    <p>
                                                        A: インターネットメディアやツールを積極的に利用し、実践と変わらない環境でレッスンしてもらっています。効果的に学習できるだけでなく、インターネット特有の英語コミュニケーションも同時に学んでいます。一例ですが、詳細をURL等でリンクしたメッセージにして送る場合など、伝えたい内容のみを分かりやすくシンプルに表現する練習をしています。Accentでは、いつでもインターネットを利用してレッスンできる環境が整っています。</p>
                                                    S.F.・外資系IT会社・受講6ヶ月
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h2 class="mb-0">
                                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"><i class="fa fa-plus"></i> 実務で​英語でのディスカッション​が​​必要な方​に。</button>
                                            </h2>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="acc-container" style="display: block;">
                                                    <b> Q: どのようなタイミングで、自身の成長を感じましたか? </b>
                                                    <p>
                                                        A: 戦略など自身の頭に中にあるイメージを、英語として正しいだけでなく、より伝わりやすい表現を選ぶことができるようになった段階で自身の成長を感じるようになりました。</p>

                                                    <b> Q: どのようなコーチングが実践につながっていると感じますか​​? </b>
                                                    <p>
                                                        A: 日々のビジネスシーン​に合わせて、自分の考え​を英語で伝えるとともに、それに対する質問や意見​をやりとりすることで、より実践に近いトレーニングが可能になります​。
                                                        これによって、実務の場面においても臆することなく英語での発言が容易になります。</p>

                                                    <b> Q:  成長のスピードについての印象はありますか? </b>
                                                    <p>
                                                        A: Face to Faceのセッションだけでなく、毎日の電話でのショートセッションを通じて、一貫したテーマに基づいた英語のコミュニケーションによって、間違えたところやより良い表現など早い段階で修正する機会を持つことでコミュニケーションのクオリティーが格段に上がります。</p>

                                                    <b> Q: ​ほかにAccentが効果的だと感じる側面はありますか?</b>
                                                    <p>
                                                        A: 日常における学びや気づきなどのインプット​ををもとに、このレッスンを英語を用いたスループット​の機会として活用​することで、実際の場面での英語でのアウトプットの精度をあげること​に繋がります。</p>
                                                    F.M.・外資系IT会社・受講1年半
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingThree">
                                            <h2 class="mb-0">
                                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree"><i class="fa fa-plus"></i>英語で愚痴を言えるようになりました</button>
                                            </h2>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="acc-container" style="display: block;">
                                                    <b> Q: 従来の英会話教室と何が異なるのか？ </b>
                                                    <p>
                                                        A: パートタイム教師ではなく、日本の社会・文化を理解した上で専門の教師から英語を学べます。かつ教師は国際コーチ連盟（ICF）認定コーチのため、英語でコーチングを受けられます。そのため、自分自身の置かれている環境、状況を鑑みて必要なアドバイスを英語でもらう事が出来ます。
                                                        私の場合は、毎日の状況を話し時には愚痴る事で英語力、特に自分自身の感情を話す事で精神的な状況改善もあります。従来の英会話教室で、自分自身の感情を扱い、英語で話し、アドバイスをもらえる。この一連の流れ受講できる英会話教室を聞いた事がありません。</p>

                                                    <b> Q: 英語力の向上を感じられますか？ </b>
                                                    <p>
                                                        A: 私の場合、月に一度は海外との電話で営業会議があります。その際に、顧客の状況やNext Stepを話します。その際に、自分自身がどのように感じているのか？海外からどのような助けが必要なのか？また日本からどのような支援が可能なのか？を会話を遮る事なく話ができるようになりました。
                                                        また日常の会話や英語のSNS・メールが素早く、よりネイティブに近い文章で海外の方々とやりとりができるので、会話・文章の手戻りが徐々になくなり素早い会話ができるようになりました。</p>

                                                    <b> Q: どのような方におすすめか？</b>
                                                    <p>
                                                        A: 「英語力を向上させたい」と感じている、「英語を聞いて、流暢に会話がしたい」2020年の東京オリンピックの際に行き先が分からず困っている海外の方を「地図を使って案内したい」と思われる方。英語が必要な方、必要になると思われる方、外資系企業に転職されたい方など、目的を持って英語を学ぼうと思われる方におすすめです。</p>

                                                    <b> Q: Accent LessonとAspireとの違いは？</b>
                                                    <p>
                                                        A: 数年前にAccent Lessonを受講しておりました。Aspireとの違いは、「向上速度」にあると思います。
                                                        Accent Lessonの時は、週に1度60分のマーンツーマンレッスンでした。もちろん受講前に比べれば、英語力は向上しておりますが、振り返ってみると向上速度は緩やかだったと思います。何故なら、週に１度のレッスンだった為、「忘却曲線」が悪さをしておりました。
                                                        しかし、Aspireは週に４回15分前後のショートレッスンおよび週に１回60分レッスンの組み合わせなので、「忘却曲線」が悪さをする前に、日々英語を話し、聴く、考えを伝えることをします。その為、英語力の向上を実感する事ができます。</p>

                                                    T.Y.・外資系IT会社・受講2年半
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingfour">
                                            <h2 class="mb-0">
                                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefour"><i class="fa fa-plus"></i>英語力の向上を実感できる場面が必ず訪れます</button>
                                            </h2>
                                        </div>
                                        <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="acc-container" style="display: block;">

                                                  <b>  Q.一般的な英会話教室の授業と、Aspireコーチングコースの主な違いは何か? </b>
                                                    <p>
                                                        A. 職種や目的に合わせたより実践的な内容がベースになっていて現状改善しなければならないポイントや知識をその過程の中で導いて頂けることが一番の違いだと思います。目的を達成させるための最短距離をアドバイスして頂けるため充実感が非常に高いといえます。</p>

                                                    <b> Q.英語を教わっているというよりは、コーチングを受けているという感じがしたか?</b>
                                                    <p>

                                                        A. まさにその通りである地点Aから目標Bに繋いでくれるように一緒に協業しているというイメージです。決して一方通行のカリキュラムをこなすといった形式ではなく、ペースを考え、疑問点や問題点をしっかりとクリアにしていくところが本来の日本人の考え方に合っていると思います。</p>

                                                   <b> Q.コーチは、経験豊富な語学講師でありコーチであると感じたか? </b>
                                                    <p>
                                                        A. 科学的根拠に基づいたコーチングは勿論のこと、職種や自分のレベルに関わらず必要なポイントをすぐに導きだしてくれる点は語学コーチを越えて、人の洞察力や観察性が非常に高い本当のプロフェッショナルだと感じています。</p>

                                                   <b> Q.あなたが仕事で使用する英語に関連する役立つ語彙やフレーズをコーチは提案してくれたか? </b>
                                                    <p>
                                                        A. はい、毎回同じ言い回しではなく、場面や相手、状況設定に応じた相応しい表現のボキャブラリーをアドバイスして頂けるので、非常に役に立っていてフォーマルな場面等でもしっかりと自信を持って表現できています。</p>

                                                    <b>Q.あなたの仕事に関する話題を話す機会を週5日持ったことで、あなたのスピーキング(流暢さ、抑揚、発音)とリスニン グのスキルが 向上したか? </b>
                                                    <p>
                                                        A. はい、身近な時間でも確実に伸びていると思います。特に日本人の性質柄、聞くのは得意だと思いますが、話すスキルが高くなっていると感じます。</p>

                                                    <b>Q.コースにおいて何が向上すると思うか? </b>
                                                    <p>
                                                        A. 自信がつくのは勿論ですが、コースを通じシチュエーションをイメージするする力がとても向上したといえます。英語表現の中で日本語直訳で感じ取るものとイメージが異なるためどのような状況で使う表現かをイメージすることはとても大切だと感じています。</p>

                                                    <b>Q. Aspireのビジネスコミュニケーションコーチングを他の人にもすすめたいか? </b>
                                                    <p>
                                                        A. なかなか向上している実感が沸かない方、或いはゼロベースの方からでも幅広い方にお勧めしたいです。必ず向上していると実感できる場面が訪れると思います。 </p>
                                                    D.M.・外資系ワイン会社・受講18ヶ月

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header" id="headingfive">
                                            <h2 class="mb-0">
                                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefive"><i class="fa fa-plus"></i>英語の「学習」に失敗した歴史のある方に、特におすすめしたい!</button>
                                            </h2>
                                        </div>
                                        <div id="collapsefive" class="collapse" aria-labelledby="headingfive" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="acc-container" style="display: block;">
                                                    <div class="acc-container" style="display: block;">

                                                        <b>Q.一般的な英会話教室の授業と、Aspireコーチングコースの主な違いは何か?</b>
                                                        <p>
                                                            A.一般的な英会話教室の授業では、ある程度固定されたカリキュラムやレベル/順序に基づいて進行するケースが多いが、 Aspireコーチングコースは、そのセッションの設計を講師とともに行い、また日々の業務(及び生活)に即した形で毎回毎 日内容を変えてセッションを即時再設計しコーチしてもらえるため、セッション即実用の場、という点が大きな相違点で す。</p>

                                                        <b>Q.英語を教わっているというよりは、コーチングを受けているという感じがしたか?</b>
                                                        <p>

                                                            A.私の場合は当初(今も)英語を「学ぶ」モチベーションは相当低く「学習」という観点では全く意欲がわかない状態でし た。その中で日々の生活の中に自然に英語を流し込まれる講師の力量により「学んでいる」意識を持たず「使っている」状 態を維持できました。客観的に見ると、これが「コーチングを受けている」状態であったと思います。</p>

                                                        <b>Q.コーチは、経験豊富な語学講師でありコーチであると感じたか? </b>
                                                        <p>
                                                            A.はい。上述の通りセッションの内容や設計は日々、極端に言うとその日のセッションの中でも変化しました。そのコンテ キストの変化に追従できる一般教養の高さ、あるいは生徒のバックグラウンドや英語を使う必要のある機会を事前に捉えて 準備して頂いている点にプロフェッショナリズムを感じました。</p>

                                                        <b> Q.あなたが仕事で使用する英語に関連する役立つ語彙やフレーズをコーチは提案してくれたか? </b>
                                                        <p>
                                                            A.はい。相当高いレベルで提案してもらいました。例えば抗癌剤治療のガイドラインや、糖尿病領域についての深い説明が できるような基礎フレーズ、語彙などを「共に」獲得しました。また一般的なテキストでは記載されていないようなコンテ ンポラリな自然なフレーズや単語なども随時提案してくれたため、私の目的たる「Fluently」な会話への道筋づくりに相当 役に立ちました。</p>

                                                        <b> Q.あなたの仕事に関する話題を話す機会を週5日持ったことで、あなたのスピーキング(流暢さ、抑揚、発音)とリスニン グのスキルが 向上したか? </b>
                                                        <p>
                                                            A.はい。スピーキング、リスニングともに向上したと感じますが、とくに向上を意識できるのは、流暢さ、リズム、トーン の大小高低などの「自然さ」が向上した点です。リスニングに関しては語彙充足も含めた地道な努力が必要な点において私 の怠けた性格が壁になっており、まだまだ向上の余地があると感じております。この点は次のフェーズで、新たなコーチン グ提案を期待しております。</p>

                                                        <b> Q.コースにおいて何が向上すると思うか? </b>
                                                        <p>
                                                            A.英語は学問ではなく自分のツール、自然な動作であるという認識が最も向上すると思います。</p>

                                                        <b> Q.Aspireのビジネスコミュニケーションコーチングを他の人にもすすめたいか? </b>
                                                        <p>
                                                            A.あまりに良いので、他の人に紹介したく無い思いもあります(笑) 英語獲得の必要性が高く、現在の英語レベルが高くな く、これまで自身での英語の「学習」に失敗した歴史を持つ方に特にお薦めします。 </p>
                                                        H.W.・外資系IT会社・受講9ヶ月

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header" id="headingsix">
                                            <h2 class="mb-0">
                                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsesix"><i class="fa fa-plus"></i>英語が最短時間で身につく方法が計算しつくされたトレーニング</button>
                                            </h2>
                                        </div>
                                        <div id="collapsesix" class="collapse" aria-labelledby="headingsix" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="acc-container" style="display: block;">
                                                   <b> Q. 一般的な英語の授業と、コーチングとの主な違いは何か？ </b>
                                                    <p>
                                                        A. コーチングの方が、授業よりも、自然に自ら主体的に学べる。コーチングによって、意欲的に英語を身につけることができる。</p>

                                                    <b>Q. 英語を教わっているというよりは、コーチングを受けているという感じがしたか？ </b>
                                                    <p>
                                                        A. コーチングを受けている感じがする時もあるが、コーチングによって自然に、自分でも気づかずに、英語が身についている時もたくさんある。</p>

                                                    <b>Q. コーチは、経験豊富な語学講師でありコーチであると感じたか？ </b>
                                                    <p>
                                                        A. はい。経験が非常に豊かな語学講師であり、コーチだ。話題をたくさん持っているため、英語での日常会話や役立つ表現をたくさん学べる。また、受講生の苦手なポイントを狙い撃ちして改善してくれるので、英語の力が効果的に、飛躍的に向上できる。優秀な講師・コーチでなかったら、こういう指導はできない。</p>

                                                    <b>Q. あなたが仕事で使用する英語に関連する役立つ語彙やフレーズをコーチは提案してくれたか？ </b>
                                                    <p>
                                                        A. はい。私が仕事柄使う英語のフレーズや、日常会話で使えるフレーズをコーチはたくさん教えてくれた。</p>

                                                   <b> Q. あなたの仕事に関する話題を話す機会を週5日持ったことで、あなたのスピーキング（流暢さ、抑揚、発音）とリスニングのスキルが向上したか？</b>
                                                    <p>
                                                        A. はい。私の場合は、特にスピーキングのスキルが向上した。リスニングは、あまりに早い英会話はまだ聞き取りにくいが、Aspireで学ぶ前に比べれば、断然スキルアップした。これらばかりでなく、最も効果があったのは、英語への苦手意識が大幅に減ったことだ。</p>

                                                    <b> Q. コースにおいて何が向上すると思うか？</b>
                                                    <p>
                                                        A. 1. 英語を聞き、英語で考え、英語で話すことが向上する
                                                        2. その人が最も英語を使う場面（例えば私の場合ならビジネス）で使える英語の表現が向上する
                                                        3. 英語を効果的に学ぶための様々な工夫ができるようになる</p>

                                                   <b> Q. Aspireのビジネスコミュニケーションコーチングを他の人にもすすめたいか？ </b>
                                                    <p>
                                                        A. はい、もちろん！Aspireのコーチは、英語・日本語といった言語に精通しているだけでなく、神経言語学にも精通している。したがって、ただの英語の授業ではなく、英語と日本語の言語や文化の違いを理解し、どう考えたら英語が最短時間で身につくか？が計算されたトレーニングを受けることができる。また、コーチングスキルも非常に高い。その人が理解しやすいように、その人が自発的に取り組んでいくように、様々なコーチングスキルを駆使している。これから英語のビジネスコミュニケーションを学びたい人には、ぜひお勧めする。</p>
                                                    H.T.・外資系IT会社・受講6ヶ月
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card">
                                        <div class="card-header" id="headingseven">
                                            <h2 class="mb-0">
                                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseseven"><i class="fa fa-plus"></i>聞く、話す、読む、書く、すべての英語力が向上</button>
                                            </h2>
                                        </div>
                                        <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="acc-container" style="display: block;">
                                                    <b> Q: 一般的な英語の授業と、コーチングとの主な違いは何か？</b>
                                                    <p>
                                                        Ａ：スクールのカリキュラムによる英語授業ではなく、私自身の目的を達成するための授業展開を先生とともに構築できる点です。</p>

                                                    <b> Q: 英語を教わっているというよりは、コーチングを受けているという感じがしたか？</b>
                                                    <p>
                                                        Ａ：生徒が主体的に学習に関われるような工夫を先生がとってくださり、また、授業を通して英語だけでなく自己成長を感じています。そういう意味で、コーチングを受けていると感じることができます。</p>

                                                    <b> Q: コーチは、経験豊富な語学講師でありコーチであると感じたか？</b>
                                                    <p>
                                                        Ａ．はい。英語やコーチングだけではなく ビジネスにも精通されており、豊かな内容の会話やレッスンを行っていただくことができます。</p>

                                                    <b> Q: あなたが仕事で使用する英語に関連する役立つ語彙やフレーズをコーチは提案してくれたか？</b>
                                                    <p>
                                                        Ａ．はい。私自身、英語での会議前に、課題をもって先生に駆け込むこともよくあります。
                                                        自分の意見を伝えるためにすぐに活用できる語彙やフレーズを学び、すぐに仕事の場面でアウトプットして使うことができます。その結果、億劫だった英語での電話会議やプレゼンといった場面でも 以前より自信をもって自分の立場や意見を発言し、アクティブなコミュニケーションが図れるようになってきていることは大変 嬉しい成果です。</p>

                                                    <b> Q: あなたの仕事に関する話題を話す機会を週5日持ったことで、あなたのスピーキング（流暢さ、抑揚、発音）とリスニングのスキルが向上したか？</b>
                                                    <p>
                                                        Ａ：即座に職場で話さないといけない話題を毎日先生と英語で会話すことで、いい意味でリスニングやスピーキングに「慣れ」ていきます。また「毎日話す」「復習する」という日課が自分への心地よいプレッシャーもなり、スキル向上に役立っていると感じます。</p>


                                                    <b> Q: コースにおいて何が向上すると思うか？</b>
                                                    <p>
                                                        Ａ：自分が学びたい分野の「聞く」、「話す」、「読む」、「書く」、すべての英語力とともに、英語に対する自分が持つ不安の払拭、自信の向上。</p>

                                                    <b> Q: Aspireのビジネスコミュニケーションコーチングを他の人にもすすめたいか？</b>
                                                    <p>
                                                        Ａ．本気で英語に向き合いたい、今、確実に自分の英語力に変革を起こしたい、と感じている方にはお勧めします。</p>
                                                    I.K.・外資系IT会社・受講12ヶ月
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header" id="headingeight">
                                            <h2 class="mb-0">
                                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseeight"><i class="fa fa-plus"></i>英語力はもちろん、プレゼンスキルも身につく</button>
                                            </h2>
                                        </div>
                                        <div id="collapseeight" class="collapse" aria-labelledby="headingeight" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="acc-container" style="display: block;">
                                                    <b> Q: 一般的な英語の授業と、コーチングとの主な違いは何か？</b>
                                                    <p>
                                                        A: 一般的な英語レッスンでは、教室で用意したテキストがあり、その内容に沿って授業が進められます。一方コーチングでは、生徒自身にフォーカスが当てられ、個人の業務を英会話を通じて深堀りすることで、すぐに直接役立つ形でトレーニングできます。</p>

                                                    <b> Q: 英語を教わっているというよりは、コーチングを受けているという感じがしたか？</b>
                                                    <p>
                                                        A: はい。先生の手本ありきで会話するのではなく、まずは間違えてもよいから自分で考えて発言するよう促されていると感じます。そしてもし間違いがあれば、訂正の指摘があり、正しい言い回しを身に着けることができます。</p>

                                                    <b> Q: コーチは、経験豊富な語学講師でありコーチであると感じたか？</b>
                                                    <p>
                                                        A: はい。日本人にありがちな間違えるポイントを理解していて、うまく導いてくれています。</p>

                                                    <b> Q: あなたが仕事で使用する英語に関連する役立つ語彙やフレーズをコーチは提案してくれたか？</b>
                                                    <p>
                                                        A: はい。レッスンで仕事の内容を話しているので、関連するボキャブラリーやより自然なフレーズを紹介してもらえています。</p>

                                                    <b> Q: あなたの仕事に関する話題を話す機会を週5日持ったことで、あなたのスピーキング（流暢さ、抑揚、発音）とリスニングのスキルが向上したか？</b>
                                                    <p>
                                                        A: とくにスピーキングについては向上したように感じます。考えながら途切れ途切れに話していたのが、すらすらと一文が出てくるようになってきています。</p>

                                                    <b> Q: コースにおいて何が向上すると思うか？</b>
                                                    <p>
                                                        仕事に直結する英語力だけでなく、ビジネスにおいて顧客を説得するプレゼンテーションスキルも身に付くと思います。</p>

                                                    <b> Q: Aspireのビジネスコミュニケーションコーチングを他の人にもすすめたいか？</b>
                                                    <p>
                                                        A: はい。ビジネス英語のコミュニケーションに困っている人がいれば紹介したいです。</p>
                                                    K.N.・外資系IT会社・受講3ヶ月
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card">
                                        <div class="card-header" id="headingnine">
                                            <h2 class="mb-0">
                                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsenine"><i class="fa fa-plus"></i>海外の顧客とのコミュニケーションがスムーズに！く</button>
                                            </h2>
                                        </div>
                                        <div id="collapsenine" class="collapse" aria-labelledby="headingnine" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="acc-container" style="display: block;">
                                                    <p>私が、コーチングレッスンを受講するきっかけとなったのは、国内営業から、海外事業部への異動でした。それまで、ビジネスシーンで英語を使ったことがなかった私は、海外の方と、英語で仕事をするということに非常に不安をおぼえておりました。</p>

                                                    <p>そこで、自信と知識を身につけるべく、コーチングレッスンを受けることを決意しました。
                                                        当初は、去年まで受けていたレギュラーレッスン（週に１回、30分間）と比べ、コーチングレッスンは週２回 Face to Faceでの１時間の授業に、週３回 電話での10分間のレッスンとのことで、かなりハードなのではないか、やっていけるのだろうか、正直不安でした。</p>

                                                    <p>コーチングレッスンを始めるにあたって、この授業を受ける目的、3ヶ月後、どういう風になっていたいかを、Ryan先生とじっくり話しあいました。</p>

                                                    <p>始めて一ヶ月半くらい経ったころ、わたしは自分の聞き取り能力が確実に上がっていると感じました。それは、授業の課題として、huluという動画サイトで、海外ドラマを英語のサブタイトルで観ており、暫く続けていたところ、当初は、サブタイトルと追うのに必死だったのに、耳でだいたいの会話を聞き取れるようになっていたのです。</p>

                                                    <p>それに気付いたわたしは、自分の英語がスキルアップしていることを実感するのが楽しくなり、課題でもない映画を日本語ではなく、英語の字幕でみるようになったり、前まで日本語で読んでいたビューティー系やアート系の記事を英語でみるようになりました。</p>

                                                    <p>また、ビジネススクールなどに通ったことがない私に、海外ビジネスの基本的な挨拶の仕方から、メールの打ち方、プレゼンのやり方を、細かく学ぶことができ、それはとても効果的でした。それは、下記のようなことです。</p>

                                                    <p>1.コミュニケーションについて<br>
                                                        日本の海外は、コミュニケーションの取り方に大きな違いがあります。日本人は、「本音と建前」の世界ですから、発言ひとつに対して、これを言うことで、相手にどう思われるか考え、自分が本当に思っていることは伏せる節があります。わたしも、コーチングを受ける前までは、このスタイルをとっており、相手に対して、はっきりNoと言うことが出来ませんでした。しかし、コーチングにおいて、海外ビジネスにおけるコミュニケーションの取り方を学び、相手に対して、いかに正直になり、胸の内を明かすことが、相手に信用してもらえるかに繋がっていくと学びました。そこで、私は、自分が思っていることをはっきり伝えるようになり、「Maybe」や「I think」など曖昧な言葉も避けるよう、努力しました。そうすることで、韓国、香港、アメリカ、ヨーロッパの人々とよりスムーズにコミュニケーションがとれるようになりました。</p>

                                                    <p>2.プレゼンテーション<br>
                                                        わたしが、コーチングを受け始めたばかりのときに、秋冬の新商品の展示会があり、チェコからお客さんがきました。そのときは、商品の素材や、特徴、使い方など、スムーズに説明できず、とても歯がゆい想いをしました。しかし、その後、秋冬商品のプレゼンをするレッスンを積み重ね、商品を描写するのに必要なさまざまな単語を習得していきました。そして、２週間経った頃、展示会で香港からお客さんがきました。そこで、チェコのお客さんのときに伝えられなかったことを、スムーズに伝えることができ、オーダーもとることができました。このプレゼンの練習は、人前でしっかりと説明するという度胸もつき、実際にビジネスにおいても成果が発揮されました。</p>

                                                    <p>3.メール<br>
                                                    </p><p>コーチングを受ける前、海外事業に移動したてだったわたしは、ひとつのメールをうつのに、多くのの単語をネットで調べては、メールをうっていたので、5分の時間を費やしていました。しかし、今では、調べることなく、メールを打てるようになったので、かなりの時間短縮になり、仕事が捗るようになりました。</p>

                                                    <p>コーチングレッスンは、先生が細く、その人にあった英語の指導をしてくれます。そうすることで、英語を学ぶためのただの学問とするのではなく、英語が受講者の生活の一部となるよう、高めていくことができます。</p>

                                                    <p>通常のレッスンとの大きな違いは、受講者の思考傾向や性格、得意なこと、苦手なこと、全てを理解しながらレッスンを進めてくれるので、その人にあったレッスンを受けられるというところです。</p>

                                                    <p>わたしは、とてもこのコーチングレッスンに満足していて、皆にもオススメしたく思います。</p>

                                                    R.N.・海外事業部・インテリアメーカー・受講6ヶ月
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header" id="headingeight">
                                            <h2 class="mb-0">
                                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseeight"><i class="fa fa-plus"></i>突然のNY勤務。コーチングがあってよかった！く</button>
                                            </h2>
                                        </div>
                                        <div id="collapseeight" class="collapse" aria-labelledby="headingeight" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="acc-container" style="display: block;">
                                                    <p>Accentのレギュラーコースを受けていたのですが、6カ月のNY勤務が決まったためさらなる英語力の強化をと、コーチングレッスンを受けることにしました。</p>
                                                    <p>当初はレギュラーコースとコーチングレッスンは何が違うのかと思っていましたが、その違いは歴然でした。週2回のコーチングコース、そしてクラスがない日には15分ほどの電話レッスン、毎日の課題及び自由学習などレギュラーコースにはない徹底して英語に関わるカリキュラムでした。</p>

                                                    <p>NY勤務までは6週間ほどしか時間がなく、その限られた時間で「自分はどうなりたいのか、どうならなければいけないのか」の目標とモチベーションを明確にし、その目標達成のためにライアン先生が私に合ったカリキュラムを作ってくださいました。</p>

                                                    <p>レッスンでは多くのビジネスに関わる英単語、知識をインプットし、そして電話レッスンではそのインプットした知識をアウトプットする。そうやって日々新しい教材を使い、そして新しく得た単語・知識を80%以上アウトプットしていきました。そして、ライアン先生とビジネスシーンを想定したロールプレイングすることで日米のコミュニケーションの違いを学びました。</p>

                                                    <p>そして5週間で計300ほどの英単語、フレーズをロールプレイングやレッスンの中で自分のものにできるようになりました。当初苦手だった電話レッスンも回を重ねるごとに段々と聞き取れるようになり、また、Huluなどで英語の番組を観ることによって最終的にはリスニング力が目覚ましく成長しました。　そしてそれと同時に上司に注意されていた発音やイントネーションも大きく成長しました。</p>

                                                    <p>現在NYに来て約2カ月が経とうとしていますが、コーチングレッスンで学んだことが大いに活かされています。</p>

                                                    R.M.・海外事業部・インテリアメーカー・受講6ヶ月
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="business_sec">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="pricing">{{__('labels.aspire_pricing')}}</h3>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive pricing_table">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('labels.aspire_description')}}</th>
                                        <th scope="col">{{__('labels.aspire_price')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{__('labels.aspire_registration_one_off')}}</td>
                                        <td>29,900</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_onepage_system_annual')}}</td>
                                        <td>5,900</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_inteal_total')}}</td>
                                        <td>35,800</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-12">
                            <h4 class="sub_pricing_hd">{{__('labels.aspire_couching_session_price')}}</h4>
                            <div class="table-responsive pricing_table">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('labels.aspire_description')}}</th>
                                        <th scope="col">{{__('labels.aspire_price')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{__('labels.aspire_60_minutes')}}</td>
                                        <td>20,000</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_90_minutes')}}</td>
                                        <td>30,000</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-12">
                            <h4 class="sub_pricing_hd">{{__('labels.aspire_group_price')}}</h4>
                            <div class="table-responsive pricing_table">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('labels.aspire_description')}}</th>
                                        <th scope="col">2 {{__('labels.aspire_client')}}</th>
                                        <th scope="col">3 {{__('labels.aspire_client')}}</th>
                                        <th scope="col">4 {{__('labels.aspire_client')}}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{__('labels.aspire_60_minutes')}} / {{__('labels.aspire_client')}}</td>
                                        <td>15,000</td>
                                        <td>13,333</td>
                                        <td>12,500</td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12">
                            <h4 class="sub_pricing_hd">{{__('labels.aspire_frequency')}}</h4>
                            <div class="table-responsive pricing_table">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('labels.aspire_frequency_description')}}</th>
                                        <th scope="col">{{__('labels.aspire_sessions')}}</th>
                                        <th scope="col">{{__('labels.aspire_time_min')}}</th>
                                        <th scope="col">{{__('labels.aspire_term_days')}}</th>
                                        <th>{{__('labels.aspire_price')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{__('labels.aspire_once_a_week')}}</td>
                                        <td>1</td>
                                        <td>60</td>
                                        <td>7</td>
                                        <td>20,000</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_once_a_week')}}</td>
                                        <td>1</td>
                                        <td>90</td>
                                        <td>7</td>
                                        <td>30,000</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_once_a_week')}} • {{__('labels.aspire_3_months')}}</td>
                                        <td>12</td>
                                        <td>60</td>
                                        <td>90</td>
                                        <td>216,000</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_once_a_week')}} • {{__('labels.aspire_3_months')}}</td>
                                        <td>12</td>
                                        <td>90</td>
                                        <td>90</td>
                                        <td>306,000</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_twise_a_week')}} • {{__('labels.aspire_3_months')}}</td>
                                        <td>12</td>
                                        <td>24</td>
                                        <td>60</td>
                                        <td>432,000</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_twise_a_week')}} • {{__('labels.aspire_3_months')}}</td>
                                        <td>24</td>
                                        <td>90</td>
                                        <td>90</td>
                                        <td>612,000</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12">
                            <h4 class="sub_pricing_hd">{{__('labels.aspire_business_lesson_price')}}</h4>
                            <div class="table-responsive pricing_table">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('labels.aspire_description')}}</th>
                                        <th scope="col">{{__('labels.aspire_price')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{__('labels.aspire_50_minutes')}}</td>
                                        <td>6,000</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-12">
                            <h4 class="sub_pricing_hd">{{__('labels.aspire_group_price')}}</h4>
                            <div class="table-responsive pricing_table">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('labels.aspire_description')}}</th>
                                        <th scope="col">2 {{__('labels.aspire_client')}}</th>
                                        <th scope="col">3 {{__('labels.aspire_client')}}</th>
                                        <th scope="col">4 {{__('labels.aspire_client')}}</th>
                                        <th scope="col">5 {{__('labels.aspire_client')}}</th>
                                        <th scope="col">6 {{__('labels.aspire_client')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{__('labels.aspire_60_minutes')}} / {{__('labels.aspire_client')}}</td>
                                        <td>15,000</td>
                                        <td>13,333</td>
                                        <td>12,500</td>
                                        <td>12,500</td>
                                        <td>12,500</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="col-12">
                            <h4 class="sub_pricing_hd">{{__('labels.aspire_frequency')}}</h4>
                            <div class="table-responsive pricing_table">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('labels.aspire_frequency_description')}}</th>
                                        <th scope="col">{{__('labels.aspire_sessions')}}</th>
                                        <th scope="col">{{__('labels.aspire_time_min')}}</th>
                                        <th scope="col">{{__('labels.aspire_term_days')}}</th>
                                        <th>{{__('labels.aspire_price')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{__('labels.aspire_once_a_week')}}</td>
                                        <td>1</td>
                                        <td>60</td>
                                        <td>7</td>
                                        <td>20,000</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_once_a_week')}}</td>
                                        <td>1</td>
                                        <td>90</td>
                                        <td>7</td>
                                        <td>30,000</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_once_a_week')}} • {{__('labels.aspire_3_months')}}</td>
                                        <td>12</td>
                                        <td>60</td>
                                        <td>90</td>
                                        <td>216,000</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_once_a_week')}} • {{__('labels.aspire_3_months')}}</td>
                                        <td>12</td>
                                        <td>90</td>
                                        <td>90</td>
                                        <td>306,000</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_once_a_week')}} • {{__('labels.aspire_3_months')}}</td>
                                        <td>12</td>
                                        <td>24</td>
                                        <td>60</td>
                                        <td>432,000</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_once_a_week')}} • {{__('labels.aspire_3_months')}}</td>
                                        <td>24</td>
                                        <td>90</td>
                                        <td>90</td>
                                        <td>612,000</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">* {{__('labels.aspire_all_prices_exclude_tax')}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="business_sec">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="pricing">{{__('labels.aspire_feature')}}</h3>
                        </div>
                        <div class="col-12">
                            <p><span class="pr-3"><img src="{{asset('')}}images/tick.png"> - {{__('labels.aspire_available')}} </span><span><img src="images/TRINGLE.png"> - {{__('labels.aspire_possible')}} </span></p>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive pricing_table">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('labels.aspire_description')}}</th>
                                        <th scope="col">{{__('labels.aspire_couching')}}</th>
                                        <th scope="col">{{__('labels.aspire_accent_bussiness_english')}}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{__('labels.aspire_icf_certified')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="{{asset('')}}images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_icf_code')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="{{asset('')}}images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_icf_confidentiality')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="{{asset('')}}images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_non_disclosure')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><img src="{{asset('')}}images/TRINGLE.png"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_couching_insite')}}</td>
                                        <td></td>
                                        <td><!-- <img src="images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_couching_5_piller')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="images/TRINGLE.png"> --></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_the_learning')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_6_insite_into')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_brains_organizing')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_scarf')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_couching_models')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_5c_couching')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_result_couching')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_3ms')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_feeling')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_images')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_dance_of_insight')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_create')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_progress')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_system_and_reporting')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><!-- <img src="images/TRINGLE.png"> --></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_accent_onepage')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_curriculum_customisation')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><img src="{{asset('')}}images/TRINGLE.png"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_english_teaching')}}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_TEFL')}}</td>
                                        <td><img src="{{asset('')}}images/TRINGLE.png"></td>
                                        <td><img src="{{asset('')}}images/TRINGLE.png"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_TESL')}}</td>
                                        <td><img src="{{asset('')}}images/TRINGLE.png"></td>
                                        <td><img src="{{asset('')}}images/TRINGLE.png"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_TESOL')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><img src="{{asset('')}}images/TRINGLE.png"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_ICF')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><img src="{{asset('')}}images/TRINGLE.png"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_english_5_day_week')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_business')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_TOEIC')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_TOEFL')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_IELTS')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><img src="{{asset('')}}images/TRINGLE.png"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_EIKEN')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><img src="{{asset('')}}images/TRINGLE.png"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_BULATS')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><img src="{{asset('')}}images/TRINGLE.png"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_session_lesson_location')}}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_company')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_cafe')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_learning_center')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_virtually')}}</td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td><img src="{{asset('')}}images/tick.png"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_session_lesson_cancel_policy')}}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_flexible')}}</td>
                                        <td><img src="{{asset('')}}images/TRINGLE.png"></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_fixed')}}</td>
                                        <td><img src="{{asset('')}}images/TRINGLE.png"></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('labels.aspire_group_classes')}}</td>
                                        <td><img src="{{asset('')}}images/TRINGLE.png"></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@push('script')

    <script type="text/javascript">
        //set content bottom padding
        $("#content").css("padding-bottom", $("footer").outerHeight()+'px');
        $("#content").css("padding-top", $("header").outerHeight()+'px');

        $(document).ready(function(){
            // Add minus icon for collapse element which is open by default
            $(".collapse.show").each(function(){
                $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
            });

            // Toggle plus minus icon on show hide of collapse element
            $(".collapse").on('show.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
            }).on('hide.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
            });
        });
    </script>

@endpush
@endsection
