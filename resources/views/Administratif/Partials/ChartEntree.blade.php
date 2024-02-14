<div class="col-lg-6 col-md-6 mt-4 mb-4">
    <div class="card z-index-2  ">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
            <div class="bg-dark shadow-success border-radius-lg py-3 pe-1">
                <div class="chart">
                    <canvas id="chart-line" class="chart-canvas" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h6 class="mb-0 ">Coubres Mensuelle des Entrées</h6>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        $.get('/Administratif/EntreeChartData', function(data) {

            const monthOrder = [
                "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
            ];

            const sortedData = data.sort((a, b) => {
                return monthOrder.indexOf(a.month) - monthOrder.indexOf(b.month);
            });

            var ctx2 = document.getElementById("chart-line").getContext("2d");

            new Chart(ctx2, {
                type: "bar",
                data: {
                    labels: sortedData.map(entry => entry.month),
                    datasets: [{
                        label: "Caisse",
                        tension: 0,
                        borderWidth: 0,
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(255, 255, 255, .8)",
                        pointBorderColor: "transparent",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderWidth: 4,
                        backgroundColor: "transparent",
                        fill: true,
                        data: sortedData.map(entry => entry.totalMontant),
                        maxBarThickness: 6
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                stepSize: 1000000,
                                callback: function(value, index, values) {
                                    
                                    return value / 1000000 + ' M';
                                },
                                font: {
                                    size: 14,
                                    weight: 400,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 4,
                                },
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });
        });
    });
</script>
