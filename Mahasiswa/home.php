<?php
include '../koneksi.php';
include '../data/dataMahasiswa.php';

if (!isset($_COOKIE['id'])) {
    header("Location: ../index.html");
    exit();
}

$nim = $_COOKIE['id'];

$query = "
        SELECT 
            -- PERPUSTAKAAN
            (CASE WHEN MIN(CASE WHEN status_pengumpulan_penyerahan_hardcopy = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS penyerahan_hardcopy,
            (CASE WHEN MIN(CASE WHEN status_pengumpulan_tugas_akhir_softcopy = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS tugas_akhir_softcopy,
            (CASE WHEN MIN(CASE WHEN status_pengumpulan_bebas_pinjam_buku_perpustakaan = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS bebas_pinjam_buku_perpustakaan,
            (CASE WHEN MIN(CASE WHEN status_pengumpulan_hasil_kuisioner = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS hasil_kuisioner,

            -- BEBAS TANGGUNGAN AKADEMIK PUSAT
            (CASE WHEN MIN(CASE WHEN status_pengumpulan_data_alumni = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS data_alumni,
            (CASE WHEN MIN(CASE WHEN status_pengumpulan_skkm = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS skkm,
            (CASE WHEN MIN(CASE WHEN status_pengumpulan_foto_ijazah = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS foto_ijazah,
            (CASE WHEN MIN(CASE WHEN status_pengumpulan_ukt = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS ukt,

            -- ADMIN LANTAI 6 PRODI
            (CASE WHEN MIN(CASE WHEN status_pengumpulan_penyerahan_skripsi = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS penyerahan_skripsi,
            (CASE WHEN MIN(CASE WHEN status_pengumpulan_penyerahan_pkl = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS penyerahan_pkl,
            (CASE WHEN MIN(CASE WHEN status_pengumpulan_toeic = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS toeic,
            (CASE WHEN MIN(CASE WHEN status_pengumpulan_bebas_kompen = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS bebas_kompen,
            (CASE WHEN MIN(CASE WHEN status_pengumpulan_penyerahan_kebenaran_data = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS penyerahan_kebenaran_data,

            -- ADMIN LANTAI 7 JURUSAN
            (CASE WHEN MIN(CASE WHEN status_pengumpulan_publikasi_jurnal = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS publikasi_jurnal,
            (CASE WHEN MIN(CASE WHEN status_pengumpulan_aplikasi = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS aplikasi,
            (CASE WHEN MIN(CASE WHEN status_pengumpulan_skripsi = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS skripsi
        FROM dbo.penyerahan_hardcopy
        LEFT JOIN dbo.tugas_akhir_softcopy ON penyerahan_hardcopy.nim = tugas_akhir_softcopy.nim
        LEFT JOIN dbo.bebas_pinjam_buku_perpustakaan ON penyerahan_hardcopy.nim = bebas_pinjam_buku_perpustakaan.nim
        LEFT JOIN dbo.hasil_kuisioner ON penyerahan_hardcopy.nim = hasil_kuisioner.nim
        LEFT JOIN dbo.data_alumni ON penyerahan_hardcopy.nim = data_alumni.nim
        LEFT JOIN dbo.skkm ON penyerahan_hardcopy.nim = skkm.nim
        LEFT JOIN dbo.foto_ijazah ON penyerahan_hardcopy.nim = foto_ijazah.nim
        LEFT JOIN dbo.ukt ON penyerahan_hardcopy.nim = ukt.nim
        LEFT JOIN dbo.penyerahan_skripsi ON penyerahan_hardcopy.nim = penyerahan_skripsi.nim
        LEFT JOIN dbo.penyerahan_pkl ON penyerahan_hardcopy.nim = penyerahan_pkl.nim
        LEFT JOIN dbo.toeic ON penyerahan_hardcopy.nim = toeic.nim
        LEFT JOIN dbo.bebas_kompen ON penyerahan_hardcopy.nim = bebas_kompen.nim
        LEFT JOIN dbo.penyerahan_kebenaran_data ON penyerahan_hardcopy.nim = penyerahan_kebenaran_data.nim
        LEFT JOIN dbo.publikasi_jurnal ON penyerahan_hardcopy.nim = publikasi_jurnal.nim
        LEFT JOIN dbo.aplikasi ON penyerahan_hardcopy.nim = aplikasi.nim
        LEFT JOIN dbo.skripsi ON penyerahan_hardcopy.nim = skripsi.nim
        WHERE penyerahan_hardcopy.nim = ?
        ";

$params = array($nim);
$stmt = sqlsrv_prepare($conn, $query, $params);
if (!$stmt) {
    die(print_r(sqlsrv_errors(), true));
}

$result = sqlsrv_execute($stmt);
if (!$result) {
    die(print_r(sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
if ($row === false) {
    die("Gagal mengambil data");
}

// Mengecek apakah semua status sudah "terverifikasi"
$allConfirmed =
    $row['penyerahan_hardcopy'] &&
    $row['tugas_akhir_softcopy'] &&
    $row['bebas_pinjam_buku_perpustakaan'] &&
    $row['hasil_kuisioner'] &&
    $row['data_alumni'] &&
    $row['skkm'] &&
    $row['foto_ijazah'] &&
    $row['ukt'] &&
    $row['penyerahan_skripsi'] &&
    $row['penyerahan_pkl'] &&
    $row['toeic'] &&
    $row['bebas_kompen'] &&
    $row['penyerahan_kebenaran_data'] &&
    $row['publikasi_jurnal'] &&
    $row['aplikasi'] &&
    $row['skripsi'];

sqlsrv_free_stmt($stmt);

// Cek apakah nomor surat sudah ada
$cekSurat = "SELECT * FROM dbo.nomor_surat_rekomendasi WHERE nim = ?";
$paramsCek = array($nim);
$resultCek = sqlsrv_query($conn, $cekSurat, $paramsCek);

if ($resultCek === false) {
    die("Gagal menjalankan query");
}

if ($rowCek = sqlsrv_fetch_array($resultCek, SQLSRV_FETCH_ASSOC)) {
    $nomor_surat = $rowCek['nomor_surat'];
} else {
    if ($allConfirmed) {

        $queryUrut = "SELECT MAX(CAST(LEFT(nomor_surat, CHARINDEX('/', nomor_surat) - 1) AS INT)) AS last_number FROM dbo.nomor_surat_rekomendasi";
        $resultUrut = sqlsrv_query($conn, $queryUrut);

        if ($resultUrut === false) {
            die("Gagal mengambil nomor urut terakhir: " . print_r(sqlsrv_errors(), true));
        }

        $rowUrut = sqlsrv_fetch_array($resultUrut, SQLSRV_FETCH_ASSOC);
        $lastNumber = $rowUrut['last_number'] ?? 1000;

        // Buat nomor surat baru
        $newNumber = $lastNumber + 1;
        $tahun = date("Y");
        $nomor_surat = sprintf("%04d/PL.T2.TI/%s", $newNumber, $tahun);

        // Masukkan ke tabel nomor_surat
        $insertSurat = "INSERT INTO dbo.nomor_surat_rekomendasi (nim, nomor_surat) 
                        VALUES (?, ?)";
        $paramsInsert = array($nim, $nomor_surat);
        $stmtInsert = sqlsrv_query($conn, $insertSurat, $paramsInsert);

        if ($stmtInsert === false) {
            die("Gagal menyimpan nomor surat: " . print_r(sqlsrv_errors(), true));
        }
    } else {
        $nomor_surat = "Belum memenuhi syarat";
    }
}

// Menampilkan data mahasiswa dan nomor surat
$sql = "SELECT m.nim, m.nama_mahasiswa, m.jurusan_mahasiswa, m.prodi_mahasiswa, m.tahun_lulus_mahasiswa, ns.nomor_surat, ap.tanggal_adminlt6_konfirmasi
        FROM dbo.mahasiswa m
        JOIN dbo.nomor_surat_rekomendasi ns ON m.nim = ns.nim
        JOIN dbo.adminlt6_konfirmasi ap ON m.nim = ns.nim
        WHERE m.nim = ?";

$params = array($nim);
$result = sqlsrv_query($conn, $sql, $params);

if ($result === false) {
    die("Kesalahan saat menjalankan query: " . print_r(sqlsrv_errors(), true));
}

// Ambil data
if ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $nama_mahasiswa = $row['nama_mahasiswa'];
    $nim = $row['nim'];
    $jurusan = $row['jurusan_mahasiswa'];
    $prodi = $row['prodi_mahasiswa'];
    $nomor_surat = $row['nomor_surat'];
    $tahunLulus = $row['tahun_lulus_mahasiswa']->format('Y');
    $tanggalTerbit = $row['tanggal_adminlt6_konfirmasi']->format('d-m-Y');
}

// Tutup koneksi
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script type="module">
        import {
            PDFDocument,
            rgb
        } from 'https://cdn.jsdelivr.net/npm/pdf-lib@1.17.1/+esm';

        document.addEventListener('DOMContentLoaded', () => {
            const button = document.getElementById('downloadButton');

            button.addEventListener('click', async () => {

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

                const username = getCookie('id');
                const pdfPath = '../Documents/downloads/generate/Rekomendasi_Pengambilan_Ijazah.pdf';
                const fontPath = './TimesNewRoman/TimesNewRoman.ttf';

                // Muat PDF
                const pdfResponse = await fetch(pdfPath);
                if (!pdfResponse.ok) throw new Error(`Could not load PDF: ${pdfResponse.statusText}`);
                const pdfArrayBuffer = await pdfResponse.arrayBuffer();
                const pdfDoc = await PDFDocument.load(pdfArrayBuffer);

                // Registrasikan fontkit
                pdfDoc.registerFontkit(window.fontkit);

                // Muat font kustom
                const fontResponse = await fetch(fontPath);
                if (!fontResponse.ok) throw new Error(`Could not load font: ${fontResponse.statusText}`);
                const fontArrayBuffer = await fontResponse.arrayBuffer();
                const timesFont = await pdfDoc.embedFont(fontArrayBuffer);

                // Tambahkan teks ke halaman pertama
                const pages = pdfDoc.getPages();
                const firstPage = pages[0];
                const nama = "<?php echo htmlspecialchars($nama_mahasiswa, ENT_QUOTES, 'UTF-8'); ?>";
                const nim = "<?php echo htmlspecialchars($nim, ENT_QUOTES, 'UTF-8'); ?>";
                const jurusan = "<?php echo htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8'); ?>";
                const prodi = "<?php echo htmlspecialchars($prodi, ENT_QUOTES, 'UTF-8'); ?>";
                const nomor_surat = "<?php echo htmlspecialchars($nomor_surat, ENT_QUOTES, 'UTF-8'); ?>";
                const tahunLulus = "<?php echo htmlspecialchars($tahunLulus, ENT_QUOTES, 'UTF-8'); ?>";
                const tanggalTerbit = "<?php echo htmlspecialchars($tanggalTerbit, ENT_QUOTES, 'UTF-8'); ?>";

                // Tentukan posisi teks untuk setiap field
                firstPage.drawText(`${nama}`, {
                    x: 190, // Ganti dengan koordinat X yang sesuai
                    y: 468, // Ganti dengan koordinat Y yang sesuai
                    size: 12,
                    font: timesFont,
                    color: rgb(0, 0, 0),
                });

                firstPage.drawText(`${nim}`, {
                    x: 190, // Ganti dengan koordinat X yang sesuai
                    y: 446, // Ganti dengan koordinat Y yang sesuai
                    size: 12,
                    font: timesFont,
                    color: rgb(0, 0, 0),
                });

                firstPage.drawText(`${tahunLulus}`, {
                    x: 190, // Ganti dengan koordinat X yang sesuai
                    y: 425.3, // Ganti dengan koordinat Y yang sesuai
                    size: 12,
                    font: timesFont,
                    color: rgb(0, 0, 0),
                });

                firstPage.drawText(`${prodi}`, {
                    x: 190, // Ganti dengan koordinat X yang sesuai
                    y: 404, // Ganti dengan koordinat Y yang sesuai
                    size: 12,
                    font: timesFont,
                    color: rgb(0, 0, 0),
                });

                firstPage.drawText(`${jurusan}`, {
                    x: 190, // Ganti dengan koordinat X yang sesuai
                    y: 382, // Ganti dengan koordinat Y yang sesuai
                    size: 12,
                    font: timesFont,
                    color: rgb(0, 0, 0),
                });

                firstPage.drawText(`${nomor_surat}`, {
                    x: 260, // Ganti dengan koordinat X yang sesuai
                    y: 622.5, // Ganti dengan koordinat Y yang sesuai
                    size: 12,
                    font: timesFont,
                    color: rgb(0, 0, 0),
                });

                firstPage.drawText(`${tanggalTerbit}`, {
                    x: 333, // Ganti dengan koordinat X yang sesuai
                    y: 235, // Ganti dengan koordinat Y yang sesuai
                    size: 12,
                    font: timesFont,
                    color: rgb(0, 0, 0),
                });

                // Simpan PDF baru
                const modifiedPdf = await pdfDoc.save();
                const blob = new Blob([modifiedPdf], {
                    type: 'application/pdf'
                });

                // Unduh PDF yang sudah diedit
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `${nim}_Rekomendasi_Pengambilan_Ijazah.pdf`;
                link.click();
            });
        });


    </script>

    <script src="https://cdn.jsdelivr.net/npm/@pdf-lib/fontkit@0.0.4/dist/fontkit.umd.min.js"></script>

    <style>
        .chart-pie {
            position: relative;
            height: 250px;
            width: 100%;
        }

        .card-body {
            padding: 1.25rem;
        }

        .card-header {
            background-color: #f8f9fc;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .container-fluid {
            padding: 15px;
        }

        .btn[disabled] {
            pointer-events: none;
            background-color: #858796 !important;
            color: #fff !important;
            cursor: not-allowed;
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
            <li class="nav-item" id="nav-tugasAkhir">
                <a class="nav-link" href="jurusan.php">
                    <i class="fas fa-solid fa-book"></i>
                    <span>Jurusan</span></a>
            </li>

            <li class="nav-item" id="nav-jurusan">
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
                                    <?php echo htmlspecialchars($resultUser['nama_mahasiswa'] ?? '') ?>
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
                        <h1 class="h3 mb-0 text-gray-800">
                            Dashboard Mahasiswa -
                            <span
                                class="welcome-name">Selamat Datang <?= htmlspecialchars($resultUser['nama_mahasiswa'] ?? '') ?></span>
                        </h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Donut Chart Section -->
                        <div class="col-xl-4 col-lg-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Title -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Status Bebas Tanggungan</h6>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-1">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info and Download Section -->
                        <div class="col-xl-4 col-lg-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Rekomendasi Pengambilan Transkrip,
                                        Ijazah, dan SKPI</h6>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <p class="text-gray-600">Untuk mengambil Transkrip, Ijazah, dan SKPI, pastikan Anda
                                        sudah memenuhi
                                        seluruh persyaratan yang diperlukan. Jika sudah,
                                        silakan unduh Surat Rekomendasi Pengambilan Transkrip, Ijazah, dan SKPI di bawah
                                        ini.</p>

                                    <!-- Download Button -->
                                    <button class="btn btn-success btn-block" id="downloadButton" disabled>
                                        <i class="fas fa-download"></i> Download
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Panduan Alur Bebas Tanggungan -->
                        <div class="col-xl-4 col-lg-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Panduan Alur Bebas Tanggungan</h6>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <p class="text-gray-600">Panduan alur bebas tanggungan ini akan membantu Anda
                                        memahami proses yang harus dilalui untuk menyelesaikan kewajiban administrasi.
                                        Pastikan Anda membaca dan mengikuti langkah-langkah yang tersedia.</p>

                                    <!-- Download Button -->
                                    <a href="../Documents/downloads/template/[Panduan] Alur Bebas Tanggungan Jurusan_SIB.docx"
                                        class="btn btn-success btn-block" download>
                                        <i class="fas fa-download"></i> Download Panduan
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- End Content Row -->

                </div>
                <!-- End Page Content -->

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        fetch('get_persentase.php')
            .then(response => response.json())
            .then(data => {
                // Data and labels for the chart
                const labels = ['Terverifikasi', 'Belum Upload', 'Pending', 'Ditolak'];
                const values = [
                    data.terverifikasi,
                    data.belum_upload,
                    data.pending,
                    data.ditolak
                ];

                // Chart data structure
                const chartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Status Bebas Tanggungan',
                        data: values,
                        backgroundColor: [
                            '#1cc88a', // Terkonfirmasi
                            '#858796', // Belum Upload
                            '#f6c23e', // Pending
                            '#e74a3b'  // Tidak Terkonfirmasi
                        ],
                        borderWidth: 1
                    }]
                };

                // Chart configuration
                const config = {
                    type: 'doughnut',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    boxWidth: 10, // Lebar kotak warna
                                    boxHeight: 10, // Tinggi kotak warna
                                    font: {
                                        size: 14,
                                        weight: 'normal'
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        return tooltipItem.raw + ' items'; // Format tooltip
                                    }
                                }
                            },
                            datalabels: {
                                display: true,
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 16
                                },
                                formatter: (value, context) => {
                                    return context.chart.data.labels[context.dataIndex] + ' : ' + value;
                                }
                            }
                        },
                        cutoutPercentage: 50, // Ukuran potongan tengah donut chart
                        rotation: Math.PI, // Memutar chart untuk menyesuaikan posisi awal
                    }
                };

                // Render the chart
                const ctx = document.getElementById('myChart').getContext('2d');
                new Chart(ctx, config);

                const downloadButton = document.getElementById('downloadButton');

                // Update logic to check if all statuses are confirmed
                if (data.belum_upload > 0 || data.pending > 0 || data.ditolak > 0) {
                    downloadButton.disabled = true;
                    downloadButton.classList.add('btn-secondary');
                    downloadButton.classList.remove('btn-success');
                    downloadButton.innerHTML = '<i class="fas fa-download"></i> Disabled';
                } else {
                    downloadButton.disabled = false;
                    downloadButton.classList.add('btn-success');
                    downloadButton.classList.remove('btn-secondary');
                }

            })
            .catch(error => console.error('Error loading data:', error));

    </script>

</body>

</html>