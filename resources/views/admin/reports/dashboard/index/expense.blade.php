
<script type="text/javascript">
    var numberWithCommas = function(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    };

    var colors = [];
    var bcolors = [];

    @foreach ($revenueData['lables'] as $item)
        colors.push(getRandomColorHex());
        bcolors.push("#111");
    @endforeach

    var bar_ctx2 = document.getElementById('service-expense-chart');
    var bar_chart2 =  {
        type: 'bar',
        data: {
            labels:<?=  json_encode($revenueData['lables']) ?>,
            datasets: [
                {
                    label: 'Revenue',
                    data:  <?= !empty($revenueData['revenue']) ? json_encode($revenueData['revenue']) :  json_encode([])?>,
                    backgroundColor : '#696661',
                    borderColor : '#696661',
                    borderWidth : 1,
                    hoverBorderWidth: 2,
                    stack: 1
                },
                {
                    label: 'Expense',
                    data:  <?= !empty($revenueData['expense']) ? json_encode($revenueData['expense']) :  json_encode([])?>,
                    backgroundColor : '#edca93',
                    borderColor : '#edca93',
                    borderWidth : 1,
                    hoverBorderWidth: 2,
                    stack: 1
                },
                {
                    label: 'Ultimate',
                    data:  <?= !empty($revenueData['ultimate']) ? json_encode($revenueData['ultimate']) :  json_encode([])?>,
                    backgroundColor : '#554667',
                    borderColor : '#554667',
                    borderWidth : 2,
                    fill: false,
                    type: 'line',
                },
                {
                    label: 'Ideal',
                    data:  <?= !empty($revenueData['ideal']) ? json_encode($revenueData['ideal']) :  json_encode([])?>,
                    backgroundColor : '#4d695d',
                    borderColor : '#4d695d',
                    borderWidth : 2,
                    fill: false,
                    type: 'line'
                },
                {
                    label: 'Target',
                    data:  <?= !empty($revenueData['target']) ? json_encode($revenueData['target']) :  json_encode([])?>,
                    backgroundColor : '#c7ac51',
                    borderColor : '#c7ac51',
                    borderWidth : 2,
                    fill: false,
                    type: 'line'
                },
                {
                    label: 'Minimum',
                    data:  <?= !empty($revenueData['minimum']) ? json_encode($revenueData['minimum']) : json_encode([])?>,
                    backgroundColor : '#d75c78',
                    borderColor : '#d75c78',
                    borderWidth : 2,
                    fill: false,
                    type: 'line'
                },
                {
                    label: 'Goal Average',
                    data:  <?= !empty($revenueData['avg']) ? json_encode($revenueData['avg']) : json_encode([])?>,
                    backgroundColor : 'red',
                    borderColor : 'red',
                    borderWidth : 2,
                    fill: false,
                    type: 'line'
                },
            ]
        },
        options: {
            animation: {
                duration: 10,
            },
            tooltips: {
                mode: 'label',
                callbacks: {
                    label: function(tooltipItem, data) {
                        return data.datasets[tooltipItem.datasetIndex].label + ": " + numberWithCommas(tooltipItem.yLabel);
                    }
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            },
            title: {
                display: true,
                text: 'Service Revenue + Expense'
            },
            legend: {
                display: false,
            }
        } // options
    };
    new Chart(bar_ctx2,bar_chart2)

    function getRandomColorHex() {
        var hex = "0123456789ABCDEF",
            color = "#";
        for (var i = 1; i <= 6; i++) {
            color += hex[Math.floor(Math.random() * 16)];
        }
        return color;
    }
</script>
