<?php
session_start();
require_once '../Koneksi.php';
require_once '../OOP/Mahasiswa.php';

$db = new Koneksi();
$conn = $db->connect();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.html");
    exit();
}

$nim = $_SESSION['id'];

$mahasiswa = new Mahasiswa();
$resultUser = $mahasiswa->getMahasiswaByNIM($nim);

$query = "
    SELECT 
        (CASE WHEN MIN(CASE WHEN status_pengumpulan_data_alumni = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS data_alumni,
        (CASE WHEN MIN(CASE WHEN status_pengumpulan_skkm = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS skkm,
        (CASE WHEN MIN(CASE WHEN status_pengumpulan_foto_ijazah = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS foto_ijazah,
        (CASE WHEN MIN(CASE WHEN status_pengumpulan_ukt = 'terverifikasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS ukt
    FROM dbo.data_alumni
    LEFT JOIN dbo.skkm ON data_alumni.nim = skkm.nim
    LEFT JOIN dbo.foto_ijazah ON data_alumni.nim = foto_ijazah.nim
    LEFT JOIN dbo.ukt ON data_alumni.nim = ukt.nim
    WHERE data_alumni.nim = ?
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

$allConfirmed = $row['data_alumni'] && $row['skkm'] && $row['foto_ijazah'] && $row['ukt'];
// Pastikan untuk memanggil fungsi sqlsrv_free_stmt langsung
sqlsrv_free_stmt($stmt);

// Cek apakah nomor surat sudah ada
$cekSurat = "SELECT * FROM dbo.nomor_surat_akademik_pusat WHERE nim = ?";
$paramsCek = array($nim);
$resultCek = sqlsrv_query($conn, $cekSurat, $paramsCek);

if ($resultCek === false) {
    die("Gagal menjalankan query");
}

if ($rowCek = sqlsrv_fetch_array($resultCek, SQLSRV_FETCH_ASSOC)) {
    // Nomor surat sudah ada, tidak perlu membuat lagi
    $nomor_surat = $rowCek['nomor_surat'];
} else {
    // Nomor surat belum ada, buat nomor surat baru jika semua terverifikasi
    if ($allConfirmed) {
        // Ambil nomor urut terakhir
        $queryUrut = "SELECT MAX(CAST(LEFT(nomor_surat, CHARINDEX('/', nomor_surat) - 1) AS INT)) AS last_number FROM dbo.nomor_surat_akademik_pusat";
        $resultUrut = sqlsrv_query($conn, $queryUrut);

        if ($resultUrut === false) {
            die("Gagal mengambil nomor urut terakhir: " . print_r(sqlsrv_errors(), true));
        }

        $rowUrut = sqlsrv_fetch_array($resultUrut, SQLSRV_FETCH_ASSOC);
        $lastNumber = $rowUrut['last_number'] ?? 1000;

        // Buat nomor surat baru
        $newNumber = $lastNumber + 1;
        $tahun = date("Y");
        $nomor_surat = sprintf("%04d/KSB.AK/BT/%s", $newNumber, $tahun);

        // Masukkan ke tabel nomor_surat
        $insertSurat = "INSERT INTO dbo.nomor_surat_akademik_pusat (nim, nomor_surat) 
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
$sql = "SELECT m.nim, m.nama_mahasiswa, m.jurusan_mahasiswa, m.prodi_mahasiswa, ns.nomor_surat, ap.tanggal_adminPusat_konfirmasi
        FROM dbo.mahasiswa m
        JOIN dbo.nomor_surat_akademik_pusat ns ON m.nim = ns.nim
        JOIN dbo.adminPusat_konfirmasi ap ON ns.nim = ap.nim
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
    $tanggalTerbit = $row['tanggal_adminPusat_konfirmasi']->format('d-m-Y');
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

    <script type="module">
        import {
            PDFDocument,
            rgb
        } from 'https://cdn.jsdelivr.net/npm/pdf-lib@1.17.1/+esm';

        document.addEventListener('DOMContentLoaded', () => {
            const button = document.getElementById('downloadButton');

            // Hanya jalankan jika tombol tidak memiliki atribut 'disabled'
            if (!button.hasAttribute('disabled')) {
                button.addEventListener('click', async () => {
                    try {
                        // Fungsi untuk mendapatkan cookie
                        function getCookie(name) {
                            const nameEQ = name + "=";
                            const cookies = document.cookie.split("; ");
                            for (let i = 0; i < cookies.length; i++) {
                                const c = cookies[i];
                                if (c.indexOf(nameEQ) === 0) {
                                    return c.substring(nameEQ.length, c.length);
                                }
                            }
                            return null;
                        }

                        const username = getCookie('id');
                        const pdfPath = '../Documents/downloads/generate/Bebas_Tanggungan_Akademik_Pusat.pdf';
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
                        const tanggal = "<?php echo htmlspecialchars($tanggalTerbit, ENT_QUOTES, 'UTF-8'); ?>";

                        firstPage.drawText(`${nama}`, {
                            x: 225,
                            y: 618.6,
                            size: 12,
                            font: timesFont,
                            color: rgb(0, 0, 0)
                        });
                        firstPage.drawText(`${nim}`, {
                            x: 225,
                            y: 602.6,
                            size: 12,
                            font: timesFont,
                            color: rgb(0, 0, 0)
                        });
                        firstPage.drawText(`${jurusan}`, {
                            x: 225,
                            y: 586.6,
                            size: 12,
                            font: timesFont,
                            color: rgb(0, 0, 0)
                        });
                        firstPage.drawText(`${prodi}`, {
                            x: 225,
                            y: 570.6,
                            size: 12,
                            font: timesFont,
                            color: rgb(0, 0, 0)
                        });
                        firstPage.drawText(`${nomor_surat}`, {
                            x: 265,
                            y: 666,
                            size: 12,
                            font: timesFont,
                            color: rgb(0, 0, 0)
                        });
                        firstPage.drawText(`${tanggal}`, {
                            x: 330,  // Ganti dengan koordinat X yang sesuai
                            y: 283,  // Ganti dengan koordinat Y yang sesuai
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
                        link.download = `${nim}_Bebas_Tanggungan_Akademik_Pusat.pdf`;
                        link.click();
                    } catch (error) {
                        console.error('Terjadi error:', error);
                    }
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@pdf-lib/fontkit@0.0.4/dist/fontkit.umd.min.js"></script>

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

            <li class="nav-item" id="nav-jurusan">
                <a class="nav-link" href="prodi.php">
                    <i class="fas fa-solid fa-file-lines"></i>
                    <span>Program Studi</span></a>
            </li>

            <li class="nav-item active" id="nav-akademik">
                <a class="nav-link" href="akademik.php">
                    <i class="fas fa-solid fa-file"></i>
                    <span>Akademik</span></a>
            </li>

            <li class="nav-item" id="nav-grapol">
                <a class="nav-link" href="grapol.php">
                    <i class="fas fa-solid fa-file-invoice"></i>
                    <span>Perpustakaan</span></a>
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
                    <h1 class="h3 mb-2 text-gray-800">Verifikasi Berkas Akademik Pusat</h1>
                    <p class="mb-4">Verifikasi berkas pada Akademik Pusat (Gedung AW) yang akan diverifikasi oleh ibu
                        Merry (<a target="_blank" href="https://wa.me/6282247723596">082247723596</a> - <i>Chat
                            Only</i>) </p>

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
                                            <td>Panduan Alur Bebas Tanggungan Akademik Pusat</td>
                                            <td>-</td>
                                            <td><a href="../Documents/downloads/template/[Panduan] Alur Bebas Tanggungan Akademik Pusat.pdf"
                                                    class="btn btn-success" download><i class="fas fa-download"></i>
                                                    Download</a></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Panduan Upload Foto Ijazah</td>
                                            <td>-</td>
                                            <td><a href="../Documents/downloads/template/[Panduan] Upload Foto Ijazah.pdf"
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
                            <h6 class="m-0 font-weight-bold text-primary">Bebas Tanggungan Akademik Pusat</h6>
                        </div>
                        <div class="card-body">
                            <p>Surat ini meliputi Bebas Tanggungan Akademik Pusat.</p>
                            <?php if ($allConfirmed): ?>
                                <button class="btn btn-success" id="downloadButton">
                                    <i class="fas fa-download"></i> Download
                                </button>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled><i class="fas fa-download"></i> Download</button>
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
                    <a class="btn btn-primary" href="../logout.php">Logout</a>
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
                            <small class="form-text text-muted">Accepted file type: pdf only (rar/zip for
                                aplikasi)</small>
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
                url: 'data_akademik.php', // File PHP untuk memuat data
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
                url: 'data_akademik.php', // Endpoint untuk mengambil data tabel
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