<!-- Admin Lantai 6 -->

<?php
include '../koneksi.php';
include '../data/dataAdmin.php';

// Query untuk TOEIC
$toeicQuery = "
    SELECT 
        COUNT(CASE WHEN status_pengumpulan_toeic = 'terverifikasi' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN status_pengumpulan_toeic = 'pending' THEN 1 END) AS pending,
        COUNT(CASE WHEN status_pengumpulan_toeic = 'belum upload' THEN 1 END) AS belum_upload,
        COUNT(CASE WHEN status_pengumpulan_toeic = 'ditolak' THEN 1 END) AS tidak_terverifikasi
    FROM toeic;
";
$toeicResult = sqlsrv_query($conn, $toeicQuery);
$toeicRow = sqlsrv_fetch_array($toeicResult, SQLSRV_FETCH_ASSOC);

// Query untuk Penyerahan Skripsi
$skripsiQuery = "
    SELECT 
        COUNT(CASE WHEN status_pengumpulan_penyerahan_skripsi = 'terverifikasi' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_skripsi = 'pending' THEN 1 END) AS pending,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_skripsi = 'belum upload' THEN 1 END) AS belum_upload,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_skripsi = 'ditolak' THEN 1 END) AS tidak_terverifikasi
    FROM penyerahan_skripsi;
";
$skripsiResult = sqlsrv_query($conn, $skripsiQuery);
$skripsiRow = sqlsrv_fetch_array($skripsiResult, SQLSRV_FETCH_ASSOC);

// Query untuk Penyerahan PKL
$pklQuery = "
    SELECT 
        COUNT(CASE WHEN status_pengumpulan_penyerahan_pkl = 'terverifikasi' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_pkl = 'pending' THEN 1 END) AS pending,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_pkl = 'belum upload' THEN 1 END) AS belum_upload,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_pkl = 'ditolak' THEN 1 END) AS tidak_terverifikasi
    FROM penyerahan_pkl;
";
$pklResult = sqlsrv_query($conn, $pklQuery);
$pklRow = sqlsrv_fetch_array($pklResult, SQLSRV_FETCH_ASSOC);

// Query untuk Bebas Kompen
$kompenQuery = "
    SELECT 
        COUNT(CASE WHEN status_pengumpulan_bebas_kompen = 'terverifikasi' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN status_pengumpulan_bebas_kompen = 'pending' THEN 1 END) AS pending,
        COUNT(CASE WHEN status_pengumpulan_bebas_kompen = 'belum upload' THEN 1 END) AS belum_upload,
        COUNT(CASE WHEN status_pengumpulan_bebas_kompen = 'ditolak' THEN 1 END) AS tidak_terverifikasi
    FROM bebas_kompen;
";
$kompenResult = sqlsrv_query($conn, $kompenQuery);
$kompenRow = sqlsrv_fetch_array($kompenResult, SQLSRV_FETCH_ASSOC);

// Query untuk Penyerahan Kebenaran Data
$kebenaranQuery = "
    SELECT 
        COUNT(CASE WHEN status_pengumpulan_penyerahan_kebenaran_data = 'terverifikasi' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_kebenaran_data = 'pending' THEN 1 END) AS pending,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_kebenaran_data = 'belum upload' THEN 1 END) AS belum_upload,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_kebenaran_data = 'ditolak' THEN 1 END) AS tidak_terverifikasi
    FROM penyerahan_kebenaran_data;
