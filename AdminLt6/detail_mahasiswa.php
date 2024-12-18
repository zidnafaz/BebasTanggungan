<?php
session_start();
require_once '../Koneksi.php';
require_once '../OOP/Admin.php';
require_once '../OOP/Mahasiswa.php';

$db = new Koneksi();
$conn = $db->connect();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.html");
    exit();
}

$id = $_SESSION['id'];

$admin = new Admin();
$resultUser = $admin->getAdminById($id);

$nim = isset($_GET['nim']) ? $_GET['nim'] : null;

$mahasiswa = new Mahasiswa();
$resultUserMahasiswa = $mahasiswa->getMahasiswaByNIM($nim);

if (isset($_GET['message']) && isset($_GET['type'])) {
    $message = htmlspecialchars($_GET['message']);
    $messageType = htmlspecialchars($_GET['type']); // "success" atau "danger"
    echo "
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                $('#uploadModalStatus').modal('show');
                document.getElementById('uploadMessage').textContent = '$message';
                if ('$messageType' === 'success') {
                    document.getElementById('successIcon').style.display = 'block';
                    document.getElementById('errorIcon').style.display = 'none';
                } else {
                    document.getElementById('successIcon').style.display = 'none';
                    document.getElementById('errorIcon').style.display = 'block';
                }
            });
        </script>
    ";
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

    <title>Verifikasi <?php echo htmlspecialchars($resultUserMahasiswa['nama_mahasiswa'] ?? '') ?></title>

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
            <li class="nav-item" id="nav-upload_skripsi">
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
                    <!-- Identitas Mahasiswa -->
                    <h1 class="h3 mb-2 text-gray-800">Detail Mahasiswa</h1>
                    <p class="mb-4">Pastikan informasi sesuai dengan dokumen yang telah dikumpulkan.</p>

                    <!-- Identitas Mahasiswa -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Identitas Mahasiswa</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label><strong>Nama :</strong></label>
                                    <input type="text" class="form-control"
                                        value="<?= htmlspecialchars($resultUserMahasiswa['nama_mahasiswa']) ?>"
                                        readonly>
                                </div>
                                <div class="col-md-6">
                                    <label><strong>NIM :</strong></label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($nim) ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label><strong>Jurusan :</strong></label>
                                    <input type="text" id="jurusan" class="form-control"
                                        value="<?= htmlspecialchars($resultUserMahasiswa['jurusan_mahasiswa']) ?>"
                                        readonly>
                                </div>
                                <div class="col-md-6">
                                    <label><strong>Prodi :</strong></label>
                                    <input type="text" id="prodi" class="form-control"
                                        value="<?= htmlspecialchars($resultUserMahasiswa['prodi_mahasiswa']) ?>"
                                        readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Berkas Mahasiswa -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Berkas Mahasiswa</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama Berkas</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Query untuk mengambil data berkas mahasiswa
                                        $sqlFiles = "
                                                    SELECT 'Penyerahan Laporan Skripsi' AS nama_berkas, 
                                                        status_pengumpulan_penyerahan_skripsi AS status, 
                                                        keterangan_pengumpulan_penyerahan_skripsi AS keterangan, 
                                                        'penyerahan_skripsi' AS jenis_berkas
                                                    FROM penyerahan_skripsi WHERE nim = ?
                                                    UNION ALL
                                                    SELECT 'Penyerahan Laporan PKL' AS nama_berkas, 
                                                        status_pengumpulan_penyerahan_pkl AS status, 
                                                        keterangan_pengumpulan_penyerahan_pkl AS keterangan, 
                                                        'penyerahan_pkl' AS jenis_berkas
                                                    FROM penyerahan_pkl WHERE nim = ?
                                                    UNION ALL
                                                    SELECT 'TOEIC' AS nama_berkas, 
                                                        status_pengumpulan_toeic AS status, 
                                                        keterangan_pengumpulan_toeic AS keterangan, 
                                                        'toeic' AS jenis_berkas
                                                    FROM toeic WHERE nim = ?
                                                    UNION ALL
                                                    SELECT 'Bebas Kompen' AS nama_berkas, 
                                                        status_pengumpulan_bebas_kompen AS status, 
                                                        keterangan_pengumpulan_bebas_kompen AS keterangan, 
                                                        'bebas_kompen' AS jenis_berkas
                                                    FROM bebas_kompen WHERE nim = ?
                                                    UNION ALL
                                                    SELECT 'Pernyataan Kebenaran Data' AS nama_berkas, 
                                                        status_pengumpulan_penyerahan_kebenaran_data AS status, 
                                                        keterangan_pengumpulan_penyerahan_kebenaran_data AS keterangan, 
                                                        'penyerahan_kebenaran_data' AS jenis_berkas
                                                    FROM penyerahan_kebenaran_data WHERE nim = ?";

                                        $stmtFiles = sqlsrv_prepare($conn, $sqlFiles, [$nim, $nim, $nim, $nim, $nim]);
                                        sqlsrv_execute($stmtFiles);

                                        while ($file = sqlsrv_fetch_array($stmtFiles, SQLSRV_FETCH_ASSOC)): 
                                            // Ambil status dari query
                                            $status = $file['status'] ?? '';
                                            $keterangan = $file['keterangan'] ?? '-';
                                            $jenis_berkas = $file['jenis_berkas'] ?? '-';
                                        
                                            // Tentukan kelas badge berdasarkan status
                                            $statusClass = match ($status) {
                                                '3' => 'bg-secondary text-white', // belum upload
                                                '1' => 'bg-warning text-dark',   // pending
                                                '2' => 'bg-danger text-white',   // ditolak
                                                '4' => 'bg-success text-white',  // terverifikasi
                                                default => 'bg-light text-dark'
                                            };
                                        
                                            // Tentukan ekstensi file berdasarkan jenis berkas
                                            $fileExtension = '';
                                            $fileDirectory = "../Documents/uploads/" . htmlspecialchars($jenis_berkas) . "/";
                                            $fileName = $nim . "_" . htmlspecialchars($jenis_berkas);
                                        
                                            if (file_exists($fileDirectory . $fileName . ".zip")) {
                                                $fileExtension = 'zip';
                                            } elseif (file_exists($fileDirectory . $fileName . ".rar")) {
                                                $fileExtension = 'rar';
                                            }
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($file['nama_berkas'] ?? '-') ?></td>
                                            <td class='status'>
                                                <span class='badge <?= $statusClass ?> p-2 rounded text-uppercase'
                                                    style='cursor: pointer;' 
                                                    title="<?= htmlspecialchars(match ($status) {
                                                        '3' => 'Belum Upload',
                                                        '1' => 'Pending',
                                                        '2' => 'Ditolak',
                                                        '4' => 'Terverifikasi',
                                                        default => 'Unknown'
                                                    }) ?>">
                                                    <?= htmlspecialchars(match ($status) {
                                                        '3' => 'Belum Upload',
                                                        '1' => 'Pending',
                                                        '2' => 'Ditolak',
                                                        '4' => 'Terverifikasi',
                                                        default => 'Unknown'
                                                    }) ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($keterangan) ?></td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#verifikasiModal"
                                                    data-nama="<?= htmlspecialchars($resultUserMahasiswa['nama_mahasiswa'] ?? '-') ?>"
                                                    data-nim="<?= htmlspecialchars($nim) ?>"
                                                    data-berkas="<?= htmlspecialchars($file['nama_berkas'] ?? '-') ?>"
                                                    data-file="<?= htmlspecialchars($fileDirectory . $fileName . '.' . $fileExtension) ?>"
                                                    data-jenis_berkas="<?= htmlspecialchars($jenis_berkas) ?>"
                                                    data-status_pengumpulan="<?= htmlspecialchars($status) ?>">
                                                    <i class="fa-solid fa-file-pen"></i> Verifikasi
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
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

    <!-- Modal untuk Verifikasi -->
    <div class="modal fade" id="verifikasiModal" tabindex="-1" role="dialog" aria-labelledby="verifikasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="verifikasiModalLabel">
                        <i class="fas fa-file-alt"></i> Verifikasi Berkas
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Informasi Data -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label><strong>Nama:</strong></label>
                                    <input type="text" id="nama" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label><strong>NIM:</strong></label>
                                    <input type="text" id="nim" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label><strong>Nama Berkas:</strong></label>
                                    <input type="text" id="namaBerkas" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tampilan PDF menggunakan iframe -->
                    <div class="embed-responsive embed-responsive-4by3 mb-4" id="pdfPreviewContainer">
                        <iframe id="pdfPreview" src="" width="100%" height="400px" style="display: none;">
                            PDF tidak dapat ditampilkan.
                        </iframe>
                    </div>

                    <!-- Tombol Download -->
                    <div class="text-center mb-3" id="downloadButtonContainer" style="display: none;">
                        <a id="downloadButton" href="#" download class="btn btn-success">
                            <i class="fas fa-download"></i> Download File Zip/Rar
                        </a>
                    </div>

                    <!-- Verifikasi -->
                    <div class="card">
                        <div class="card-body">
                            <h6><strong>Status Verifikasi:</strong></h6>
                            <form id="verifikasiForm" action="konfirmasi.php" method="POST">
                                <div class="form-group">
                                    <label>
                                        <input type="radio" id="terverifikasi" name="status_verifikasi" value="4">
                                        Terverifikasi
                                    </label>
                                    <label>
                                        <input type="radio" id="ditolak" name="status_verifikasi" value="2">
                                        Ditolak
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan (Berikan Keterangan Jika Tidak
                                        terverifikasi):</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                        disabled></textarea>
                                </div>
                                <input type="hidden" name="nim" id="formNim">
                                <input type="hidden" name="nama" id="formNama">
                                <input type="hidden" id="jenis_berkas" name="jenis_berkas">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                    <button type="submit" class="btn btn-primary" form="verifikasiForm" id="simpanVerifikasi">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Modal untuk Status -->
    <div class="modal fade" id="uploadModalStatus" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="uploadModalLabel">Status Update</h5>
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

    <script>

        $(document).ready(function () {
            // Inisialisasi DataTables
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
                }
            });

            // Ketika tombol Verifikasi diklik
            $('#verifikasiModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Tombol yang diklik
                var nama = button.data('nama'); // Nama mahasiswa
                var nim = button.data('nim'); // NIM mahasiswa
                var berkas = button.data('berkas'); // Nama berkas
                var file = button.data('file'); // Lokasi file untuk preview
                var jenis_berkas = button.data('jenis_berkas'); // Jenis berkas (aplikasi, skripsi, publikasi jurnal)

                // Setel nilai input di modal
                $('#nama').val(nama);
                $('#nim').val(nim);
                $('#namaBerkas').val(berkas);
                $('#formNim').val(nim);
                $('#formNama').val(nama);
                $('#jenis_berkas').val(jenis_berkas);

                // Reset modal
                $('#pdfPreview').hide();
                $('#downloadButtonContainer').hide();
                $('#keterangan').prop('disabled', true);

                // Periksa jenis file dan sesuaikan tampilan
                var fileExtension = file.split('.').pop().toLowerCase();

                if (berkas === 'Aplikasi') {

                    console.log('Ekstensi file: ', fileExtension);  // Debugging ekstensi

                    if (fileExtension === 'rar' || fileExtension === 'zip') {
                        $('#downloadButtonContainer').show();
                        $('#downloadButton').attr('href', file); // Tautkan ke file zip/rar yang sesuai
                    } else {
                        $('#downloadButtonContainer').hide(); // Sembunyikan tombol download jika bukan rar atau zip
                    }
                } else {
                    var pdfPath = `../Documents/uploads/${jenis_berkas}/${nim}_${jenis_berkas}.pdf`; // Path PDF sesuai jenis berkas

                    // Cek apakah file PDF ada
                    $.ajax({
                        url: pdfPath,
                        type: 'HEAD', // Hanya periksa apakah file ada
                        success: function () {
                            $('#pdfPreview').attr('src', pdfPath).show(); // Tampilkan preview PDF jika file ada
                        },
                        error: function () {
                            $('#pdfPreview').hide(); // Sembunyikan preview jika file tidak ada
                        }
                    });
                }

                // Menambahkan jenis berkas ke form
                $('#verifikasiForm').attr('action', 'konfirmasi.php?jenis_berkas=' + jenis_berkas);
                $('#jenis_berkas').val(jenis_berkas);  // Set nilai hidden input jenis_berkas
            });
        });

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
                    $('#verifikasiModal').modal('hide');
                }
            });
        });

        $(document).ready(function () {
            // Inisialisasi status awal (Ketika modal dibuka)
            toggleFormFields();

            // Ketika radio button status verifikasi diubah
            $("input[name='status_verifikasi']").change(function () {
                toggleFormFields();
            });

            // Ketika keterangan diubah (untuk mengaktifkan tombol simpan)
            $("#keterangan").on('input', function () {
                toggleSaveButton();
            });

            // Fungsi untuk menyesuaikan kondisi form
            function toggleFormFields() {
                const statusVerifikasi = $("input[name='status_verifikasi']:checked").val();

                if (statusVerifikasi === "4") {
                    // Jika terverifikasi: keterangan opsional dan tombol simpan diaktifkan
                    $("#keterangan").prop("disabled", false);  // Mengaktifkan textarea keterangan
                    $("#keterangan").val('');  // Menghapus isi textarea
                    $("#simpanVerifikasi").prop("disabled", false); // Mengaktifkan tombol simpan
                } else if (statusVerifikasi === "2") {
                    // Jika ditolak: keterangan wajib diisi dan tombol simpan dinonaktifkan
                    $("#keterangan").prop("disabled", false); // Mengaktifkan textarea keterangan
                    $("#simpanVerifikasi").prop("disabled", true); // Menonaktifkan tombol simpan
                } else {
                    // Jika tidak ada pilihan: keterangan di-disable dan tombol simpan dinonaktifkan
                    $("#keterangan").prop("disabled", true); // Menonaktifkan textarea
                    $("#simpanVerifikasi").prop("disabled", true); // Menonaktifkan tombol simpan
                }
            }

            // Fungsi untuk mengaktifkan tombol simpan jika keterangan sudah diisi
            function toggleSaveButton() {
                const keterangan = $("#keterangan").val().trim();
                const statusVerifikasi = $("input[name='status_verifikasi']:checked").val();

                // Aktifkan tombol simpan hanya jika status verifikasi 'tidak_terverifikasi' dan keterangan diisi
                if (statusVerifikasi === "2" && keterangan !== '') {
                    $("#simpanVerifikasi").prop("disabled", false);
                } else {
                    $("#simpanVerifikasi").prop("disabled", false); // Nonaktifkan tombol simpan jika kondisi tidak terpenuhi
                }
            }

            // Pastikan status terpilih sebelum form disubmit
            $("#verifikasiForm").submit(function (e) {
                const statusVerifikasi = $("input[name='status_verifikasi']:checked").val();
                if (!statusVerifikasi) {
                    e.preventDefault(); // Mencegah pengiriman form jika status belum dipilih
                    alert("Status verifikasi belum dipilih. Silakan pilih status.");
                    return false; // Menghentikan form submit
                }

                var keterangan = $("#keterangan").val().trim();
                if (keterangan === '') {
                    $("#keterangan").val('-'); // Set default keterangan menjadi "-"
                }

                return true; // Melanjutkan pengiriman form jika semua validasi terpenuhi
            });

            // Reset radio buttons dan form ketika modal ditutup
            $('#verifikasiModal').on('hidden.bs.modal', function () {
                $("input[name='status_verifikasi']").prop('checked', false); // Menghapus pilihan radio
                $("#keterangan").val(''); // Menghapus keterangan
                $("#keterangan").prop("disabled", true); // Menonaktifkan textarea
                $("#simpanVerifikasi").prop("disabled", true); // Menonaktifkan tombol simpan
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const statusModal = document.getElementById('uploadModalStatus');
            const messageContent = document.getElementById('uploadMessage');
            const successIcon = document.getElementById('successIcon');
            const errorIcon = document.getElementById('errorIcon');

            fetch('../fetchMessage.php')
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        messageContent.textContent = data.message.content;
                        if (data.message.type === 'success') {
                            successIcon.style.display = 'block';
                            errorIcon.style.display = 'none';
                        } else {
                            successIcon.style.display = 'none';
                            errorIcon.style.display = 'block';
                        }
                        $(statusModal).modal('show');
                    }
                });
        });

    </script>

</body>

</html>