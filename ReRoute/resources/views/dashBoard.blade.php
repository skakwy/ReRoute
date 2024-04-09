<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <canvas id="cpuChart"></canvas>
    <script>
        const ctx = document.getElementById('cpuChart');

        var cpuChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: '# of Votes',
                    data: [],
                    borderWidth: 1
                }]
            },
            options: {
                fill: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: false,
                    }
                }
            }
        });
        <?php
        class usageMonitorThread extends Thread {
            public function run(){
                while(true){
                    $cpuUsage = http_get("http://localhost:8080/cpuUsage");
                    echo "cpuChart.data.labels.push('1');";
                    echo "cpuChart.data.datasets[0].data.push($cpuUsage);";
                    echo "cpuChart.update();";
                    sleep(1);
                }
            }
        }
        $usageMontor = new usageMonitorThread();
        $usageMontor->start();
        ?>
    </script>
</body>

</html>
