<!-- Admin Perpustakaan Polinema -->

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

// Query untuk total mahasiswa
$penyerahan_hardcopyQuery = "
    SELECT 
        COUNT(CASE WHEN status_pengumpulan_penyerahan_hardcopy = 'terverifikasi' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_hardcopy = 'pending' THEN 1 END) AS pending,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_hardcopy = 'belum upload' THEN 1 END) AS belum_upload,
        COUNT(CASE WHEN status_pengumpulan_penyerahan_hardcopy = 'ditolak' THEN 1 END) AS tidak_terverifikasi
    FROM penyerahan_hardcopy;
";
$penyerahan_hardcopyResult = sqlsrv_query($conn, $penyerahan_hardcopyQuery);
$penyerahan_hardcopyRow = sqlsrv_fetch_array($penyerahan_hardcopyResult, SQLSRV_FETCH_ASSOC);

// Query untuk Penyerahan tugas_akhir_softcopy
$tugas_akhir_softcopyQuery = "
    SELECT 
        COUNT(CASE WHEN status_pengumpulan_tugas_akhir_softcopy = 'terverifikasi' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN status_pengumpulan_tugas_akhir_softcopy = 'pending' THEN 1 END) AS pending,
        COUNT(CASE WHEN status_pengumpulan_tugas_akhir_softcopy = 'belum upload' THEN 1 END) AS belum_upload,
        COUNT(CASE WHEN status_pengumpulan_tugas_akhir_softcopy = 'ditolak' THEN 1 END) AS tidak_terverifikasi
    FROM tugas_akhir_softcopy;
";
$tugas_akhir_softcopyResult = sqlsrv_query($conn, $tugas_akhir_softcopyQuery);
$tugas_akhir_softcopyRow = sqlsrv_fetch_array($tugas_akhir_softcopyResult, SQLSRV_FETCH_ASSOC);

// Query untuk Penyerahan hasil_kuisioner
$hasil_kuisionerQuery = "
    SELECT 
        COUNT(CASE WHEN status_pengumpulan_hasil_kuisioner = 'terverifikasi' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN status_pengumpulan_hasil_kuisioner = 'pending' THEN 1 END) AS pending,
        COUNT(CASE WHEN status_pengumpulan_hasil_kuisioner = 'belum upload' THEN 1 END) AS belum_upload,
        COUNT(CASE WHEN status_pengumpulan_hasil_kuisioner = 'ditolak' THEN 1 END) AS tidak_terverifikasi
    FROM hasil_kuisioner;
";
$hasil_kuisionerResult = sqlsrv_query($conn, $hasil_kuisionerQuery);
$hasil_kuisionerRow = sqlsrv_fetch_array($hasil_kuisionerResult, SQLSRV_FETCH_ASSOC);

$bebas_pinjam_buku_perpustakaanQuery = "
    SELECT 
        COUNT(CASE WHEN status_pengumpulan_bebas_pinjam_buku_perpustakaan = 'terverifikasi' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN status_pengumpulan_bebas_pinjam_buku_perpustakaan = 'pending' THEN 1 END) AS pending,
        COUNT(CASE WHEN status_pengumpulan_bebas_pinjam_buku_perpustakaan = 'belum upload' THEN 1 END) AS belum_upload,
        COUNT(CASE WHEN status_pengumpulan_bebas_pinjam_buku_perpustakaan = 'ditolak' THEN 1 END) AS tidak_terverifikasi
    FROM bebas_pinjam_buku_perpustakaan;
";
$bebas_pinjam_buku_perpustakaanResult = sqlsrv_query($conn, $bebas_pinjam_buku_perpustakaanQuery);
$bebas_pinjam_buku_perpustakaanRow = sqlsrv_fetch_array($bebas_pinjam_buku_perpustakaanResult, SQLSRV_FETCH_ASSOC);

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
                            Dashboard Admin Perpustakaan -
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
                                                    <th colspan="4">Dokumen</th>
                                                    <th rowspan="2">Total</th>
                                                </tr>
                                                <tr class="table-header bg-primary text-white">
                                                    <th>Hardcopy</th>
                                                    <th>Softcopy</th>
                                                    <th>Bebas Pinjaman Buku</th>
                                                    <th>Kuisioner</th>
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
                                                    $penyerahan_hardcopy = $penyerahan_hardcopyRow[$status] ?? 0;
                                                    $tugas_akhir_softcopy = $tugas_akhir_softcopyRow[$status] ?? 0;
                                                    $hasil_kuisioner = $hasil_kuisionerRow[$status] ?? 0;
                                                    $bebas_pinjam_buku_perpustakaan = $bebas_pinjam_buku_perpustakaanRow[$status] ?? 0;

                                                    $total = $penyerahan_hardcopy + $tugas_akhir_softcopy + $hasil_kuisioner + $bebas_pinjam_buku_perpustakaan;

                                                    echo "<tr>
                                                            <td class='status'>
                                                                <span class='badge $statusClass p-2 rounded text-uppercase'
                                                                    style='cursor: pointer;'
                                                                    title='" . htmlspecialchars($status) . "'>
                                                                    " . htmlspecialchars($status) . "
                                                                </span>
                                                            </td>
                                                            <td>$penyerahan_hardcopy</td>
                                                            <td>$tugas_akhir_softcopy</td>
                                                            <td>$bebas_pinjam_buku_perpustakaan</td>
                                                            <td>$hasil_kuisioner</td>
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

</body>

</html>