
<script type="text/javascript">
    var numberWithCommas = function(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    };

    var colors = [];
    var bcolors = [];

    @foreach ($remaingData['data'] as $item)
        colors.push(getRandomColorHex());
        bcolors.push("#111");
    @endforeach

    var bar_ctx2 = document.getElementById('remaining-balance-chart');
    var bar_chart2 =  {
        type: 'bar',
        data: {
            //labels: ['jk' ,'jk','jk'],
            labels:<?=  json_encode($remaingData['lables']) ?>,
            datasets: [
                {
                    label: 'Remaining Amt.',
                    data:  <?= !empty($remaingData['data']) ? json_encode($remaingData['data']) :  json_encode([])?>,
                    backgroundColor : colors,
                    borderColor : bcolors,
                    borderWidth : 1,
                    hoverBorderWidth: 2,
                }
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
                        console.log(tooltipItem, data);
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
                text: 'Remaining Balance'
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
