
          
                <div style="width: 66%;margin: 0 auto">
                    <canvas id="serviceChart" ></canvas>
                </div>
				<div style="width: 66%;margin: 0 auto">
                    <canvas id="pie-chart-area" ></canvas>
                </div>
            
            

	<script src="{{asset('js/Chart.min.js')}}"></script>

        
            <script>
                // Return with commas in between
                var numberWithCommas = function (x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                };
                var bar_ctx2 = document.getElementById('serviceChart');
                var bar_chart2 = {
                    type: 'bar',
                    data: {
                        labels:<?php echo json_encode($lessionsData['lables']); ?>,
                        datasets: [
                            {
                                label: 'Earning',
                                data: <?php echo !empty($lessionsData['data']) ? json_encode($lessionsData['data']) : json_encode([])?>,
                                backgroundColor: "rgba(55, 160, 225, 0.7)",
                                hoverBackgroundColor: "rgba(55, 160, 225, 0.7)",
                                hoverBorderWidth: 2,
                                hoverBorderColor: 'lightgrey'
                            }
                        ]
                    },
                    options: {
                        animation: {
                            duration: 10
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    console.log(tooltipItem, data);
                                    return data.datasets[tooltipItem.datasetIndex].label + ": " + numberWithCommas(tooltipItem.yLabel)+'jpy';
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                stacked: true,
                                gridLines: {display: false},
                            }],
                            yAxes: [{
                                stacked: true,
                                gridLines: {display: false},
                                // ticks: {
                                //     callback: function(value) {
                                //         return 5 },
                                // },
                                // display: true,
                                ticks: {
                                    min: 0,
                                    stepSize: 5,
                                    maxTicksLimit: 20
                                }
                            }],
                        }, // scales
                        legend: {display: true}
                    } // options
                };
                new Chart(bar_ctx2, bar_chart2)
				
				var randomScalingFactor = function() {
			return Math.round(Math.random() * 100);
		};

		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data: [
						'<?php echo $fav_cnt;?>',
						'<?php echo $session_cnt;?>',
					],
					backgroundColor: [
						'#FFFFFF',
						'#0000FF',
					],
					label: 'Dataset 1'
				}],
				labels: [
					'Favorites',
					'Sessions',
				]
			},
			options: {
				responsive: true
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('pie-chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};
		
            </script>
	<script>		
    /*var colors = null;
    var donutOptions = null;
    var serviceChartData = null;
    var serviceChart = null;

    var studentChartData = null;
    var studentChart = null;

    var colors = ['#062039','#032e56','#125a93','#1ba1d7','#ddebfc','#e1e1e1'];
    // var colors = ['#062039', '#1b91ff', '#e6e6e6', '#b2e9ff', '#fff9b2'];

    
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

    // serviceChartData
    var serviceChartData = {
        labels: <?php echo json_encode(!empty($topServicesData['labels']) ? $topServicesData['labels'] : []) ?>,
        datasets: [{
            backgroundColor: colors.slice(0, 5),
            borderWidth: 0,
            data: <?php echo json_encode(!empty($topServicesData['values']) ? $topServicesData['values'] : []) ?>,
        }]
    };

    var serviceChart = document.getElementById("serviceChart");
    if (serviceChart) {
        serviceChart.height = 300;
        serviceChart.width = 300;
        new Chart(serviceChart, {
            type: 'pie',
            data: serviceChartData,
            options: donutOptions,
            maintainAspectRatio: false,
        });
    }

    var studentChartData = {
        labels: <?php echo json_encode(!empty($topStudentsData['labels']) ? $topStudentsData['labels'] : []) ?>,
        datasets: [{
            backgroundColor: colors.slice(0, 5),
            borderWidth: 0,
            data: <?php echo json_encode(!empty($topStudentsData['values']) ? $topStudentsData['values'] : []) ?>,
        }]
    };

    var studentChart = document.getElementById("studentsChart");
    if (studentChart) {
        studentChart.height = 300;
        studentChart.width = 300;
        new Chart(studentChart, {
            type: 'pie',
            data: studentChartData,
            options: donutOptions,
            maintainAspectRatio: false,
        });
    }*/
</script>
