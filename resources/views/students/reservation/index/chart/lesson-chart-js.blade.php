@if(!empty($individualServices) && $individualServices->toArray())
    @foreach ($individualServices as $ser)
		
        <?php
		$n=1;
            $totalLessons = ($ser->service->available_lessons + $ser->free_lessons);
            $available_bookings = $ser->available_bookings;
            $usedLessons = $totalLessons - $ser->available_bookings;

            if($usedLessons < 0){
                $usedLessons = 0;
            }
            if($ser->service->is_available_in_trial != 1){
        ?>
            <script>
                //var colors = ['#eee', '#002d57'];
                var colors = ['#002d57', '#eee'];

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

                var statusCanvas = document.getElementById("lesson-used-chart-{{ $ser->id}}");

                var statusChartData = {
                    labels: ["{{__('labels.stu_used')}}", "{{__('labels.stu_remaining')}}"],
                    datasets: [{
                        backgroundColor: colors.slice(0, 2),
                        borderWidth: 0,
                        data: [
                            <?php echo $usedLessons; ?>,
                            <?php echo $available_bookings; ?>,
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
        <?php } 
		$n++;?>
    @endforeach
@endif

