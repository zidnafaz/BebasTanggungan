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
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Daftar Mahasiswa</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

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

        /* Mengubah warna latar belakang baris tabel */
        table.dataTable tbody tr:nth-child(odd) {
            background-color: #fff;
            /* Lebih gelap dari warna default */
        }

        table.dataTable tbody tr:nth-child(even) {
            background-color: #fff;
            /* Lebih gelap dari warna default */
        }

        /* Mengubah warna baris yang sedang dipilih */
        table.dataTable tbody tr.selected {
            background-color: #d6d6d6 !important;
            /* Warna ketika baris dipilih */
        }

        /* Menyesuaikan warna header */
        table.dataTable thead th {
            background-color: #4e73df;
            /* Warna header tabel */
            color: white;
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
            <li class="nav-item" id="nav-dashboard">
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
            <li class="nav-item active" id="nav-upload_skripsi">
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
                                <img class="img-profile rounded-circle" src="../img/circle-user-solid.svg">
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
                    <h1 class="h3 mb-2 text-gray-800">Data Verifikasi Aplikasi</h1>
                    <p class="mb-4">Konfirmasi Data Mahasiswa dengan seksama!</p>

                    <!-- DataTables Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Mahasiswa</h6>
                        </div>
                        <div class="card-body">

                            <!-- Filter Dropdown -->
                            <select id="statusFilter" class="form-control mb-3" style="width: 200px;">
                                <option value="">Filter by Status</option>
                                <option value="pending">Pending</option>
                                <option value="terverifikasi">Terverifikasi</option>
                                <option value="belum upload">Belum Upload</option>
                                <option value="ditolak">Ditolak</option>
                            </select>

                            <table class="table table-striped table-bordered" id="dataTable" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Status</th>
                                        <th>Jumlah Verifikasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT 
                                                m.nim,
                                                m.nama_mahasiswa,
                                                CASE
                                                    WHEN pj.status_pengumpulan_publikasi_jurnal = 'ditolak' OR a.status_pengumpulan_aplikasi = 'ditolak' OR s.status_pengumpulan_skripsi = 'ditolak' THEN 'ditolak'
                                                    WHEN pj.status_pengumpulan_publikasi_jurnal = 'pending' OR a.status_pengumpulan_aplikasi = 'pending' OR s.status_pengumpulan_skripsi = 'pending' THEN 'pending'
                                                    WHEN pj.status_pengumpulan_publikasi_jurnal = 'belum upload' OR a.status_pengumpulan_aplikasi = 'belum upload' OR s.status_pengumpulan_skripsi = 'belum upload' THEN 'belum upload'
                                                    ELSE 'terverifikasi'
                                                END AS status,
                                                CONCAT(
                                                    (CASE WHEN pj.status_pengumpulan_publikasi_jurnal = 'terverifikasi' THEN 1 ELSE 0 END +
                                                    CASE WHEN a.status_pengumpulan_aplikasi = 'terverifikasi' THEN 1 ELSE 0 END +
                                                    CASE WHEN s.status_pengumpulan_skripsi = 'terverifikasi' THEN 1 ELSE 0 END),
                                                    '/3'
                                                ) AS jumlah_verifikasi
                                            FROM 
                                                mahasiswa m
                                            LEFT JOIN 
                                                publikasi_jurnal pj ON m.nim = pj.nim
                                            LEFT JOIN 
                                                aplikasi a ON m.nim = a.nim
                                            LEFT JOIN 
                                                skripsi s ON m.nim = s.nim
                                            ORDER BY 
                                                CASE 
                                                    WHEN (pj.status_pengumpulan_publikasi_jurnal = 'pending' OR a.status_pengumpulan_aplikasi = 'pending' OR s.status_pengumpulan_skripsi = 'pending') THEN 1
                                                    WHEN (pj.status_pengumpulan_publikasi_jurnal = 'ditolak' OR a.status_pengumpulan_aplikasi = 'ditolak' OR s.status_pengumpulan_skripsi = 'ditolak') THEN 2
                                                    WHEN (pj.status_pengumpulan_publikasi_jurnal = 'belum upload' OR a.status_pengumpulan_aplikasi = 'belum upload' OR s.status_pengumpulan_skripsi = 'belum upload') THEN 3
                                                    WHEN (pj.status_pengumpulan_publikasi_jurnal = 'terverifikasi' AND a.status_pengumpulan_aplikasi = 'terverifikasi' AND s.status_pengumpulan_skripsi = 'terverifikasi') THEN 4
                                                    ELSE 5
                                                END ASC";

                                    $stmt = sqlsrv_query($conn, $sql);
                                    if ($stmt === false) {
                                        die(print_r(sqlsrv_errors(), true));
                                    }

                                    $no = 1;
                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                        $nim = $row['nim'];
                                        $nama = $row['nama_mahasiswa'];
                                        $status = $row['status'];
                                        $jumlah_verifikasi = $row['jumlah_verifikasi'];

                                        // Tentukan kelas badge berdasarkan status
                                        $statusClass = match (strtolower($status)) {
                                            'belum upload' => 'bg-secondary text-white',
                                            'pending' => 'bg-warning text-dark',
                                            'ditolak' => 'bg-danger text-white',
                                            'terverifikasi' => 'bg-success text-white',
                                            default => 'bg-light text-dark'
                                        };

                                        echo "<tr>";
                                        echo "<td>" . $no++ . "</td>";
                                        echo "<td>" . htmlspecialchars($nim) . "</td>";
                                        echo "<td>" . htmlspecialchars($nama) . "</td>";
                                        echo "<td class='status'>
                                                <span class='badge $statusClass p-2 rounded text-uppercase'
                                                    style='cursor: pointer;'
                                                    title='" . htmlspecialchars($status) . "'>
                                                    " . htmlspecialchars($status) . "
                                                </span>
                                            </td>";
                                        echo "<td>" . htmlspecialchars($jumlah_verifikasi) . "</td>";
                                        echo "<td><a href='detail_mahasiswa.php?nim=" . urlencode($nim) . "' class='btn btn-primary btn-sm' target='_blank'><i class='fa fa-edit'></i> Detail</a></td>";
                                        echo "</tr>";
                                    }

                                    sqlsrv_free_stmt($stmt);
                                    ?>
                                </tbody>

                            </table>
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
                        <span>Copyright &copy; Your Website 2020</span>
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

    <!-- jQuery (dari CDN atau file lokal, pilih salah satu saja) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5 JS Bundle (termasuk Popper.js) -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery Easing Plugin -->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- sb-admin-2 Script -->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins (Chart.js) -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts (Chart demos) -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Bootstrap 5 JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            var table = $('#dataTable').DataTable({
                "ordering": true,
                "searching": true,
                "paging": true,
                "info": true,
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ entri per halaman",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "info": "Menampilkan _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data",
                    "infoFiltered": "(difilter dari _MAX_ total entri)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "order": [[2, 'asc']], // Mengurutkan berdasarkan kolom status
                "columnDefs": [
                    {
                        "targets": 2,
                        "type": "num",  // Atur untuk menggunakan urutan numerik
                        "orderData": [2]
                    }
                ]
            });

            // Filter the rows based on the status from the dropdown
            $('#statusFilter').on('change', function () {
                var status = $(this).val();
                table.column(3).search(status).draw(); // Column 3 is the Status
            });
        });

    </script>

</body>

</html>