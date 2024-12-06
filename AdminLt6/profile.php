<?php  
include '../login.php';
include '../koneksi.php';

try {
    $sql = " 
    SELECT nim, nama_mahasiswa, jurusan_mahasiswa, prodi_mahasiswa 
    FROM dbo.mahasiswa m
    WHERE m.nim = ?";

    session_start(); // Tambahkan di atas file mahasiswa.php
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
                        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="container rounded shadow mt-5">
                        <div class="row" style="size : 200px;">
                            <div class="col-md-4 border-right">
                                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img
                                        class="rounded-circle mt-5" src="https://i.imgur.com/0eg0aG0.jpg"
                                        width="90"><span class="font-weight-bold">John Doe</span><span
                                        class="text-black-50">Admin lt ...</span>
                                        <span>United States</span></div>
                            </div>
                            <div class="col-md-8">
                                <div class="p-3 py-5">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex flex-row align-items-center back" style="margin-left: 200px">
                                            <h2>Profile</h2>
                                        </div>
                                        <!-- <a href="editProfile.html" class="btn btn-warning btn-icon-split">
                                            <span class="text">Edit Profile</span>
                                        </a> -->
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6" style="margin-left:200px;"><?= htmlspecialchars($result['nim'] ?? '') ?></div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6" style="margin-left:200px;"><?= htmlspecialchars($result['jurusan_mahasiswa'] ?? '') ?></div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6" style="margin-left:200px"><?= htmlspecialchars($result['nama_mahasiswa'] ?? '') ?></div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6" style="margin-left:200px"><?= htmlspecialchars($result['prodi_mahasiswa'] ?? '') ?></div>
                                    </div>
                                    <div class="mt-5 text-right">
                                        <!-- <button class="btn btn-primary profile-button"
                                            type="button">Save Profile</button> -->
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
                    <a class="btn btn-primary" href="login.html">Logout</a>
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

        fetch('topbar.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('topbar').innerHTML = data;
            })
            .catch(error => console.error('Error loading topbar:', error));

    </script>
</body>

</html>