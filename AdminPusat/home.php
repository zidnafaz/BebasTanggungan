<!-- Admin Akademik Pusat -->

<?php
include '../koneksi.php';

// Query untuk total mahasiswa
$totalQuery = "SELECT COUNT(DISTINCT nim) AS total_mahasiswa FROM mahasiswa";
$totalResult = sqlsrv_query($conn, $totalQuery);
$totalRow = sqlsrv_fetch_array($totalResult, SQLSRV_FETCH_ASSOC);

// Query untuk mahasiswa terverifikasi
$verifikasiQuery = "
    SELECT COUNT(DISTINCT m.nim) AS mahasiswa_terverifikasi
    FROM mahasiswa m
    LEFT JOIN data_alumni da ON m.nim = da.nim AND da.status_pengumpulan_data_alumni = 'terkonfirmasi'
    LEFT JOIN skkm s ON m.nim = s.nim AND s.status_pengumpulan_skkm = 'terkonfirmasi'
    LEFT JOIN foto_ijazah fi ON m.nim = fi.nim AND fi.status_pengumpulan_foto_ijazah = 'terkonfirmasi'
    LEFT JOIN ukt u ON m.nim = u.nim AND u.status_pengumpulan_ukt = 'terkonfirmasi'
    WHERE da.nim IS NOT NULL AND s.nim IS NOT NULL AND fi.nim IS NOT NULL AND u.nim IS NOT NULL";
$verifikasiResult = sqlsrv_query($conn, $verifikasiQuery);
$verifikasiRow = sqlsrv_fetch_array($verifikasiResult, SQLSRV_FETCH_ASSOC);

// Query untuk mahasiswa perlu verifikasi
$perluVerifikasiQuery = "
    SELECT COUNT(DISTINCT m.nim) AS mahasiswa_perlu_verifikasi
    FROM mahasiswa m
    LEFT JOIN data_alumni da ON m.nim = da.nim AND da.status_pengumpulan_data_alumni IN ('pending', 'tidak terkonfirmasi')
    LEFT JOIN skkm s ON m.nim = s.nim AND s.status_pengumpulan_skkm IN ('pending', 'tidak terkonfirmasi')
    LEFT JOIN foto_ijazah fi ON m.nim = fi.nim AND fi.status_pengumpulan_foto_ijazah IN ('pending', 'tidak terkonfirmasi')
    LEFT JOIN ukt u ON m.nim = u.nim AND u.status_pengumpulan_ukt IN ('pending', 'tidak terkonfirmasi')
    WHERE da.nim IS NOT NULL OR s.nim IS NOT NULL OR fi.nim IS NOT NULL OR u.nim IS NOT NULL";
$perluVerifikasiResult = sqlsrv_query($conn, $perluVerifikasiQuery);
$perluVerifikasiRow = sqlsrv_fetch_array($perluVerifikasiResult, SQLSRV_FETCH_ASSOC);

// Query untuk mahasiswa belum upload
$belumUploadQuery = "
    SELECT COUNT(DISTINCT m.nim) AS mahasiswa_belum_upload
    FROM mahasiswa m
    LEFT JOIN data_alumni da ON m.nim = da.nim AND da.status_pengumpulan_data_alumni = 'belum upload'
    LEFT JOIN skkm s ON m.nim = s.nim AND s.status_pengumpulan_skkm = 'belum upload'
    LEFT JOIN foto_ijazah fi ON m.nim = fi.nim AND fi.status_pengumpulan_foto_ijazah = 'belum upload'
    LEFT JOIN ukt u ON m.nim = u.nim AND u.status_pengumpulan_ukt = 'belum upload'
    WHERE da.nim IS NOT NULL OR s.nim IS NOT NULL OR fi.nim IS NOT NULL OR u.nim IS NOT NULL";
$belumUploadResult = sqlsrv_query($conn, $belumUploadQuery);
$belumUploadRow = sqlsrv_fetch_array($belumUploadResult, SQLSRV_FETCH_ASSOC);

sqlsrv_close($conn);
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

    <style>
        .card-fixed-height {
            height: 200px;
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin Akademik</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Total Mahasiswa Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Mahasiswa
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $totalRow['total_mahasiswa']; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mahasiswa Terverifikasi Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Mahasiswa Terverifikasi
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $verifikasiRow['mahasiswa_terverifikasi']; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mahasiswa Perlu Verifikasi Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Mahasiswa Perlu Verifikasi
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $perluVerifikasiRow['mahasiswa_perlu_verifikasi']; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mahasiswa Belum Upload Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Mahasiswa Belum Upload
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $belumUploadRow['mahasiswa_belum_upload']; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-upload fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

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
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>

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

        fetch('topbar.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('topbar').innerHTML = data;
            })
            .catch(error => console.error('Error loading topbar:', error));

    </script>

</body>

</html>