<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .bg-login-image .p-5 {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            /* Pastikan tinggi div ini mencakup seluruh kolom */
        }

        .bg-login-image img {
            max-width: 100%;
            /* Menyesuaikan ukuran gambar agar sesuai div */
            height: auto;
        }
    </style>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <div class="p-5">
                                    <img src="img/logo-polinema.png">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="username" aria-describedby="emailHelp"
                                                placeholder="Enter Your Username ...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="password" placeholder="Enter Your Password ...">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <a href="homeAdmin1.html" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </a>

                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>

<?php
include 'koneksi.php';

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $inputUsername = $_POST['username'];
        $inputPassword = $_POST['password'];

        // Query untuk memeriksa username dan password
        $sql = "SELECT status FROM dbo.login WHERE username = ? AND password = ?";
        $params = array($inputUsername, $inputPassword);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die("Kesalahan saat menjalankan query: " . print_r(sqlsrv_errors(), true));
        }

        // Memeriksa apakah ada hasil
        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // Pengalihan berdasarkan status
            if ($row['status'] === 'adminlt7') {
                header("Location: adminLt7.html");
            } elseif ($row['status'] === 'adminlt6') {
                header("Location: adminLt6.html");
            } elseif ($row['status'] === 'mahasiswa') {
                header("Location: mahasiswa.html");
            } else {
                echo "Status tidak dikenal.";
            }
            exit;
        } else {
            // Jika username/password tidak cocok
            echo "Username atau password salah.";
        }

        // Menutup statement
        sqlsrv_free_stmt($stmt);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
