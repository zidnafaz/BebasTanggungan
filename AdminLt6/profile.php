<?php  
include '../login.php';
include '../koneksi.php';

try {
    $sql = "SELECT id_karyawan, nama_karyawan, nomor_telfon_karyawan, alamat_karyawan, tanggal_lahir_karyawan, jenis_kelamin_karyawan 
    FROM dbo.admin a
    WHERE a.id_karyawan = ?";

    session_start(); 
    
    if (isset($_COOKIE['id'])) {
        $inputUsername = $_COOKIE['id'];
    } else {
        die("Anda harus login terlebih dahulu.");
    }

    $param = array($inputUsername);
    $stmt = sqlsrv_query($conn, $sql, $param);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true)); // Tangani error query
    }

    // Ambil hasil query
    if (sqlsrv_has_rows($stmt)) {
        $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC); // Ambil data sebagai array asosiatif
    } else {
        echo "Data tidak ditemukan.";
        $result = null; // Pastikan $result diset null jika data tidak ditemukan
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
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
                        <h1 class="h3 mb-0 text-gray-800">Profil <?= htmlspecialchars($result['nama_karyawan'] ?? '') ?></h1>
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
                                                <p><?= htmlspecialchars($result['nama_karyawan'] ?? '') ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Jenis Kelamin :</strong>
                                                <p>
                                                <?php
                                                        if ($result['jenis_kelamin_karyawan'] == 'L') {
                                                            echo 'Laki-Laki';
                                                        } elseif ($result['jenis_kelamin_karyawan'] == 'P') {
                                                            echo 'Perempuan';
                                                        }
                                                    ?>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Alamat :</strong>
                                                <p><?= htmlspecialchars($result['alamat_karyawan'] ?? '') ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Tanggal Lahir :</strong>
                                                <p><?= htmlspecialchars($result['tanggal_lahir_karyawan']->format('Y-m-d') ?? 'Tanggal tidak tersedia') ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>No Telepon :</strong>
                                                <p><?= htmlspecialchars($result['nomor_telfon_karyawan'] ?? '') ?></p>
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