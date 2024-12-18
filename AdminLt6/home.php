<!-- Admin Lantai 6 -->

<?php
session_start();
require_once '../Koneksi.php';
require_once '../OOP/Admin.php';

$db = new Koneksi();
$conn = $db->connect();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.html");
    exit();
}

$id = $_SESSION['id'];

$admin = new Admin();
$resultUser = $admin->getAdminById($id);

// Query untuk penyerahan skripsi
$penyerahanSkripsiQuery = "
    SELECT 
        COUNT(CASE WHEN status_pengumpulan_penyerahan_skripsi = '4' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_skripsi = '1' THEN 1 END) AS pending,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_skripsi = '3' THEN 1 END) AS 'belum upload',
        COUNT(CASE WHEN status_pengumpulan_penyerahan_skripsi = '2' THEN 1 END) AS ditolak
    FROM penyerahan_skripsi;
";
$penyerahanSkripsiResult = sqlsrv_query($conn, $penyerahanSkripsiQuery);
$penyerahanSkripsiRow = sqlsrv_fetch_array($penyerahanSkripsiResult, SQLSRV_FETCH_ASSOC);

// Query untuk penyerahan pkl
$penyerahanPklQuery = "
    SELECT 
        COUNT(CASE WHEN status_pengumpulan_penyerahan_pkl = '4' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_pkl = '1' THEN 1 END) AS pending,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_pkl = '3' THEN 1 END) AS 'belum upload',
        COUNT(CASE WHEN status_pengumpulan_penyerahan_pkl = '2' THEN 1 END) AS ditolak
    FROM penyerahan_pkl;
";
$penyerahanPklResult = sqlsrv_query($conn, $penyerahanPklQuery);
$penyerahanPklRow = sqlsrv_fetch_array($penyerahanPklResult, SQLSRV_FETCH_ASSOC);

// Query untuk TOEIC
$toeicQuery = "
    SELECT 
        COUNT(CASE WHEN status_pengumpulan_toeic = '4' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN status_pengumpulan_toeic = '1' THEN 1 END) AS pending,
        COUNT(CASE WHEN status_pengumpulan_toeic = '3' THEN 1 END) AS 'belum upload',
        COUNT(CASE WHEN status_pengumpulan_toeic = '2' THEN 1 END) AS ditolak
    FROM toeic;
";
$toeicResult = sqlsrv_query($conn, $toeicQuery);
$toeicRow = sqlsrv_fetch_array($toeicResult, SQLSRV_FETCH_ASSOC);

// Query untuk bebas kompen
$bebasKompenQuery = "
    SELECT 
        COUNT(CASE WHEN status_pengumpulan_bebas_kompen = '4' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN status_pengumpulan_bebas_kompen = '1' THEN 1 END) AS pending,
        COUNT(CASE WHEN status_pengumpulan_bebas_kompen = '3' THEN 1 END) AS 'belum upload',
        COUNT(CASE WHEN status_pengumpulan_bebas_kompen = '2' THEN 1 END) AS ditolak
    FROM bebas_kompen;
";
$bebasKompenResult = sqlsrv_query($conn, $bebasKompenQuery);
$bebasKompenRow = sqlsrv_fetch_array($bebasKompenResult, SQLSRV_FETCH_ASSOC);

// Query untuk kebenaran data
$kebenaranDataQuery = "
    SELECT 
        COUNT(CASE WHEN status_pengumpulan_penyerahan_kebenaran_data = '4' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_kebenaran_data = '1' THEN 1 END) AS pending,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_kebenaran_data = '3' THEN 1 END) AS 'belum upload',
        COUNT(CASE WHEN status_pengumpulan_penyerahan_kebenaran_data = '2' THEN 1 END) AS ditolak
    FROM penyerahan_kebenaran_data;
