<div class="one_pg_tab stud">
    <div class="row">
        <div class="col-12">
            <h2 class="chart_header">{{ isset($currBookingIndx) ? $currBookingIndx : ''}} {{ ucfirst($booking->student->firstname) }} {{ ucfirst($booking->student->lastname) }} | Accent OnePage {{ $booking['onepage_title'] }}
            </h2>
        </div>
    </div>

    <!-- charts -->
    <div class="chart_part chart_slider">
        @include('students.onepage.index.onepage.charts')
    </div>
    <!-- charts -->
    <!-- questions -->
    <div class="questions_sec p-4">
        @include('students.onepage.index.onepage.canvas')
    </div>

    <!-- lesson topic -->
    <div class="lesson_chart">
        @include('students.onepage.index.onepage.topics')
    </div>
    <!-- lesson topic -->
    <!-- accordian  -->
    <div class="row">
        @include('students.onepage.index.onepage.details')
    </div>
    <!-- accordian -->
</div>

<!--div class="bottom btns-wrapper">
    <a href="{{ route('students.onepage.generate.pdf').'?booking_id='.$booking->id }}" class="btn-pdf" target="_blank" data-booking_id="{{ $booking->id }}">
        {{__('labels.btn_pdf')}}
    </a>
</div-->
