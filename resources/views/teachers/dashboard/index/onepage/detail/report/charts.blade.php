<div class="row">
    <div class="col-12 col-lg-6">
        <canvas id="lesson-rating" width="300" height="200"></canvas>
    </div>
    <div class="col-12 col-lg-6">
        <canvas id="status-charts" width="300" height="200"></canvas>
    </div>
</div>

<?php
    $CA = !empty($booking->ca_rating) ? $booking->ca_rating : 0;
    $FP = !empty($booking->fp_rating) ? $booking->fp_rating : 0;
    $LC = !empty($booking->lc_rating) ? $booking->lc_rating : 0;
    $V = !empty($booking->v_rating) ? $booking->v_rating : 0 ;
    $GA = !empty($booking->ga_rating) ? $booking->ga_rating : 0;
    $AVE = ($CA + $FP + $LC + $V + $GA)/ 5;
?>

<script type="text/javascript">

    chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)'
    };
    var marksCanvas = document.getElementById("lesson-rating");

    var marksData = {
        labels: ["AVE","CA", "FP", "LC", "V", "GA"],
        datasets: [{
            label : 'Average Ratings',
            pointBackgroundColor: "#e6f9f4",
            backgroundColor: "#7ec4caa6",
            pointHoverBackgroundColor: "#7ec4ca",
            borderColor: "#7ec4ca",
            data: [
                <?= $AVE ?>,
                <?= $CA ?>,
                <?= $LC ?>,
                <?= $V ?>,
                <?= $GA ?>,
                <?= $AVE ?>
            ]
        }]
    };

    var radarChart = new Chart(marksCanvas, {
        type: 'radar',
        data: marksData,
        scaleOverride: true,

        scaleStepWidth: 0.5,
        scaleStartValue: 0,

        options : {
            scale: {
                ticks: {
                    beginAtZero : true,
                    max: 6,
                    stepSize :1
                }
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: '#7ec4ca'
                }
            },
            maintainAspectRatio: true,
        }
    });


    var colors = ['#062039', '#032e56', '#125a93', '#1ba1d7', '#ddebfc'];

    /* 3 donut charts */
    var donutOptions = {
        cutoutPercentage: 85,
        responsive : true,
        legend: {
            position: 'bottom',
            padding: 20,
            labels: {
                pointStyle: 'circle',
                usePointStyle: true
            }
        }
    };

    var statusCanvas = document.getElementById("status-charts");

    var statusChartData = {
        labels: ["X", "O", "△", "□"],
        datasets: [{
            backgroundColor: colors.slice(0, 5),
            borderWidth: 0,
            data: [
                <?= !empty($statusData['1']) ? $statusData['1'] : 0 ?>,
                <?= !empty($statusData['2']) ? $statusData['2'] : 0 ?>,
                <?= !empty($statusData['3']) ? $statusData['3'] : 0 ?>,
                <?= !empty($statusData['4']) ? $statusData['4'] : 0 ?>
            ]
        }]
    };

    new Chart(statusCanvas, {
        type: 'pie',
        data: statusChartData,
        options: donutOptions,
        maintainAspectRatio: false,
    });
</script>
