<?php
include '../koneksi.php';

if (!isset($_COOKIE['id'])) {
    header("Location: ../index.html");
    exit();
} else {
    $username = $_COOKIE['id'];
}

$sql = "SELECT m.nim, m.nama_mahasiswa, m.jurusan_mahasiswa, m.prodi_mahasiswa
            FROM dbo.mahasiswa m
            WHERE m.nim = ?";

$params = array($username);
$result = sqlsrv_query($conn, $sql, $params);

if ($result === false) {
    die("Kesalahan saat menjalankan query: " . print_r(sqlsrv_errors(), true));
}

$nama_mahasiswa = "";

// Ambil data dan cek apakah ada
if ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $nama_mahasiswa = $row['nama_mahasiswa'];
    $nim = $row['nim'];
    $jurusan = $row['jurusan_mahasiswa'];
    $prodi = $row['prodi_mahasiswa'];
}

sqlsrv_free_stmt($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bebas Tanggungan Politeknik Negeri Malang - Teknologi Informasi</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script type="module">
        import {
            PDFDocument,
            rgb
        } from 'https://cdn.jsdelivr.net/npm/pdf-lib@1.17.1/+esm';

        document.addEventListener('DOMContentLoaded', () => {
            const button = document.getElementById('downloadButton');

            button.addEventListener('click', async () => {

                function getCookie(name) {
                    let cookieArr = document.cookie.split(";");

                    for (let i = 0; i < cookieArr.length; i++) {
                        let cookie = cookieArr[i].trim();
                        if (cookie.indexOf(name + "=") == 0) {
                            return cookie.substring(name.length + 1);
                        }
                    }
                    return "";
                }

                const username = getCookie('id');
                const pdfPath = '../Documents/downloads/generate/Rekomendasi_Pengambilan_Ijazah.pdf';
                const fontPath = './TimesNewRoman/TimesNewRoman.ttf';

                // Muat PDF
                const pdfResponse = await fetch(pdfPath);
                if (!pdfResponse.ok) throw new Error(`Could not load PDF: ${pdfResponse.statusText}`);
                const pdfArrayBuffer = await pdfResponse.arrayBuffer();
                const pdfDoc = await PDFDocument.load(pdfArrayBuffer);

                // Registrasikan fontkit
                pdfDoc.registerFontkit(window.fontkit);

                // Muat font kustom
                const fontResponse = await fetch(fontPath);
                if (!fontResponse.ok) throw new Error(`Could not load font: ${fontResponse.statusText}`);
                const fontArrayBuffer = await fontResponse.arrayBuffer();
                const timesFont = await pdfDoc.embedFont(fontArrayBuffer);

                // Tambahkan teks ke halaman pertama
                const pages = pdfDoc.getPages();
                const firstPage = pages[0];
                const nama = "<?php echo htmlspecialchars($nama_mahasiswa, ENT_QUOTES, 'UTF-8'); ?>";
                const nim = "<?php echo htmlspecialchars($nim, ENT_QUOTES, 'UTF-8'); ?>";
                const jurusan = "<?php echo htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8'); ?>";
                const prodi = "<?php echo htmlspecialchars($prodi, ENT_QUOTES, 'UTF-8'); ?>";

                // Tentukan posisi teks untuk setiap field
                firstPage.drawText(`${nama}`, {
                    x: 190,  // Ganti dengan koordinat X yang sesuai
                    y: 468,  // Ganti dengan koordinat Y yang sesuai
                    size: 12,
                    font: timesFont,
                    color: rgb(0, 0, 0),
                });

                firstPage.drawText(`${nim}`, {
                    x: 190,  // Ganti dengan koordinat X yang sesuai
                    y: 446,  // Ganti dengan koordinat Y yang sesuai
                    size: 12,
                    font: timesFont,
                    color: rgb(0, 0, 0),
                });

                firstPage.drawText(`${prodi}`, {
                    x: 190,  // Ganti dengan koordinat X yang sesuai
                    y: 404,  // Ganti dengan koordinat Y yang sesuai
                    size: 12,
                    font: timesFont,
                    color: rgb(0, 0, 0),
                });

                firstPage.drawText(`${jurusan}`, {
                    x: 190,  // Ganti dengan koordinat X yang sesuai
                    y: 382,  // Ganti dengan koordinat Y yang sesuai
                    size: 12,
                    font: timesFont,
                    color: rgb(0, 0, 0),
                });

                // Simpan PDF baru
                const modifiedPdf = await pdfDoc.save();
                const blob = new Blob([modifiedPdf], {
                    type: 'application/pdf'
                });

                // Unduh PDF yang sudah diedit
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `${nim}_Rekomendasi_Pengambilan_Ijazah.pdf`;
                link.click();
            });
        });


    </script>

    <script src="https://cdn.jsdelivr.net/npm/@pdf-lib/fontkit@0.0.4/dist/fontkit.umd.min.js"></script>

    <style>
        .chart-pie {
            position: relative;
            height: 250px;
            width: 100%;
        }

        .card-body {
            padding: 1.25rem;
        }

        .card-header {
            background-color: #f8f9fc;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .container-fluid {
            padding: 15px;
        }

        .btn[disabled] {
            pointer-events: none;
            background-color: #858796 !important;
            color: #fff !important;
            cursor: not-allowed;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <div id="navbar"></div>

        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <div id="topbar"></div>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard Mahasiswa</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Donut Chart Section -->
                        <div class="col-xl-4 col-lg-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Title -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Status Bebas Tanggungan</h6>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-1">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info and Download Section -->
                        <div class="col-xl-4 col-lg-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Rekomendasi Pengambilan Transkrip,
                                        Ijazah, dan SKPI</h6>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <p class="text-gray-600">Untuk mengambil Transkrip, Ijazah, dan SKPI, pastikan Anda
                                        sudah memenuhi
                                        seluruh persyaratan yang diperlukan. Jika sudah,
                                        silakan unduh Surat Rekomendasi Pengambilan Transkrip, Ijazah, dan SKPI di bawah
                                        ini.</p>

                                    <!-- Download Button -->
                                    <button class="btn btn-success btn-block" id="downloadButton" disabled>
                                        <i class="fas fa-download"></i> Download
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Panduan Alur Bebas Tanggungan -->
                        <div class="col-xl-4 col-lg-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Panduan Alur Bebas Tanggungan</h6>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <p class="text-gray-600">Panduan alur bebas tanggungan ini akan membantu Anda
                                        memahami proses yang harus dilalui untuk menyelesaikan kewajiban administrasi.
                                        Pastikan Anda membaca dan mengikuti langkah-langkah yang tersedia.</p>

                                    <!-- Download Button -->
                                    <a href="../Documents/downloads/template/[Panduan] Alur Bebas Tanggungan Jurusan_SIB.docx"
                                        class="btn btn-success btn-block" download>
                                        <i class="fas fa-download"></i> Download Panduan
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- End Content Row -->

                </div>
                <!-- End Page Content -->

            </div>


            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../index.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        document.addEventListener("DOMContentLoaded", function () {
            fetch('navbar.html')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(data => {
                    document.getElementById('navbar').innerHTML = data;
                })
                .catch(error => console.error('Error loading navbar:', error));
        });

        fetch('topbar.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('topbar').innerHTML = data;
            })
            .catch(error => console.error('Error loading topbar:', error));

        fetch('get_persentase.php')
            .then(response => response.json())
            .then(data => {
                // Data and labels for the chart
                const labels = ['Terkonfirmasi', 'Belum Upload', 'Pending', 'Tidak Terkonfirmasi'];
                const values = [
                    data.terkonfirmasi,
                    data.belum_upload,
                    data.pending,
                    data.tidak_terkonfirmasi
                ];

                // Chart data structure
                const chartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Status Bebas Tanggungan',
                        data: values,
                        backgroundColor: [
                            '#1cc88a', // Terkonfirmasi
                            '#858796', // Belum Upload
                            '#f6c23e', // Pending
                            '#e74a3b'  // Tidak Terkonfirmasi
                        ],
                        borderWidth: 1
                    }]
                };

                // Chart configuration
                const config = {
                    type: 'doughnut',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    boxWidth: 10, // Lebar kotak warna
                                    boxHeight: 10, // Tinggi kotak warna
                                    font: {
                                        size: 14,
                                        weight: 'normal'
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        return tooltipItem.raw + ' items'; // Format tooltip
                                    }
                                }
                            },
                            datalabels: {
                                display: true,
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 16
                                },
                                formatter: (value, context) => {
                                    return context.chart.data.labels[context.dataIndex] + ' : ' + value;
                                }
                            }
                        },
                        cutoutPercentage: 50, // Ukuran potongan tengah donut chart
                        rotation: Math.PI, // Memutar chart untuk menyesuaikan posisi awal
                    }
                };

                // Render the chart
                const ctx = document.getElementById('myChart').getContext('2d');
                new Chart(ctx, config);

                const downloadButton = document.getElementById('downloadButton');

                // Update logic to check if all statuses are confirmed
                if (data.belum_upload > 0 || data.pending > 0 || data.tidak_terkonfirmasi > 0) {
                    downloadButton.disabled = true;
                    downloadButton.classList.add('btn-secondary');
                    downloadButton.classList.remove('btn-success');
                    downloadButton.innerHTML = '<i class="fas fa-download"></i> Disabled';
                } else {
                    downloadButton.disabled = false;
                    downloadButton.classList.add('btn-success');
                    downloadButton.classList.remove('btn-secondary');
                }

            })
            .catch(error => console.error('Error loading data:', error));

    </script>

</body>

</html>