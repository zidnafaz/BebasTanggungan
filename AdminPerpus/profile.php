<?php  
include '../login.php';
include '../koneksi.php';
include '../data/dataAdmin.php';
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
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <style>
    .card-fixed-height {
        height: 200px;
    }

    strong {
        font-size: 22px;
    }

    p {
        font-size: 20px;
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
            <!-- Nav Item - Verifikasi -->
            <li class="nav-item" id="nav-tugas_akhir">
                <a class="nav-link" href="softcopy.php">
                    <i class="fas fa-solid fa-book"></i>
                    <span>Tugas Akhir</span></a>
            </li>

            <li class="nav-item" id="nav-kuisioner">
                <a class="nav-link" href="kuisioner.php">
                    <i class="fas fa-solid fa-file"></i>
                    <span>Kuisioner</span></a>
            </li>

            <li class="nav-item" id="nav-hardcopy">
                <a class="nav-link" href="hardcopy.php">
                    <i class="fas fa-solid fa-file"></i>
                    <span>Hard Copy</span></a>
            </li>

            <li class="nav-item" id="nav-bebas_pinjaman">
                <a class="nav-link" href="bebas_pinjaman.php">
                    <i class="fas fa-solid fa-file"></i>
                    <span>Bebas Pinjaman</span></a>
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
                        <h1 class="h3 mb-0 text-gray-800">Profil
                            <?= htmlspecialchars($resultUser['nama_karyawan'] ?? '') ?></h1>
                    </div>

                    <!-- Content Row -->
                    <div class="container rounded shadow mt-5">
                        <div class="row" style="size : 200px;">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h1>Informasi Pribadi</h1>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-5">
                                            <div class="col-md-6">
                                                <strong>Nama Lengkap :</strong>
                                                <p><?= htmlspecialchars($resultUser['nama_karyawan'] ?? '') ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Jenis Kelamin :</strong>
                                                <p>
                                                    <?php
                                                        if ($resultUser['jenis_kelamin_karyawan'] == 'L') {
                                                            echo 'Laki-Laki';
                                                        } elseif ($resultUser['jenis_kelamin_karyawan'] == 'P') {
                                                            echo 'Perempuan';
                                                        }
                                                    ?>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Alamat :</strong>
                                                <p><?= htmlspecialchars($resultUser['alamat_karyawan'] ?? '') ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Tanggal Lahir :</strong>
                                                <p><?= htmlspecialchars($resultUser['tanggal_lahir_karyawan']->format('Y-m-d') ?? 'Tanggal tidak tersedia') ?>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>No Telepon :</strong>
                                                <p><?= htmlspecialchars($resultUser['nomor_telfon_karyawan'] ?? '') ?>
                                                </p>
                                            </div>
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

</body>

</html>