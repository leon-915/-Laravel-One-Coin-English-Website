@if($booking->status=='completed')
    @include('teachers.dashboard.index.onepage.detail.report.charts')
@endif

<div class="row">
    <div class="col-12">
        <div class="suzuki_cafe_area">
            @include('teachers.dashboard.index.onepage.detail.canvas')
        </div>
        <!-- Accordian Start  -->
        <div id="accordion">
            @if($drive_id)
                <div class="card">
                    @include('teachers.dashboard.index.onepage.detail.report.upload')
                </div>
            @endif

            <div class="card">
                @include('teachers.dashboard.index.onepage.detail.report.previous-lesson-pdf')
            </div>

            <div class="card">
                @include('teachers.dashboard.index.onepage.detail.report.review')
            </div>

            <div class="card">
                @include('teachers.dashboard.index.onepage.detail.report.lesson-task')
            </div>

            <div class="card">
                @include('teachers.dashboard.index.onepage.detail.report.point-to-improve')
                @include('teachers.dashboard.index.onepage.detail.report.lesson-comment')
                @include('teachers.dashboard.index.onepage.detail.report.level-detail')
            </div> <!-- card over -->

            <div class="card">
                @include('teachers.dashboard.index.onepage.detail.report.student-lesson-profile')
            </div>
        </div>
        @if($booking->status=='booked')
            <div class="clearfix bottom btns-wrapper">
                <a href="javascript:void(0);" class="bottom-wrap-btn" onclick="check_homework_task();"
                   data-booking_id="{{ $studentLesson->id }}">
                    <img src="{{ asset('images') }}/onepage/icon-wrap.svg" alt="Wrap-icon">
                </a>
            </div>
        @endif
    <!-- Accordian end  -->
    </div>
</div>
<script type="text/javascript">

initForms();

</script>