<?php
include '../koneksi.php';

if (!isset($_COOKIE['id'])) {
    header("Location: ../index.html");
    exit();
} else {
    $username = $_COOKIE['id'];
}

$nim = $_COOKIE['id'];

$query = "
    SELECT 
        (CASE WHEN MIN(CASE WHEN status_pengumpulan_penyerahan_skripsi = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS skripsi,
        (CASE WHEN MIN(CASE WHEN status_pengumpulan_penyerahan_pkl = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS pkl,
        (CASE WHEN MIN(CASE WHEN status_pengumpulan_toeic = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS toeic,
        (CASE WHEN MIN(CASE WHEN status_pengumpulan_bebas_kompen = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS bebas_kompen,
        (CASE WHEN MIN(CASE WHEN status_pengumpulan_publikasi_jurnal = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS publikasi_jurnal,
        (CASE WHEN MIN(CASE WHEN status_pengumpulan_aplikasi = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS aplikasi,
        (CASE WHEN MIN(CASE WHEN status_pengumpulan_skripsi = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS status_skripsi,
        (CASE WHEN MIN(CASE WHEN status_pengumpulan_penyerahan_kebenaran_data = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS penyerahan_kebenaran_data
    FROM dbo.penyerahan_skripsi
    LEFT JOIN dbo.penyerahan_pkl ON penyerahan_skripsi.nim = penyerahan_pkl.nim
    LEFT JOIN dbo.toeic ON penyerahan_skripsi.nim = toeic.nim
    LEFT JOIN dbo.bebas_kompen ON penyerahan_skripsi.nim = bebas_kompen.nim
    LEFT JOIN dbo.publikasi_jurnal ON penyerahan_skripsi.nim = publikasi_jurnal.nim
    LEFT JOIN dbo.aplikasi ON penyerahan_skripsi.nim = aplikasi.nim
    LEFT JOIN dbo.skripsi ON penyerahan_skripsi.nim = skripsi.nim
    LEFT JOIN dbo.penyerahan_kebenaran_data ON penyerahan_skripsi.nim = penyerahan_kebenaran_data.nim
    WHERE penyerahan_skripsi.nim = '$nim'
";

// Eksekusi query dengan parameterized query untuk menghindari SQL Injection
$params = array($nim);
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die("Kesalahan pada eksekusi query: " . print_r(sqlsrv_errors(), true));
}

// Ambil hasil query
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
sqlsrv_free_stmt($stmt);

if (!$row) {
    die("Gagal mengambil data: " . print_r(sqlsrv_errors(), true));
}

// Mengecek apakah semua status sudah terverifikasi
$allConfirmed = $row['skripsi'] && $row['pkl'] && $row['toeic'] && $row['bebas_kompen'] && $row['publikasi_jurnal'] && $row['aplikasi'] && $row['status_skripsi'] && $row['penyerahan_kebenaran_data'];

// Query untuk mengambil data mahasiswa
$sql = "SELECT m.nim, m.nama_mahasiswa, m.jurusan_mahasiswa, m.prodi_mahasiswa
        FROM dbo.mahasiswa m
        WHERE m.nim = ?";
$result = sqlsrv_query($conn, $sql, $params);

if ($result === false) {
    die("Kesalahan saat menjalankan query mahasiswa: " . print_r(sqlsrv_errors(), true));
}

// Ambil data mahasiswa
$nama_mahasiswa = "";
if ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $nama_mahasiswa = $row['nama_mahasiswa'];
    $nim = $row['nim'];
    $jurusan = $row['jurusan_mahasiswa'];
    $prodi = $row['prodi_mahasiswa'];
}
sqlsrv_free_stmt($result);

// Query untuk mengambil tanggal konfirmasi dari tabel adminlt7_konfirmasi
$sqlTanggal = "SELECT tanggal_adminlt7_konfirmasi FROM dbo.adminlt7_konfirmasi WHERE nim = ?";
$resultTanggal = sqlsrv_query($conn, $sqlTanggal, $params);

if ($resultTanggal === false) {
    die("Kesalahan saat menjalankan query tanggal: " . print_r(sqlsrv_errors(), true));
}

// Mengecek apakah tanggal hanya diambil jika semua status sudah terverifikasi
$tanggalLt7 = null;
$tanggalLt6 = null;
if ($allConfirmed) {
    // Query untuk mengambil tanggal konfirmasi dari tabel adminlt7_konfirmasi
    $sqlTanggalLt7 = "SELECT tanggal_adminlt7_konfirmasi FROM dbo.adminlt7_konfirmasi WHERE nim = ?";
    $resultTanggalLt7 = sqlsrv_query($conn, $sqlTanggalLt7, $params);

    if ($resultTanggalLt7 === false) {
        die("Kesalahan saat menjalankan query tanggal: " . print_r(sqlsrv_errors(), true));
    }

    if ($row = sqlsrv_fetch_array($resultTanggal, SQLSRV_FETCH_ASSOC)) {
        $tanggalLt7 = $row['tanggal_adminlt7_konfirmasi'];
    }

    // Jika $tanggal adalah objek DateTime, ubah menjadi string
    if ($tanggalLt7 instanceof DateTime) {
        $tanggalLt7 = $tanggalLt7->format('d-m-Y');  // Atur format sesuai kebutuhan
    }

    // Gunakan htmlspecialchars untuk mencegah XSS
    $tanggalLt7 = htmlspecialchars($tanggalLt7, ENT_QUOTES, 'UTF-8');

    sqlsrv_free_stmt($resultTanggalLt7);

    $sqlTanggalLt6 = "SELECT tanggal_adminlt6_konfirmasi FROM dbo.adminlt6_konfirmasi WHERE nim = ?";
    $resultTanggalLt6 = sqlsrv_query($conn, $sqlTanggalLt6, $params);

    if ($resultTanggalLt6 === false) {
        die("Kesalahan saat menjalankan query tanggal: " . print_r(sqlsrv_errors(), true));
    }

    if ($row = sqlsrv_fetch_array($resultTanggalLt6, SQLSRV_FETCH_ASSOC)) {
        $tanggalLt6 = $row['tanggal_adminlt6_konfirmasi'];
    }

    // Jika $tanggal adalah objek DateTime, ubah menjadi string
    if ($tanggalLt6 instanceof DateTime) {
        $tanggalLt6 = $tanggalLt6->format('d-m-Y');  // Atur format sesuai kebutuhan
    }

    // Gunakan htmlspecialchars untuk mencegah XSS
    $tanggalLt6 = htmlspecialchars($tanggalLt6, ENT_QUOTES, 'UTF-8');

    sqlsrv_free_stmt($resultTanggalLt6);
}

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

    <title>Verifikasi</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- DataTables -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- jQuery (from CDN) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables (from CDN) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script type="module">
        import { PDFDocument, rgb } from 'https://cdn.jsdelivr.net/npm/pdf-lib@1.17.1/+esm';

        document.addEventListener('DOMContentLoaded', () => {
            const button = document.getElementById('downloadButton');

            button.addEventListener('click', async () => {
                // Fungsi untuk mengambil nilai cookie
                function getCookie(name) {
                    let cookieArr = document.cookie.split(";");
                    for (let i = 0; i < cookieArr.length; i++) {
                        let cookie = cookieArr[i].trim();
                        if (cookie.indexOf(name + "=") == 0) {
                            return cookie.substring(name.length + 1);
                        }
                    }
                    return "";
                }

                const username = getCookie('id');  // Ambil cookie 'id' (jika ada)
                const pdfPath = '../Documents/downloads/generate/Bebas_Tanggungan_Jurusan.pdf';  // Path ke file PDF
                const fontPath = './TimesNewRoman/TimesNewRoman.ttf';  // Path ke font kustom

                try {
                    // Muat PDF
                    const pdfResponse = await fetch(pdfPath);
                    if (!pdfResponse.ok) {
                        console.error('Failed to load PDF:', pdfResponse.statusText);
                        return;
                    }

                    const pdfArrayBuffer = await pdfResponse.arrayBuffer();
                    const pdfDoc = await PDFDocument.load(pdfArrayBuffer);

                    // Registrasikan fontkit (periksa apakah window.fontkit ada)
                    if (typeof window.fontkit === 'undefined') {
                        console.error('fontkit is not available!');
                        return;
                    }
                    pdfDoc.registerFontkit(window.fontkit);

                    // Muat font kustom
                    const fontResponse = await fetch(fontPath);
                    if (!fontResponse.ok) {
                        console.error('Failed to load font:', fontResponse.statusText);
                        return;
                    }

                    const fontArrayBuffer = await fontResponse.arrayBuffer();
                    const timesFont = await pdfDoc.embedFont(fontArrayBuffer);

                    // Ambil data dari PHP untuk dimasukkan ke PDF
                    const nama = "<?php echo htmlspecialchars($nama_mahasiswa, ENT_QUOTES, 'UTF-8'); ?>";
                    const nim = "<?php echo htmlspecialchars($nim, ENT_QUOTES, 'UTF-8'); ?>";
                    const prodi = "<?php echo htmlspecialchars($prodi, ENT_QUOTES, 'UTF-8'); ?>";
                    const tanggalLt7 = "<?php echo htmlspecialchars($tanggalLt7, ENT_QUOTES, 'UTF-8'); ?>";
                    const tanggalLt6 = "<?php echo htmlspecialchars($tanggalLt6, ENT_QUOTES, 'UTF-8'); ?>";

                    // Pastikan data PHP sudah terisi
                    if (!nama || !nim || !prodi || !tanggalLt7 || !tanggalLt6) {
                        console.error('Some PHP variables are not properly set');
                        return;
                    }

                    // Tambahkan teks ke halaman pertama
                    const pages = pdfDoc.getPages();
                    const firstPage = pages[0];

                    // Tentukan posisi teks untuk setiap field
                    firstPage.drawText(`${nama}`, {
                        x: 190,  // Koordinat X
                        y: 626,  // Koordinat Y
                        size: 12,
                        font: timesFont,
                        color: rgb(0, 0, 0),
                    });

                    firstPage.drawText(`${nim}`, {
                        x: 190,  // Koordinat X
                        y: 605,  // Koordinat Y
                        size: 12,
                        font: timesFont,
                        color: rgb(0, 0, 0),
                    });

                    firstPage.drawText(`${prodi}`, {
                        x: 190,  // Koordinat X
                        y: 584,  // Koordinat Y
                        size: 12,
                        font: timesFont,
                        color: rgb(0, 0, 0),
                    });

                    firstPage.drawText(`${tanggalLt7}`, {
                        x: 296,  // Koordinat X
                        y: 511,  // Koordinat Y
                        size: 9,
                        font: timesFont,
                        color: rgb(0, 0, 0),
                    });

                    firstPage.drawText(`${tanggalLt6}`, {
                        x: 296,  // Koordinat X
                        y: 413,  // Koordinat Y
                        size: 9,
                        font: timesFont,
                        color: rgb(0, 0, 0),
                    });

                    // TTD penanggung Jawab (Ketua Prodi)
                    firstPage.drawText(`${tanggalLt6}`, {
                        x: 462,  // Koordinat X
                        y: 474,  // Koordinat Y
                        size: 9,
                        font: timesFont,
                        color: rgb(0, 0, 0),
                    });

                    // TTD Ketua Jurusan
                    firstPage.drawText(`${tanggalLt6}`, {
                        x: 332,  // Koordinat X
                        y: 298,  // Koordinat Y
                        size: 12,
                        font: timesFont,
                        color: rgb(0, 0, 0),
                    });

                    // Unduh PDF yang telah dimodifikasi
                    const pdfBytes = await pdfDoc.save();
                    const blob = new Blob([pdfBytes], { type: 'application/pdf' });
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = `${nim}_Bebas_Tanggungan_Jurusan.pdf`;
                    link.click();
                } catch (error) {
                    console.error('Error generating PDF:', error);
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@pdf-lib/fontkit@0.0.4/dist/fontkit.umd.min.js"></script>

    <style>
        .status span {
            padding: 5px 10px;
            border-radius: 15px;
            color: white;
            font-weight: bold;
        }

        .status .badge-success {
            background-color: green;
        }

        .status .badge-danger {
            background-color: red;
        }

        #uploadModalHeader.bg-success {
            background-color: #28a745 !important;
            /* Hijau terang */
        }

        #uploadModalHeader.bg-danger {
            background-color: #dc3545 !important;
            /* Merah terang */
        }

        #uploadMessage {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        .modal-footer .btn-secondary {
            background-color: #6c757d !important;
            /* Abu-abu lebih terang */
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
            <li class="nav-item" id="nav-tugasAkhir">
                <a class="nav-link" href="jurusan.php">
                    <i class="fas fa-solid fa-book"></i>
                    <span>Jurusan</span></a>
            </li>

            <li class="nav-item active" id="nav-prodi">
                <a class="nav-link" href="prodi.php">
                    <i class="fas fa-solid fa-file-lines"></i>
                    <span>Program Studi</span></a>
            </li>

            <li class="nav-item" id="nav-akademik">
                <a class="nav-link" href="akademik.php">
                    <i class="fas fa-solid fa-file"></i>
                    <span>Akademik</span></a>
            </li>

            <li class="nav-item" id="nav-grapol">
                <a class="nav-link" href="grapol.php">
                    <i class="fas fa-solid fa-file-invoice"></i>
                    <span>Graha Polinema</span></a>
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
                                    <?php echo htmlspecialchars($nama_mahasiswa); ?>
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
                    <h1 class="h3 mb-2 text-gray-800">Verifikasi Berkas Program Studi</h1>
                    <p class="mb-4">Verifikasi berkas pada program studi (lantai 6) yang akan diverifikasi oleh ibu Ila (<a
                            target="_blank" href="https://wa.me/6281232245969">081232245969</a> - <i>Chat Only</i>) </p>

                    <!-- DataTables Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Berkas Yang Perlu Diunggah</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div id="table"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Download Dokumen -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Download Template Dokumen</h6>
                        </div>
                        <div class="card-body">
                            <p>Unduh template dokumen yang disediakan (sesuaikan dengan kebutuhan verifikasi), isi
                                sesuai petunjuk, lalu unggah untuk
                                proses verifikasi.</p>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dokumenTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Dokumen</th>
                                            <th>Keterangan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Tanda Terima Laporan Skripsi</td>
                                            <td>-</td>
                                            <td><a href="../Documents/downloads/template/[Form] Tanda Terima Laporan Skripsi_SIB.docx"
                                                    class="btn btn-success" download><i class="fas fa-download"></i>
                                                    Download</a></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Tanda Terima Laporan PKL / Magang</td>
                                            <td>-</td>
                                            <td><a href="../Documents/downloads/template/[Form] Tanda Terima Laporan PKL_Magang_SIB.docx"
                                                    class="btn btn-success" download><i class="fas fa-download"></i>
                                                    Download</a></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Surat Keterangan Bebas Kompen</td>
                                            <td>Apabila ada kompen, lampiran bukti kompennya pada halaman berikutnya
                                            </td>
                                            <td><a href="../Documents/downloads/template/[Form] Bebas Kompen_SIB.docx"
                                                    class="btn btn-success" download><i class="fas fa-download"></i>
                                                    Download</a></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Surat Keterangan TOEIC</td>
                                            <td>Surat ini dibutuhkan apabila skor kurang dari 450 untuk D4 dan 400 untuk
                                                D3</td>
                                            <td><a href="../Documents/downloads/template/Surat Keterangan mengikuti TOIEC.pdf"
                                                    class="btn btn-success" download><i class="fas fa-download"></i>
                                                    Download</a></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Surat Pernyataan Kebenaran Data Diri</td>
                                            <td>-</td>
                                            <td><a href="../Documents/downloads/template/[Template] Surat Kebenaran Data Diri_SIB.doc"
                                                    class="btn btn-success" download><i class="fas fa-download"></i>
                                                    Download</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Card Bebas Tanggungan -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Bebas Tanggungan Jurusan</h6>
                        </div>
                        <div class="card-body">
                            <p>Surat ini meliputi Bebas Tanggungan Jurusan lantai 6 dan 7.</p>
                            <?php if ($allConfirmed): ?>
                                <button class="btn btn-success" id="downloadButton" download><i class="fas fa-download"></i>
                                    Download</button>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled><i class="fas fa-download"></i> Disable</button>
                            <?php endif; ?>
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

    <!-- Modal untuk Upload -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header bg-primary text-white d-flex justify-content-center align-items-center">
                    <h5 class="modal-title" id="uploadModalLabel">Add Documents</h5>
                    <button type="button" class="close text-white ml-auto" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <form id="uploadForm" method="post" enctype="multipart/form-data">
                        <!-- Hidden Input for uploadDir -->
                        <input type="hidden" name="uploadDir" id="uploadDir">

                        <!-- File Upload Input -->
                        <div class="form-group">
                            <label for="file" class="col-form-label">Attachments:</label>
                            <div class="file-upload-box text-center border rounded p-4">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted"></i>
                                <p class="text-muted mt-2">
                                    Attach your files here <br> or <br>
                                    <label for="file" class="text-primary" style="cursor: pointer;">Browse files</label>
                                </p>
                                <input type="file" class="form-control-file d-none" id="file" name="file" required
                                    onchange="updateFileName()">
                            </div>
                            <small class="form-text text-muted">Accepted file type: pdf only (rar/zip for aplikasi)</small>
                        </div>

                        <!-- Preview Filename -->
                        <div class="form-group">
                            <label for="fileName" class="col-form-label">Selected File:</label>
                            <input type="text" class="form-control" id="fileName" placeholder="No file chosen" readonly>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Status Upload -->
    <div class="modal fade" id="uploadModalStatus" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" id="uploadModalHeader">
                    <h5 class="modal-title" id="uploadModalLabel">Upload Status</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-check-circle fa-3x text-success" id="successIcon" style="display: none;"></i>
                    <i class="fas fa-times-circle fa-3x text-danger" id="errorIcon" style="display: none;"></i>
                    <p id="uploadMessage" class="mt-3"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

        // Ajax untuk mengambil data dan menginisialisasi DataTables
        $(document).ready(function () {
            // Memuat data dari data.php
            $.ajax({
                url: 'data_prodi.php', // File PHP untuk memuat data
                type: 'GET', // Gunakan metode GET
                success: function (response) {
                    // Masukkan data ke dalam tabel
                    $('#table').html(`<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Berkas</th>
                        <th>Status Pengumpulan</th>
                        <th>Keterangan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>${response}</tbody>
            </table>`);

                    // Inisialisasi DataTables setelah data dimasukkan
                    $('#dataTable').DataTable({
                        "paging": true, // Menampilkan pagination
                        "searching": true, // Menambahkan fitur pencarian
                        "ordering": true, // Menambahkan fitur sorting
                        "info": true // Menampilkan informasi jumlah data
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        $(document).ready(function () {
            $('#uploadForm').submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: 'upload.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // Tutup modal upload
                        $('#uploadModal').modal('hide');

                        // Tampilkan ikon dan teks berdasarkan respons
                        if (response.includes("berhasil")) {
                            $('#successIcon').show();
                            $('#errorIcon').hide();
                            $('#uploadModalHeader')
                                .removeClass('bg-danger')
                                .addClass('bg-success text-white');
                            $('#uploadMessage').css('color', '#155724'); // Hijau tua untuk teks
                        } else {
                            $('#successIcon').hide();
                            $('#errorIcon').show();
                            $('#uploadModalHeader')
                                .removeClass('bg-success')
                                .addClass('bg-danger text-white');
                            $('#uploadMessage').css('color', '#721c24'); // Merah tua untuk teks
                        }

                        // Tampilkan respons
                        $('#uploadMessage').html(response);

                        // Tampilkan modal status
                        $('#uploadModalStatus').modal('show');

                        loadTableData();
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });

        function loadTableData() {
            $.ajax({
                url: 'data_prodi.php', // Endpoint untuk mengambil data tabel
                type: 'GET',
                success: function (data) {
                    // Perbarui isi tabel dengan data yang diterima
                    $('#table tbody').html(data);
                },
                error: function (xhr, status, error) {
                    console.error('Error loading table data:', error);
                }
            });
        }

        function setUploadDir(directory) {
            $('#uploadDir').val(directory);
        }

        function updateFileName() {
            var fileName = document.getElementById('file').files[0]?.name || "No file chosen";
            document.getElementById('fileName').value = fileName;
        }


        document.addEventListener("DOMContentLoaded", function () {
            // Menangani perubahan input file
            const fileInput = document.getElementById("file");
            const fileNameInput = document.getElementById("fileName");

            fileInput.addEventListener("change", function () {
                const fileName = fileInput.files.length > 0 ? fileInput.files[0].name : "No file chosen";
                fileNameInput.value = fileName;
            });
        });


        // Keterangan pada verifikasi

        document.addEventListener('DOMContentLoaded', () => {
            const verifikasiTrue = document.getElementById('verifikasiTrue');
            const verifikasiFalse = document.getElementById('verifikasiFalse');
            const keterangan = document.getElementById('keterangan');
            const keteranganError = document.getElementById('keteranganError');
            const saveButton = document.getElementById('saveVerification');

            // Event listener untuk radio buttons
            [verifikasiTrue, verifikasiFalse].forEach(radio => {
                radio.addEventListener('change', () => {
                    if (verifikasiTrue.checked) {
                        keterangan.disabled = true;
                        keterangan.value = ""; // Clear the textarea
                        keteranganError.style.display = "none";
                    } else if (verifikasiFalse.checked) {
                        keterangan.disabled = false;
                    }
                });
            });

            // Validasi sebelum menyimpan
            saveButton.addEventListener('click', () => {
                if (verifikasiFalse.checked && keterangan.value.trim() === "") {
                    keteranganError.style.display = "block";
                    keterangan.focus();
                } else {
                    keteranganError.style.display = "none";
                    // Lakukan tindakan simpan (AJAX atau proses lainnya)
                    alert('Data berhasil disimpan!');
                    $('#uploadModal').modal('hide');
                }
            });
        });

    </script>

</body>

</html>