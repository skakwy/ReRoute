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
        const ctx = document.getElementById('cpuChart').getContext('2d');
        var gradient = ctx.createLinearGradient(0, 0, 0, 100);
        gradient.addColorStop(0, '#386C3E');   
        gradient.addColorStop(1, '#161819');
        var cpuChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [0,1],
                datasets: [{
                    label: 'usage in %',
                    data: [80,50],
                    borderWidth: 1
                }]
            },
            options: {
                scaleBeginAtZero: true,
                fill: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: true,
                    }
                },
                /*
                scales: {
                    y: {
                        min:0,
                        max:100
                    }
                },
                */
                tension:0.3,
                responsive:false,
                pointRadius:0,
                borderColor:"#8AF437",
                backgroundColor: gradient
            }
        });
        
        if (window.Worker) {
            const statusWorker = new Worker("js/dockerWorker.js");
            statusWorker.onmessage = function (e) {
                cpuChart.data.labels.push(e.data.time);
                cpuChart.data.datasets[0].data.push(e.data.cpu);
                cpuChart.update();
            }
        }
    </script>
</body>

</html>
