<?php
include '../koneksi.php';

if (!isset($_COOKIE['id'])) {
    header("Location: ../index.html");
    exit();
}

$nim = $_COOKIE['id'];

$query = "
    SELECT 
        (CASE WHEN MIN(CASE WHEN status_pengumpulan_penyerahan_hardcopy = 'terkonfirmasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS penyerahan_hardcopy,
        (CASE WHEN MIN(CASE WHEN status_pengumpulan_tugas_akhir_softcopy = 'terkonfirmasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS tugas_akhir_softcopy,
        (CASE WHEN MIN(CASE WHEN status_pengumpulan_bebas_pinjam_buku_perpustakaan = 'terkonfirmasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS bebas_pinjam_buku_perpustakaan,
        (CASE WHEN MIN(CASE WHEN status_pengumpulan_hasil_kuisioner = 'terkonfirmasi' THEN 1 ELSE 0 END) = 1 THEN 1 ELSE 0 END) AS hasil_kuisioner
    FROM dbo.penyerahan_hardcopy
    LEFT JOIN dbo.tugas_akhir_softcopy ON penyerahan_hardcopy.nim = tugas_akhir_softcopy.nim
    LEFT JOIN dbo.bebas_pinjam_buku_perpustakaan ON penyerahan_hardcopy.nim = bebas_pinjam_buku_perpustakaan.nim
    LEFT JOIN dbo.hasil_kuisioner ON penyerahan_hardcopy.nim = hasil_kuisioner.nim
    WHERE penyerahan_hardcopy.nim = '$nim'
";

// Eksekusi query
$stmt = sqlsrv_query($conn, $query);
if (!$stmt) {
    die(print_r(sqlsrv_errors(), true));
}

// Ambil hasil query
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

// Pastikan untuk memanggil fungsi sqlsrv_free_stmt langsung
sqlsrv_free_stmt($stmt);

// Mengecek apakah semua status sudah terkonfirmasi
$allConfirmed = $row['penyerahan_hardcopy'] && $row['tugas_akhir_softcopy'] && $row['bebas_pinjam_buku_perpustakaan'] && $row['hasil_kuisioner'];

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
                    <h1 class="h3 mb-2 text-gray-800">Verifikasi Berkas</h1>
                    <p class="mb-4">Verifikasi berkas pada perpustakaan Polinema (Grapol lantai 3) yang akan diverifikasi oleh ibu Safrilia (<a target="_blank"
                    href="https://wa.me/6281333213023">081333213023</a> - <i>Chat Only</i>) </p>

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
                            <h6 class="m-0 font-weight-bold text-primary">Download Dokumen</h6>
                        </div>
                        <div class="card-body">
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
                                            <td>Panduan Alur Bebas Tanggungan Perpustakaan Grapol</td>
                                            <td>-</td>
                                            <td><a href="../Documents/downloads/template/[Panduan] Alur Bebas Tanggungan Perpustakaan Pusat.pdf"
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
                            <h6 class="m-0 font-weight-bold text-primary">Bebas Tanggungan Perpustakaan Polinema</h6>
                        </div>
                        <div class="card-body">
                            <p>Surat ini meliputi Bebas Tanggungan Perpustakaan Polinema.</p>
                            <?php if ($allConfirmed): ?>
                                <a href="uploads/surat_bebas_tanggungan.pdf" class="btn btn-success" download><i class="fas fa-download"></i> Download</a>
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
                            <small class="form-text text-muted">Accepted file type: .doc only</small>
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

        // Ajax untuk mengambil data dan menginisialisasi DataTables
        $(document).ready(function () {
            // Memuat data dari data.php
            $.ajax({
                url: 'data_grapol.php', // File PHP untuk memuat data
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
                url: 'data_grapol.php', // Endpoint untuk mengambil data tabel
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