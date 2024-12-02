<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart Bebas Tanggungan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Persentase Bebas Tanggungan</h1>
    <canvas id="myChart" width="400" height="200"></canvas>
    <script>
        // Ambil data dari backend
        fetch('get_persentase.php') // Ganti YOUR_NIM dengan NIM aktual
            .then(response => response.json())
            .then(data => {
                // Data dan label untuk chart
                const labels = ['Terkonfirmasi', 'Belum Upload', 'Pending', 'Tidak Terkonfirmasi'];
                const values = [
                    data.terkonfirmasi,
                    data.belum_upload,
                    data.pending,
                    data.tidak_terkonfirmasi
                ];

                // Struktur data untuk chart
                const chartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Status Bebas Tanggungan',
                        data: values,
                        backgroundColor: [
                            '#4CAF50', // Terkonfirmasi
                            '#FFC107', // Belum Upload
                            '#2196F3', // Pending
                            '#F44336'  // Tidak Terkonfirmasi
                        ],
                        borderWidth: 1
                    }]
                };

                // Konfigurasi chart
                const config = {
                    type: 'doughnut',
                    data: chartData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        return `${tooltipItem.label}: ${tooltipItem.raw}`;
                                    }
                                }
                            }
                        }
                    }
                };

                // Render chart
                const ctx = document.getElementById('myChart').getContext('2d');
                new Chart(ctx, config);
            })
            .catch(error => console.error('Error:', error));
    </script>
</body>
</html>
