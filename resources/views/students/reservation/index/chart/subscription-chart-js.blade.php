<?php
    // echo '<pre>';
    // print_r($package->toArray());
    // echo '</pre>';
    /* $credit_balance = !empty($studentDetails->credit_balance) ? $studentDetails->credit_balance : 0;
    $reward_balance = !empty($studentDetails->reward_balance) ? $studentDetails->reward_balance : 0;
    $total_balance  = $credit_balance+$reward_balance; */
    $spent_balance  = $totalPointsPackages - $credit_balance;
    if($spent_balance < 0){
        $spent_balance  = 0;
    }

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

        var statusCanvas = document.getElementById("subscription-point-chart");

        var statusChartData = {
            labels: ["{{__('labels.stu_used')}}", "{{__('labels.stu_available')}}"],
            datasets: [{
                backgroundColor: colors.slice(0, 5),
                borderWidth: 0,
                data: [
                    <?= $spent_balance ?>,
                    <?= $credit_balance ?>,
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
