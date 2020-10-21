<div class="lesson_record_sec">
    <div class="row clearfix">
        <div class="col-12">
            <h4>You have taught {{ !empty($earnings['thought']) ? $earnings['thought']: '0' }} lessons. Total earning :
                {{ !empty($earnings['earnings']) ? number_format($earnings['earnings'],2) : '0.00' }} JPY</h4>
           {{--  <span class="header_span">Lesson record to be Updated / Lesson record</span> --}}
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-9 col-md-9 col-12">
            <div id="lesson_date_filters" class="form_dashboard" style="display:none">
                <div class="half_form">
                    <button  class="btn btn-primary-outline btn-filter" id="lesson_30">Last 30 Days</button>
                    <button  class="btn btn-primary-outline btn-filter" id="lesson_60">Last 60 Days</button>
                    <button  class="btn btn-primary-outline btn-filter" id="lesson_90">Last 90 Days</button>
                </div>
                <div class="half_form">
                    <div class="form-group from">
                        <div class="frm_icon">
                            <span><i class="fas fa-calendar-day"></i></span>
                            <input type="text" autocomplete="off" name="lesson_from" id="lesson_from" placeholder="From" class="form-control timepicker">
                        </div>
                        <div class="frm_icon">
                            <span><i class="fas fa-calendar-day"></i></span>
                            <input type="text" autocomplete="off" name="lesson_to" id="lesson_to" placeholder="To" class="form-control timepicker">
                        </div>
                        <button class="freetrial_btn" id="btn-filter-lesson">Go</button>
                    </div>
                </div>
                <input type="hidden" name="from">
                <input type="hidden" name="to">
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-12">
            <div class="data_filter" id="date_filter">
                <a href="" class="btnsub_arr">
                    Date Filter
                </a>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-12">
            <div class="table-responsive table_custom">
            	<div class="lesson-teacher-table">
                    <table class="table" id="lessons-table" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Sr</th>
                                <th scope="col">Service</th>
                                <th scope="col">Lesson Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Student</th>
                                <!--th scope="col">Location</th-->
                                <th scope="col">Duration</th>
                                <th scope="col">Status</th>
                                <th scope="col">Earning(¥)</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
