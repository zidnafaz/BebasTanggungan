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

$query = "SELECT 
            p.status_pengumpulan_penyerahan_hardcopy AS penyerahan_hardcopy,
            t.status_pengumpulan_tugas_akhir_softcopy AS tugas_akhir_softcopy,
            b.status_pengumpulan_bebas_pinjam_buku_perpustakaan AS bebas_pinjam_buku_perpustakaan,
            k.status_pengumpulan_hasil_kuisioner AS hasil_kuisioner,
            d.status_pengumpulan_data_alumni AS data_alumni,
            s.status_pengumpulan_skkm AS skkm,
            f.status_pengumpulan_foto_ijazah AS foto_ijazah,
            u.status_pengumpulan_ukt AS ukt,
            ps.status_pengumpulan_penyerahan_skripsi AS penyerahan_skripsi,
            pk.status_pengumpulan_penyerahan_pkl AS penyerahan_pkl,
            toec.status_pengumpulan_toeic AS toeic,
            bk.status_pengumpulan_bebas_kompen AS bebas_kompen,
            pkd.status_pengumpulan_penyerahan_kebenaran_data AS penyerahan_kebenaran_data,
            pj.status_pengumpulan_publikasi_jurnal AS publikasi_jurnal,
            a.status_pengumpulan_aplikasi AS aplikasi,
            sk.status_pengumpulan_skripsi AS skripsi
        FROM mahasiswa m
        LEFT JOIN penyerahan_hardcopy p ON m.nim = p.nim
        LEFT JOIN tugas_akhir_softcopy t ON m.nim = t.nim
        LEFT JOIN bebas_pinjam_buku_perpustakaan b ON m.nim = b.nim
        LEFT JOIN hasil_kuisioner k ON m.nim = k.nim
        LEFT JOIN data_alumni d ON m.nim = d.nim
        LEFT JOIN skkm s ON m.nim = s.nim
        LEFT JOIN foto_ijazah f ON m.nim = f.nim
        LEFT JOIN ukt u ON m.nim = u.nim
        LEFT JOIN penyerahan_skripsi ps ON m.nim = ps.nim
        LEFT JOIN penyerahan_pkl pk ON m.nim = pk.nim
        LEFT JOIN toeic toec ON m.nim = toec.nim
        LEFT JOIN bebas_kompen bk ON m.nim = bk.nim
        LEFT JOIN penyerahan_kebenaran_data pkd ON m.nim = pkd.nim
        LEFT JOIN publikasi_jurnal pj ON m.nim = pj.nim
        LEFT JOIN aplikasi a ON m.nim = a.nim
        LEFT JOIN skripsi sk ON m.nim = sk.nim
        WHERE m.nim = ?
        ORDER BY 
        CASE 
            WHEN p.status_pengumpulan_penyerahan_hardcopy = 'pending' THEN 1
            WHEN p.status_pengumpulan_penyerahan_hardcopy = 'ditolak' THEN 2
            WHEN p.status_pengumpulan_penyerahan_hardcopy = 'belum upload' THEN 3
            WHEN p.status_pengumpulan_penyerahan_hardcopy = 'terverifikasi' THEN 4
            ELSE 5
        END,
        CASE 
            WHEN t.status_pengumpulan_tugas_akhir_softcopy = 'pending' THEN 1
            WHEN t.status_pengumpulan_tugas_akhir_softcopy = 'ditolak' THEN 2
            WHEN t.status_pengumpulan_tugas_akhir_softcopy = 'belum upload' THEN 3
            WHEN t.status_pengumpulan_tugas_akhir_softcopy = 'terverifikasi' THEN 4
            ELSE 5
        END,
        CASE 
            WHEN b.status_pengumpulan_bebas_pinjam_buku_perpustakaan = 'pending' THEN 1
            WHEN b.status_pengumpulan_bebas_pinjam_buku_perpustakaan = 'ditolak' THEN 2
            WHEN b.status_pengumpulan_bebas_pinjam_buku_perpustakaan = 'belum upload' THEN 3
            WHEN b.status_pengumpulan_bebas_pinjam_buku_perpustakaan = 'terverifikasi' THEN 4
            ELSE 5
        END,
        CASE 
            WHEN k.status_pengumpulan_hasil_kuisioner = 'pending' THEN 1
            WHEN k.status_pengumpulan_hasil_kuisioner = 'ditolak' THEN 2
            WHEN k.status_pengumpulan_hasil_kuisioner = 'belum upload' THEN 3
            WHEN k.status_pengumpulan_hasil_kuisioner = 'terverifikasi' THEN 4
            ELSE 5
        END,
        CASE 
            WHEN d.status_pengumpulan_data_alumni = 'pending' THEN 1
            WHEN d.status_pengumpulan_data_alumni = 'ditolak' THEN 2
            WHEN d.status_pengumpulan_data_alumni = 'belum upload' THEN 3
            WHEN d.status_pengumpulan_data_alumni = 'terverifikasi' THEN 4
            ELSE 5
        END,
        CASE 
            WHEN s.status_pengumpulan_skkm = 'pending' THEN 1
            WHEN s.status_pengumpulan_skkm = 'ditolak' THEN 2
            WHEN s.status_pengumpulan_skkm = 'belum upload' THEN 3
            WHEN s.status_pengumpulan_skkm = 'terverifikasi' THEN 4
            ELSE 5
        END,
        CASE 
            WHEN f.status_pengumpulan_foto_ijazah = 'pending' THEN 1
            WHEN f.status_pengumpulan_foto_ijazah = 'ditolak' THEN 2
            WHEN f.status_pengumpulan_foto_ijazah = 'belum upload' THEN 3
            WHEN f.status_pengumpulan_foto_ijazah = 'terverifikasi' THEN 4
            ELSE 5
        END,
        CASE 
            WHEN u.status_pengumpulan_ukt = 'pending' THEN 1
            WHEN u.status_pengumpulan_ukt = 'ditolak' THEN 2
            WHEN u.status_pengumpulan_ukt = 'belum upload' THEN 3
            WHEN u.status_pengumpulan_ukt = 'terverifikasi' THEN 4
            ELSE 5
        END,
        CASE 
            WHEN ps.status_pengumpulan_penyerahan_skripsi = 'pending' THEN 1
            WHEN ps.status_pengumpulan_penyerahan_skripsi = 'ditolak' THEN 2
            WHEN ps.status_pengumpulan_penyerahan_skripsi = 'belum upload' THEN 3
            WHEN ps.status_pengumpulan_penyerahan_skripsi = 'terverifikasi' THEN 4
            ELSE 5
        END,
        CASE 
            WHEN pk.status_pengumpulan_penyerahan_pkl = 'pending' THEN 1
            WHEN pk.status_pengumpulan_penyerahan_pkl = 'ditolak' THEN 2
            WHEN pk.status_pengumpulan_penyerahan_pkl = 'belum upload' THEN 3
            WHEN pk.status_pengumpulan_penyerahan_pkl = 'terverifikasi' THEN 4
            ELSE 5
        END,
        CASE 
            WHEN toec.status_pengumpulan_toeic = 'pending' THEN 1
            WHEN toec.status_pengumpulan_toeic = 'ditolak' THEN 2
            WHEN toec.status_pengumpulan_toeic = 'belum upload' THEN 3
            WHEN toec.status_pengumpulan_toeic = 'terverifikasi' THEN 4
            ELSE 5
        END,
        CASE 
            WHEN bk.status_pengumpulan_bebas_kompen = 'pending' THEN 1
            WHEN bk.status_pengumpulan_bebas_kompen = 'ditolak' THEN 2
            WHEN bk.status_pengumpulan_bebas_kompen = 'belum upload' THEN 3
            WHEN bk.status_pengumpulan_bebas_kompen = 'terverifikasi' THEN 4
            ELSE 5
        END,
        CASE 
            WHEN pkd.status_pengumpulan_penyerahan_kebenaran_data = 'pending' THEN 1
            WHEN pkd.status_pengumpulan_penyerahan_kebenaran_data = 'ditolak' THEN 2
            WHEN pkd.status_pengumpulan_penyerahan_kebenaran_data = 'belum upload' THEN 3
            WHEN pkd.status_pengumpulan_penyerahan_kebenaran_data = 'terverifikasi' THEN 4
            ELSE 5
        END,
        CASE 
            WHEN pj.status_pengumpulan_publikasi_jurnal = 'pending' THEN 1
            WHEN pj.status_pengumpulan_publikasi_jurnal = 'ditolak' THEN 2
            WHEN pj.status_pengumpulan_publikasi_jurnal = 'belum upload' THEN 3
            WHEN pj.status_pengumpulan_publikasi_jurnal = 'terverifikasi' THEN 4
            ELSE 5
        END,
        CASE 
            WHEN a.status_pengumpulan_aplikasi = 'pending' THEN 1
            WHEN a.status_pengumpulan_aplikasi = 'ditolak' THEN 2
            WHEN a.status_pengumpulan_aplikasi = 'belum upload' THEN 3
            WHEN a.status_pengumpulan_aplikasi = 'terverifikasi' THEN 4
            ELSE 5
        END,
        CASE 
            WHEN sk.status_pengumpulan_skripsi = 'pending' THEN 1
            WHEN sk.status_pengumpulan_skripsi = 'ditolak' THEN 2
            WHEN sk.status_pengumpulan_skripsi = 'belum upload' THEN 3
            WHEN sk.status_pengumpulan_skripsi = 'terverifikasi' THEN 4
            ELSE 5
        END
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

