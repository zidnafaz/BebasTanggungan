<?php
include '../koneksi.php';
include '../data/dataAdmin.php';

$nim = isset($_GET['nim']) ? $_GET['nim'] : null;

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

    <title>Verifikasi</title>

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
        .status span {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 8px;
            font-size: 0.9rem;
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }

        .status .badge-success {
            background-color: #1cc88a;
        }

        .status .badge-warning {
            background-color: #f6c23e;
            color: #5a5c69;
        }

        .status .badge-secondary {
            background-color: #858796;
        }

        .status .badge-danger {
            background-color: #e74a3b;
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


            <!-- Nav Item - Dashboard -->
            <li class="nav-item" id="nav-skripsi">
                <a class="nav-link" href="skripsi.php">
                    <i class="fas fa-solid fa-book"></i>
                    <span>Laporan Skripsi</span></a>
            </li>

            <li class="nav-item" id="nav-pkl">
                <a class="nav-link" href="pkl.php">
                    <i class="fas fa-solid fa-file-lines"></i>
                    <span>Laporan PKL</span></a>
            </li>

            <li class="nav-item" id="nav-toeic">
                <a class="nav-link" href="toeic.php">
                    <i class="fas fa-solid fa-file"></i>
                    <span>TOEIC</span></a>
            </li>

            <li class="nav-item" id="nav-kompen">
                <a class="nav-link" href="kompen.php">
                    <i class="fas fa-solid fa-file-invoice"></i>
                    <span>Kompen</span></a>
            </li>

            <li class="nav-item active" id="nav-kebenaran_data">
                <a class="nav-link" href="kebenarandata.php">
                    <i class="fas fa-solid fa-user-graduate"></i>
                    <span>Kebenaran Data</span></a>
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
                    <h1 class="h3 mb-2 text-gray-800">Data Verifikasi Kebenaran Data Diri</h1>
                    <p class="mb-4">Konfirmasi Data Mahasiswa dengan seksama!</p>

                    <!-- DataTables Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Mahasiswa</h6>
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

                            <table class="table table-striped table-bordered" id="dataTable" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Pindah Halaman</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    try {
                                        // Query untuk mengambil data
                                        $sql = "SELECT m.nim, m.nama_mahasiswa, pk.status_pengumpulan_penyerahan_kebenaran_data AS status
                                                FROM dbo.mahasiswa m
                                                JOIN dbo.penyerahan_kebenaran_data pk ON m.nim = pk.nim";

                                        // Tambahkan kondisi WHERE jika ada NIM
                                        if ($nim) {
                                            $sql .= " WHERE m.nim = ?";
                                        }

                                        // Urutkan data berdasarkan status
                                        $sql .= " ORDER BY 
                                                    CASE 
                                                        WHEN pk.status_pengumpulan_penyerahan_kebenaran_data = 'pending' THEN 1
                                                        WHEN pk.status_pengumpulan_penyerahan_kebenaran_data = 'ditolak' THEN 2
                                                        WHEN pk.status_pengumpulan_penyerahan_kebenaran_data = 'belum upload' THEN 3
                                                        WHEN pk.status_pengumpulan_penyerahan_kebenaran_data = 'terverifikasi' THEN 4
                                                        ELSE 5
                                                    END";

                                        // Tentukan parameter untuk query
                                        $params = $nim ? array($nim) : array();
                                        $result = sqlsrv_query($conn, $sql, $params);

                                        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)):
                                            // Gunakan match expression untuk kelas badge
                                            $statusClass = match (strtolower($row['status'])) {
                                                'belum upload' => 'bg-secondary text-white',
                                                'pending' => 'bg-warning text-dark',
                                                'ditolak' => 'bg-danger text-white',
                                                'terverifikasi' => 'bg-success text-white',
                                                default => 'bg-light text-dark'
                                            };

                                            ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['nim']) ?></td>
                                                <td><?= htmlspecialchars($row['nama_mahasiswa']) ?></td>
                                                <td class="status">
                                                    <span class="badge <?= $statusClass ?> p-2 rounded text-uppercase"
                                                        style="cursor: pointer;"
                                                        title="<?= htmlspecialchars($row['status']) ?>">
                                                        <?= htmlspecialchars($row['status']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if (strtolower($row['status']) === 'belum upload'): ?>
                                                        <button class="btn btn-secondary btn-sm" disabled><i class="fa fa-ban"></i>
                                                            Disabled</button>
                                                    <?php elseif (strtolower($row['status']) === 'terverifikasi'): ?>
                                                        <button class="btn btn-info btn-sm edit-data"
                                                            data-nim="<?= htmlspecialchars($row['nim']) ?>"
                                                            data-nama="<?= htmlspecialchars($row['nama_mahasiswa']) ?>"
                                                            data-nama-berkas="<?= $row['nim'] . "_penyerahan_kebenaran_data.pdf" ?>"
                                                            data-pdf="../Documents/uploads/penyerahan_kebenaran_data/<?= $row['nim'] ?>_penyerahan_kebenaran_data.pdf"
                                                            data-target="#verifikasiModal" data-toggle="modal">
                                                            <i class="fa fa-solid fa-file-lines"></i> Preview
                                                        </button>
                                                    <?php else: ?>
                                                        <button class="btn btn-primary btn-sm edit-data"
                                                            data-nim="<?= htmlspecialchars($row['nim']) ?>"
                                                            data-nama="<?= htmlspecialchars($row['nama_mahasiswa']) ?>"
                                                            data-nama-berkas="<?= $row['nim'] . "_penyerahan_kebenaran_data.pdf" ?>"
                                                            data-pdf="../Documents/uploads/penyerahan_kebenaran_data/<?= $row['nim'] ?>_penyerahan_kebenaran_data.pdf"
                                                            data-target="#verifikasiModal" data-toggle="modal">
                                                            <i class="fa fa-edit"></i> Verifikasi
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div>
                                                        <select class="pageDropdown form-control" style="width: 60%;"
                                                            data-nim="<?= htmlspecialchars($row['nim']) ?>">
                                                            <option value="">Pilih Halaman</option>
                                                            <option value="skripsi">Laporan Skripsi</option>
                                                            <option value="pkl">Laporan PKL</option>
                                                            <option value="toeic">TOEIC</option>
                                                            <option value="kompen">Kompen</option>
                                                            <option value="kebenarandata">Kebenaran Data</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        endwhile;
                                        sqlsrv_free_stmt($result);
                                    } catch (Exception $e) {
                                        echo "Error: " . $e->getMessage();
                                    }
                                    ?>
                                </tbody>
                            </table>
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
                    <div class="embed-responsive embed-responsive-4by3 mb-4">
                        <iframe id="pdfPreview" src="" width="100%" height="400px">
                            PDF tidak dapat ditampilkan.
                        </iframe>
                    </div>

                    <!-- Verifikasi -->
                    <div class="card">
                        <div class="card-body">
                            <h6><strong>Status Verifikasi:</strong></h6>
                            <form id="verifikasiForm" action="buttonKonfirmasi/buttonKebenaranData.php" method="POST">
                                <div class="form-group">
                                    <label>
                                        <input type="radio" id="terverifikasi" name="status_verifikasi"
                                            value="terverifikasi">
                                        terverifikasi
                                    </label>
                                    <label>
                                        <input type="radio" id="tidak_terverifikasi" name="status_verifikasi"
                                            value="ditolak">
                                        ditolak
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

    <!-- Page level plugins (Chart.js) -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts (Chart demos) -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>

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

            // Menambahkan filter berdasarkan status
            $('#statusFilter').on('change', function () {
                var status = $(this).val();
                table.column(2).search(status).draw();  // Kolom ke-2 adalah Status tugas_akhir_softcopy
            });

            // Dropdown untuk halaman tujuan
            $('#dataTable').on('change', '.pageDropdown', function () {
                var selectedPage = $(this).val(); // Halaman yang dipilih
                var nim = $(this).data('nim'); // NIM dari data-nim atribut
                var currentUrl = window.location.href; // URL saat ini

                // Jika halaman dipilih
                if (selectedPage) {
                    let newUrl = selectedPage + ".php"; // Halaman tujuan

                    // Tambahkan NIM ke URL jika ada
                    if (nim) {
                        newUrl += "?nim=" + encodeURIComponent(nim);
                    }

                    window.location.href = newUrl;
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            const statusCells = document.querySelectorAll(".status span");
            statusCells.forEach(cell => {
                if (cell.textContent.trim() === "terverifikasi") {
                    cell.classList.add("badge-success");
                } else if (cell.textContent.trim() === "belum upload") {
                    cell.classList.add("badge-secondary");
                } else if (cell.textContent.trim() === "pending") {
                    cell.classList.add("badge-warning");
                } else if (cell.textContent.trim() === "ditolak") {
                    cell.classList.add("badge-danger");
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            const buttons = document.querySelectorAll(".edit-data");
            buttons.forEach(button => {
                button.addEventListener("click", function () {
                    const nim = this.getAttribute("data-nim");
                    const nama = this.getAttribute("data-nama");
                    const namaBerkas = this.getAttribute("data-nama-berkas");
                    const pdfSrc = this.getAttribute("data-pdf");

                    // Set data ke modal
                    document.getElementById("formNim").value = nim;
                    document.getElementById("formNama").value = nama;
                    document.getElementById("nama").value = nama;
                    document.getElementById("nim").value = nim;
                    document.getElementById("namaBerkas").value = namaBerkas;
                    document.getElementById("pdfPreview").src = pdfSrc;
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            // Event listener untuk setiap tombol Verifikasi
            const buttons = document.querySelectorAll(".edit-data");
            buttons.forEach(button => {
                button.addEventListener("click", function () {
                    const nim = this.getAttribute("data-nim");
                    const pdfUrl = `../Documents/uploads/penyerahan_kebenaran_data/${nim}_penyerahan_kebenaran_data.pdf`;

                    // Update isi modal
                    document.getElementById('nim').value = nim;
                    document.getElementById('namaBerkas').value = `${nim}_penyerahan_kebenaran_data.pdf`;
                    document.getElementById('pdfPreview').setAttribute('src', pdfUrl); // Update src iframe
                });
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

                if (statusVerifikasi === "terverifikasi") {
                    // Jika terverifikasi: keterangan opsional dan tombol simpan diaktifkan
                    $("#keterangan").prop("disabled", false);  // Mengaktifkan textarea keterangan
                    $("#keterangan").val('');  // Menghapus isi textarea
                    $("#simpanVerifikasi").prop("disabled", false); // Mengaktifkan tombol simpan
                } else if (statusVerifikasi === "ditolak") {
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
                if (statusVerifikasi === "ditolak" && keterangan !== '') {
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
    </script>

</body>

</html>