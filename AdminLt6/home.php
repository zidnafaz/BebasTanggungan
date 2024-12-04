<!-- Admin Lantai 6 -->

<?php
include '../koneksi.php';

// Query untuk TOEIC
$toeicQuery = "
    SELECT 
        COUNT(CASE WHEN t.status_pengumpulan_toeic = 'terkonfirmasi' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN t.status_pengumpulan_toeic = 'pending' THEN 1 END) AS perlu_verifikasi,
        COUNT(CASE WHEN t.status_pengumpulan_toeic = 'belum upload' THEN 1 END) AS belum_upload,
        COUNT(CASE WHEN t.status_pengumpulan_toeic = 'tidak terkonfirmasi' THEN 1 END) AS tidak_terverifikasi
    FROM toeic t
";
$toeicResult = sqlsrv_query($conn, $toeicQuery);
$toeicRow = sqlsrv_fetch_array($toeicResult, SQLSRV_FETCH_ASSOC);

// Query untuk Penyerahan Skripsi
$skripsiQuery = "
    SELECT 
        COUNT(CASE WHEN ps.status_pengumpulan_penyerahan_skripsi = 'terkonfirmasi' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN ps.status_pengumpulan_penyerahan_skripsi = 'pending' THEN 1 END) AS perlu_verifikasi,
        COUNT(CASE WHEN ps.status_pengumpulan_penyerahan_skripsi = 'belum upload' THEN 1 END) AS belum_upload,
        COUNT(CASE WHEN ps.status_pengumpulan_penyerahan_skripsi = 'tidak terkonfirmasi' THEN 1 END) AS tidak_terverifikasi
    FROM penyerahan_skripsi ps
";
$skripsiResult = sqlsrv_query($conn, $skripsiQuery);
$skripsiRow = sqlsrv_fetch_array($skripsiResult, SQLSRV_FETCH_ASSOC);

// Query untuk Penyerahan PKL
$pklQuery = "
    SELECT 
        COUNT(CASE WHEN pp.status_pengumpulan_penyerahan_pkl = 'terkonfirmasi' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN pp.status_pengumpulan_penyerahan_pkl = 'pending' THEN 1 END) AS perlu_verifikasi,
        COUNT(CASE WHEN pp.status_pengumpulan_penyerahan_pkl = 'belum upload' THEN 1 END) AS belum_upload,
        COUNT(CASE WHEN pp.status_pengumpulan_penyerahan_pkl = 'tidak terkonfirmasi' THEN 1 END) AS tidak_terverifikasi
    FROM penyerahan_pkl pp
";
$pklResult = sqlsrv_query($conn, $pklQuery);
$pklRow = sqlsrv_fetch_array($pklResult, SQLSRV_FETCH_ASSOC);

// Query untuk Bebas Kompen
$kompenQuery = "
    SELECT 
        COUNT(CASE WHEN bk.status_pengumpulan_bebas_kompen = 'terkonfirmasi' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN bk.status_pengumpulan_bebas_kompen = 'pending' THEN 1 END) AS perlu_verifikasi,
        COUNT(CASE WHEN bk.status_pengumpulan_bebas_kompen = 'belum upload' THEN 1 END) AS belum_upload,
        COUNT(CASE WHEN bk.status_pengumpulan_bebas_kompen = 'tidak terkonfirmasi' THEN 1 END) AS tidak_terverifikasi
    FROM bebas_kompen bk
";
$kompenResult = sqlsrv_query($conn, $kompenQuery);
$kompenRow = sqlsrv_fetch_array($kompenResult, SQLSRV_FETCH_ASSOC);