";
$kebenaranDataResult = sqlsrv_query($conn, $kebenaranDataQuery);
$kebenaranDataRow = sqlsrv_fetch_array($kebenaranDataResult, SQLSRV_FETCH_ASSOC);

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

        .welcome-name {
            font-size: 18px;
            color: #5a5c69;
            font-weight: normal;
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

            <!-- Nav Item - Verifikasi -->
            <li class="nav-item" id="nav-upload_skripsi">
                <a class="nav-link" href="daftar_mahasiswa.php">
                    <i class="fa-solid fa-user-group"></i>
                    <span>Daftar Mahasiswa</span></a>
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
                                    <?php echo htmlspecialchars($resultUser['nama_karyawan'] ?? '') ?>
                                </span>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <mask id="mask0_95_26" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0"
                                        y="0" width="24" height="24">
                                        <circle cx="12" cy="12" r="12" fill="#D9D9D9" />
                                    </mask>
                                    <g mask="url(#mask0_95_26)">
                                        <circle cx="12" cy="7" r="5" fill="#6C757D" />
                                        <path
                                            d="M22.5 21.5042C22.5 25.6463 17.799 29.0042 12 29.0042C6.20101 29.0042 1.5 25.6463 1.5 21.5042C1.5 18.5 3.5 14.0042 12 14.0042C20.5 14.0042 22.5 18.5 22.5 21.5042Z"
                                            fill="#6C757D" />
                                    </g>
                                </svg>
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
                        <h1 class="h3 mb-0 text-gray-800">
                            Dashboard Admin Prodi -
                            <span class="welcome-name">Selamat Datang
                                <?= htmlspecialchars($resultUser['nama_karyawan'] ?? '') ?></span>
                        </h1>
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
                                                // Data status
                                                $statuses = [
                                                    '4' => 'Terverifikasi',
                                                    '1' => 'Pending',
                                                    '3' => 'Belum Upload',
                                                    '2' => 'Ditolak'
                                                ];

                                                // Mapping status ke class CSS
                                                $statusClasses = [
                                                    '4' => 'badge-success',
                                                    '1' => 'badge-warning',
                                                    '3' => 'badge-secondary',
                                                    '2' => 'badge-danger'
                                                ];

                                                foreach ($statuses as $status => $statusText): ?>
                                                    <?php
                                                    // Data tiap dokumen
                                                    $penyerahanSkripsi = $penyerahanSkripsiRow[strtolower($statusText)] ?? 0;
                                                    $penyerahanPkl = $penyerahanPklRow[strtolower($statusText)] ?? 0;
                                                    $toeic = $toeicRow[strtolower($statusText)] ?? 0;
                                                    $bebasKompen = $bebasKompenRow[strtolower($statusText)] ?? 0;
                                                    $kebenaranData = $kebenaranDataRow[strtolower($statusText)] ?? 0;
                                                    $total = $penyerahanSkripsi + $penyerahanPkl + $toeic + $bebasKompen + $kebenaranData;

                                                    // Tentukan class CSS untuk badge
                                                    $statusClass = $statusClasses[$status] ?? 'badge-light';
                                                    ?>
                                                    <tr>
                                                        <td class="status">
                                                            <span
                                                                class="badge <?= $statusClass ?> p-2 rounded text-uppercase"
                                                                style="cursor: pointer;"
                                                                title="<?= htmlspecialchars($statusText) ?>">
                                                                <?= htmlspecialchars($statusText) ?>
                                                            </span>
                                                        </td>
                                                        <td><?= $penyerahanSkripsi ?></td>
                                                        <td><?= $penyerahanPkl ?></td>
                                                        <td><?= $toeic ?></td>
                                                        <td><?= $bebasKompen ?></td>
                                                        <td><?= $kebenaranData ?></td>
                                                        <td><strong><?= $total ?></strong></td>
                                                    </tr>
                                                <?php endforeach; ?>
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
                        <span>Copyright &copy; Bebas Tanggungan - JTI - 2024</span>
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