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

    var statusCanvas = document.getElementById("reward-point-chart");

    var statusChartData = {
        labels: ["{{__('labels.stu_reward_points')}}", "{{__('labels.stu_total_point')}}"],
        datasets: [{
            backgroundColor: colors.slice(0, 5),
            borderWidth: 0,
            data: [
                <?= $reward_balance ?>,
                <?= $total_balance ?>,
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
