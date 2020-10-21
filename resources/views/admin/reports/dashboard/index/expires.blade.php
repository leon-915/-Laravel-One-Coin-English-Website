<script type="text/javascript">
	var canvas = document.getElementById("expires-chart");
    var ctx = canvas.getContext('2d');

    // Global Options:
    Chart.defaults.global.defaultFontColor = 'black';
    Chart.defaults.global.defaultFontSize = 16;

    var data = {
        labels: <?=  json_encode($expireData['lables']) ?>,
        datasets: [{
                label: "Course Expiring",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "#369ead",
                borderColor: "#369ead", // The main line color
                borderCapStyle: 'square',
                borderDash: [], // try [5, 15] for instance
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "black",
                pointBackgroundColor: "white",
                pointBorderWidth: 1,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: "#369ead",
                pointHoverBorderColor: "#369ead",
                pointHoverBorderWidth: 2,
                pointRadius: 4,
                pointHitRadius: 6,
                // notice the gap in the data and the spanGaps: true
                data: <?= !empty($expireData['data']) ? json_encode($expireData['data']) :  json_encode([])?>,
                spanGaps: true,
            }
        ]
    };

    // Notice the scaleLabel at the same level as Ticks
    var options = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        },
        title: {
            display: true,
            text: 'Course Expiring'
        },
        legend: {
            display: false,
        }
    };

    // Chart declaration:
    var myBarChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
    });
</script>