// Query untuk Penyerahan Kebenaran Data
$kebenaranQuery = "
    SELECT 
        COUNT(CASE WHEN pkd.status_pengumpulan_penyerahan_kebenaran_data = 'terkonfirmasi' THEN 1 END) AS terverifikasi,
        COUNT(CASE WHEN pkd.status_pengumpulan_penyerahan_kebenaran_data = 'pending' THEN 1 END) AS perlu_verifikasi,
        COUNT(CASE WHEN pkd.status_pengumpulan_penyerahan_kebenaran_data = 'belum upload' THEN 1 END) AS belum_upload,
        COUNT(CASE WHEN pkd.status_pengumpulan_penyerahan_kebenaran_data = 'tidak terkonfirmasi' THEN 1 END) AS tidak_terverifikasi
    FROM penyerahan_kebenaran_data pkd
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Card untuk Keseluruhan -->
                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 mb-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Data Keseluruhan File</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- Sub-Cards ditampilkan secara vertikal -->

                                    <!-- Terverifikasi -->
                                    <div class="card border-left-info mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                        Terverifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $toeicRow['terverifikasi'] + $skripsiRow['terverifikasi'] + $pklRow['terverifikasi'] + $kompenRow['terverifikasi'] + $kebenaranRow['terverifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Perlu Verifikasi -->
                                    <div class="card border-left-primary mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Perlu Verifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $toeicRow['perlu_verifikasi'] + $skripsiRow['perlu_verifikasi'] + $pklRow['perlu_verifikasi'] + $kompenRow['perlu_verifikasi'] + $kebenaranRow['perlu_verifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Belum Upload -->
                                    <div class="card border-left-warning mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                        Belum Upload</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $toeicRow['belum_upload'] + $skripsiRow['belum_upload'] + $pklRow['belum_upload'] + $kompenRow['belum_upload'] + $kebenaranRow['belum_upload']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-upload fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tidak Terverifikasi -->
                                    <div class="card border-left-danger mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                        Tidak Terverifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $toeicRow['tidak_terverifikasi'] + $skripsiRow['tidak_terverifikasi'] + $pklRow['tidak_terverifikasi'] + $kompenRow['tidak_terverifikasi'] + $kebenaranRow['tidak_terverifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card untuk Laporan Skripsi -->
                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 mb-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Data Laporan Skripsi</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- Sub-Cards ditampilkan secara vertikal -->
                                    <div class="card border-left-info mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                        Terverifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $skripsiRow['terverifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-left-primary mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Perlu Verifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $skripsiRow['perlu_verifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-left-warning mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                        Belum Upload</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $skripsiRow['belum_upload']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-upload fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-left-danger mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                        Tidak Terverifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $skripsiRow['tidak_terverifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card untuk Laporan PKL -->
                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 mb-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Data Laporan PKL</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- Sub-Cards ditampilkan secara vertikal -->
                                    <div class="card border-left-info mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                        Terverifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $pklRow['terverifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-left-primary mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Perlu Verifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $pklRow['perlu_verifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-left-warning mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                        Belum Upload</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $pklRow['belum_upload']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-upload fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-left-danger mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                        Tidak Terverifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $pklRow['tidak_terverifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card untuk TOEIC -->
                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 mb-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Data TOEIC</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- Sub-Cards ditampilkan secara vertikal -->
                                    <div class="card border-left-info mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                        Terverifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $toeicRow['terverifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-left-primary mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Perlu Verifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $toeicRow['perlu_verifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-left-warning mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                        Belum Upload</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $toeicRow['belum_upload']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-upload fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-left-danger mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                        Tidak Terverifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $toeicRow['tidak_terverifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card untuk Bebas Kompen -->
                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 mb-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Data Bebas Kompen</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- Sub-Cards ditampilkan secara vertikal -->
                                    <div class="card border-left-info mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                        Terverifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $kompenRow['terverifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-left-primary mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Perlu Verifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $kompenRow['perlu_verifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-left-warning mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                        Belum Upload</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $kompenRow['belum_upload']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-upload fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-left-danger mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                        Tidak Terverifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $kompenRow['tidak_terverifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card untuk Kebenaran Data -->
                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 mb-4" max-width="20%">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Data Kebenaran Data</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- Sub-Cards ditampilkan secara vertikal -->
                                    <div class="card border-left-info mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                        Terverifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $kebenaranRow['terverifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-left-primary mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Perlu Verifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $kebenaranRow['perlu_verifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-left-warning mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                        Belum Upload</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $kebenaranRow['belum_upload']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-upload fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-left-danger mb-4">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                        Tidak Terverifikasi</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $kebenaranRow['tidak_terverifikasi']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                                </div>
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
                    <a class="btn btn-primary" href="login.html">Logout</a>
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