";
$kebenaranResult = sqlsrv_query($conn, $kebenaranQuery);
$kebenaranRow = sqlsrv_fetch_array($kebenaranResult, SQLSRV_FETCH_ASSOC);

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
    .status span {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 8px;
        font-size: 0.9rem;
        text-transform: uppercase;
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
    }

    .status .badge-success {
        background-color: #1cc88a;
    }

    .status .badge-warning {
        background-color: #f6c23e;
        color: #5a5c69;
    }

    .status .badge-secondary {
        background-color: #858796;
    }

    .status .badge-danger {
        background-color: #e74a3b;
    }

    .card-fixed-height {
        height: 200px;
    }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
                <div class="sidebar-brand-text mx-3">Bebas Tanggungan</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active" id="nav-dashboard">
                <a class="nav-link" href="home.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Verifikasi
            </div>


            <!-- Nav Item - Dashboard -->
            <li class="nav-item" id="nav-skripsi">
                <a class="nav-link" href="skripsi.php">
                    <i class="fas fa-solid fa-book"></i>
                    <span>Laporan Skripsi</span></a>
            </li>

            <li class="nav-item" id="nav-pkl">
                <a class="nav-link" href="pkl.php">
                    <i class="fas fa-solid fa-file-lines"></i>
                    <span>Laporan PKL</span></a>
            </li>

            <li class="nav-item" id="nav-toeic">
                <a class="nav-link" href="toeic.php">
                    <i class="fas fa-solid fa-file"></i>
                    <span>TOEIC</span></a>
            </li>

            <li class="nav-item" id="nav-kompen">
                <a class="nav-link" href="kompen.php">
                    <i class="fas fa-solid fa-file-invoice"></i>
                    <span>Kompen</span></a>
            </li>

            <li class="nav-item" id="nav-kebenaran_data">
                <a class="nav-link" href="kebenarandata.php">
                    <i class="fas fa-solid fa-user-graduate"></i>
                    <span>Kebenaran Data</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo htmlspecialchars($resultUser['nama_karyawan']?? '') ?>
                                </span>
                                <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="index.html" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin Prodi</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Kolom untuk tabel -->
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Rekapitulasi Dokumen</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr class="table-header bg-primary text-white">
                                                    <th rowspan="2">Status</th>
                                                    <th colspan="5">Dokumen</th>
                                                    <th rowspan="2">Total</th>
                                                </tr>
                                                <tr class="table-header bg-primary text-white">
                                                    <th>Skripsi</th>
                                                    <th>PKL</th>
                                                    <th>TOEIC</th>
                                                    <th>Bebas Kompen</th>
                                                    <th>Kebenaran Data</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $statuses = ['terverifikasi', 'pending', 'belum_upload', 'ditolak'];
                                                foreach ($statuses as $status) {
                                                    // Menentukan kelas badge berdasarkan status
                                                    $statusClass = '';
                                                    switch ($status) {
                                                        case 'terverifikasi':
                                                            $statusClass = 'badge-success';
                                                            break;
                                                        case 'pending':
                                                            $statusClass = 'badge-warning';
                                                            break;
                                                        case 'belum_upload':
                                                            $statusClass = 'badge-secondary';
                                                            break;
                                                        case 'ditolak':
                                                            $statusClass = 'badge-danger';
                                                            break;
                                                    }

                                                    // Data tiap dokumen
                                                    $skripsi = $skripsiRow[$status] ?? 0;
                                                    $pkl = $pklRow[$status] ?? 0;
                                                    $toeic = $toeicRow[$status] ?? 0;
                                                    $kompen = $kompenRow[$status] ?? 0;
                                                    $kebenaran = $kebenaranRow[$status] ?? 0;
                                                    $total = $skripsi + $pkl + $toeic + $kompen + $kebenaran;

                                                    echo "<tr>
                                                            <td class='status'>
                                                                <span class='badge $statusClass p-2 rounded text-uppercase'
                                                                    style='cursor: pointer;'
                                                                    title='" . htmlspecialchars($status) . "'>
                                                                    " . htmlspecialchars($status) . "
                                                                </span>
                                                            </td>
                                                            <td>$skripsi</td>
                                                            <td>$pkl</td>
                                                            <td>$toeic</td>
                                                            <td>$kompen</td>
                                                            <td>$kebenaran</td>
                                                            <td><strong>$total</strong></td>
                                                        </tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- End of Content Row -->
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>


</body>

</html>