// Cek apakah semua status adalah 'terverifikasi'
$allConfirmed =
    $row['penyerahan_hardcopy'] === 'terverifikasi' &&
    $row['tugas_akhir_softcopy'] === 'terverifikasi' &&
    $row['bebas_pinjam_buku_perpustakaan'] === 'terverifikasi' &&
    $row['hasil_kuisioner'] === 'terverifikasi' &&
    $row['data_alumni'] === 'terverifikasi' &&
    $row['skkm'] === 'terverifikasi' &&
    $row['foto_ijazah'] === 'terverifikasi' &&
    $row['ukt'] === 'terverifikasi' &&
    $row['penyerahan_skripsi'] === 'terverifikasi' &&
    $row['penyerahan_pkl'] === 'terverifikasi' &&
    $row['toeic'] === 'terverifikasi' &&
    $row['bebas_kompen'] === 'terverifikasi' &&
    $row['penyerahan_kebenaran_data'] === 'terverifikasi' &&
    $row['publikasi_jurnal'] === 'terverifikasi' &&
    $row['aplikasi'] === 'terverifikasi' &&
    $row['skripsi'] === 'terverifikasi';

// Data untuk tabel
$data = [
    ["nama_tabel" => "Penyerahan Hardcopy", "status" => $row['penyerahan_hardcopy'], "tempat" => "Perpustakaan", "link" => "grapol.php"],
    ["nama_tabel" => "Tugas Akhir Softcopy", "status" => $row['tugas_akhir_softcopy'], "tempat" => "Perpustakaan", "link" => "grapol.php"],
    ["nama_tabel" => "Bebas Pinjam Buku", "status" => $row['bebas_pinjam_buku_perpustakaan'], "tempat" => "Perpustakaan", "link" => "grapol.php"],
    ["nama_tabel" => "Hasil Kuisioner", "status" => $row['hasil_kuisioner'], "tempat" => "Perpustakaan", "link" => "grapol.php"],
    ["nama_tabel" => "Data Alumni", "status" => $row['data_alumni'], "tempat" => "Akademik", "link" => "akademik.php"],
    ["nama_tabel" => "SKKM", "status" => $row['skkm'], "tempat" => "Akademik", "link" => "akademik.php"],
    ["nama_tabel" => "Foto Ijazah", "status" => $row['foto_ijazah'], "tempat" => "Akademik", "link" => "akademik.php"],
    ["nama_tabel" => "UKT", "status" => $row['ukt'], "tempat" => "Akademik", "link" => "akademik.php"],
    ["nama_tabel" => "Penyerahan Skripsi", "status" => $row['penyerahan_skripsi'], "tempat" => "Prodi", "link" => "prodi.php"],
    ["nama_tabel" => "Penyerahan PKL", "status" => $row['penyerahan_pkl'], "tempat" => "Prodi", "link" => "prodi.php"],
    ["nama_tabel" => "TOEIC", "status" => $row['toeic'], "tempat" => "Prodi", "link" => "prodi.php"],
    ["nama_tabel" => "Bebas Kompen", "status" => $row['bebas_kompen'], "tempat" => "Prodi", "link" => "prodi.php"],
    ["nama_tabel" => "Pernyataan Kebenaran Data", "status" => $row['penyerahan_kebenaran_data'], "tempat" => "Prodi", "link" => "prodi.php"],
    ["nama_tabel" => "Publikasi Jurnal", "status" => $row['publikasi_jurnal'], "tempat" => "Jurusan", "link" => "jurusan.php"],
    ["nama_tabel" => "Aplikasi", "status" => $row['aplikasi'], "tempat" => "Jurusan", "link" => "jurusan.php"],
    ["nama_tabel" => "Skripsi", "status" => $row['skripsi'], "tempat" => "Jurusan", "link" => "jurusan.php"]
];

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
        JOIN dbo.adminlt6_konfirmasi ap ON ns.nim = ap.nim
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
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 320px;
        }

        .card-body .btn {
            margin-top: auto;
            /* Memastikan tombol berada di bawah */
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

        .dataTables_filter {
            float: right;
            /* Menempatkan search box ke kanan */
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">
                            Dashboard Mahasiswa -
                            <span class="welcome-name">Selamat Datang
                                <?= htmlspecialchars($resultUser['nama_mahasiswa'] ?? '') ?></span>
                        </h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Donut Chart Section -->
                        <div class="col-xl-4 col-lg-4">
                            <div class="card shadow mb-4 ">
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
                            <div class="card shadow mb-4  ">
                                <!-- Card Header -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Rekomendasi Pengambilan Transkrip,
                                        Ijazah, dan SKPI</h6>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <p class="text-gray-600">Untuk mengambil Transkrip, Ijazah, dan SKPI, pastikan Anda
                                        sudah memenuhi seluruh persyaratan yang diperlukan. Jika sudah, silakan unduh
                                        Surat Rekomendasi Pengambilan Transkrip, Ijazah, dan SKPI di bawah ini.</p>

                                    <!-- Download Button -->
                                    <button class="btn btn-primary btn-block" id="downloadButton" disabled>
                                        <i class="fas fa-download"></i> Download
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Panduan Alur Bebas Tanggungan -->
                        <div class="col-xl-4 col-lg-4">
                            <div class="card shadow mb-4  ">
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

                        <!-- Status Pengumpulan Section -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Status Pengumpulan</h6>
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

                                    <div class="table-responsive">
                                        <table id="statusPengumpulanTable" class="table table-bordered table-striped"
                                            width="100%" cellspacing="0">
                                            <thead class="thead-primary">
                                                <tr>
                                                    <th>Nama Berkas</th>
                                                    <th>Tempat Pengumpulan</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data as $item): ?>
                                                    <?php
                                                    $status = strtolower($item['status']);
                                                    $statusClass = match ($status) {
                                                        'belum upload' => 'bg-secondary text-white',
                                                        'pending' => 'bg-warning text-dark',
                                                        'ditolak' => 'bg-danger text-white',
                                                        'terverifikasi' => 'bg-success text-white',
                                                        default => 'bg-light text-dark'
                                                    };
                                                    ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($item['nama_tabel']) ?></td>
                                                        <td><?= htmlspecialchars($item['tempat']) ?></td>
                                                        <td>
                                                            <span
                                                                class="badge <?= $statusClass ?> p-2 rounded text-uppercase">
                                                                <?= htmlspecialchars($item['status']) ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="<?= htmlspecialchars($item['link']) ?>"
                                                                class="btn btn-primary btn-sm" target="_blank">
                                                                Lihat
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
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

    <!-- jQuery (dari CDN atau file lokal, pilih salah satu saja) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5 JS Bundle (termasuk Popper.js) -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery Easing Plugin -->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- sb-admin-2 Script -->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Bootstrap 5 JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Page level plugins -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        $(document).ready(function () {
            var table = $('#statusPengumpulanTable').DataTable({
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

            // Filter rows based on the status from the dropdown
            $('#statusFilter').on('change', function () {
                var status = $(this).val();
                table.column(2).search(status).draw(); // Kolom 3 adalah Status
            });
        });

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
                    downloadButton.innerHTML = '<i class="fas fa-download"></i> Download';
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