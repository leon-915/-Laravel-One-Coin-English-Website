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

@if(!empty($arpChartData) && !empty($arpChartData['data']) && !empty($arpChartData['labels']))
<script>
    /* ARP Trend Chart */
    var arpconfig = {
        type: 'line',
        data: {
            labels: [<?= implode(',', $arpChartData['labels']) ?>],
            datasets: [{
                label: 'ARP',
                backgroundColor: chartColors.blue,
                borderColor: chartColors.blue,
                data: <?= json_encode($arpChartData['data']) ?>,
                fill: false,
                lineTension: 0
            }]
        },
        options: {
            responsive: true,
            bezierCurve : false,
            lineTension:0,
            title: {
                display: false,
                text: 'ARPs'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: false,
                        labelString: 'Onepage'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'ARPs'
                    }
                }]
            }
        }
    };

    var arpCTX = document.getElementById('arp-chart');
    myLine = new Chart(arpCTX, arpconfig);
</script>
@endif
<?php
$trendskeywordsandphrases = __('labels.trendskeywordsandphrases');
$trendsphrases = __('labels.trendsphrases');
$trendskeywords = __('labels.trendskeywords');
?>
@if(!empty($keywordChartData) && !empty($keywordChartData['data']) && !empty($keywordChartData['labels']))
<script>
    /* Keywords Trend Chart */
    var keywordconfig = {
        type: 'line',
        data: {
            labels: [<?= implode(',', $keywordChartData['labels']) ?>],
            datasets: [{
                label: '<?php echo $trendskeywordsandphrases;?>',
                backgroundColor: chartColors.red,
                borderColor: chartColors.red,
                data: <?= !empty($keywordChartData['data']) ? json_encode($keywordChartData['data']) : json_encode([]) ?>,
                fill: false,
                lineTension: 0
            }]
        },
        options: {
            responsive: true,
            bezierCurve : false,
            title: {
                display: false,
                text: 'Keywords'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: false,
                        labelString: 'Onepage'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Keywords'
                    }
                }]
            }
        }
    };

    var keywordCTX = document.getElementById('keyword-chart');
    myLine = new Chart(keywordCTX, keywordconfig);
</script>
@endif

@if(!empty($keyChartData) || !empty($keyPhraseChartData))
@if((!empty($keyChartData['labels'])) && 
    ((!empty($keywordChartData['data']) && !empty($keywordChartData['labels'])) ||
    (!empty($keywordChartData['data']) && !empty($keywordChartData['labels'])))
)
<script>
    /* Keywords Trend Chart */
    var keyphraseconfig = {
        type: 'bar',
        data: {
            labels: [<?= implode(',', $keyChartData['labels']) ?>],
            datasets: [
                {
                    label: '<?php echo $trendsphrases;?>',
                    backgroundColor: chartColors.blue,
                    borderColor: chartColors.blue,
                    data: <?= !empty($keyPhraseChartData['data']) ? json_encode($keyPhraseChartData['data']) : json_encode([]) ?>,
                    stack: 'Stack 0',
                    fill: false,
                },
                {
                    label: '<?php echo $trendskeywords;?>',
                    backgroundColor: chartColors.red,
                    borderColor: chartColors.red,
                    data: <?= !empty($keyChartData['data']) ? json_encode($keyChartData['data']) : json_encode([]) ?>,
                    stack: 'Stack 0',
                    fill: false,
                },
            ]
        },
        options: {
            responsive: true,
            title: {
                display: false,
                text: 'POS'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: false,
                        labelString: 'Onepage'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'pos'
                    }
                }]
            }
        }
    };

    var keyphraseCTX = document.getElementById('keyphrase-chart');
    myLine = new Chart(keyphraseCTX, keyphraseconfig);
</script>
@endif
@endif
