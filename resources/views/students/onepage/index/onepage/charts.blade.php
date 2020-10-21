<div class="row pos_rel">
    <div class="col-12 col-lg-1 slider-btn-left">
        @if (!$isLast && $prevID)
            <a href="{{ route('students.onepage.index').'?booking_id='.$prevID }}"> <i class="fas fa-chevron-circle-left"></i></a>
        @endif
    </div>
    <div class="col-12 col-lg-5">
        <canvas id="lesson-rating" width="300" height="200"></canvas>
    </div>
    <div class="col-12 col-lg-5">
        <canvas id="status-charts" width="300" height="200"></canvas>
    </div>
    <div class="col-12 col-lg-1 text-left slider-btn-right">
        @if (!$isFirst && $nextID)
            <a href="{{ route('students.onepage.index').'?booking_id='.$nextID }}"><i class="fas fa-chevron-circle-right"></i></a>
        @endif
    </div>
</div>
