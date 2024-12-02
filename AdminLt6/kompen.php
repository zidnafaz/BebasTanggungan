<?php
include '../koneksi.php';

if (isset($_GET['message']) && isset($_GET['type'])) {
    $message = htmlspecialchars($_GET['message']);
    $messageType = htmlspecialchars($_GET['type']); // "success" atau "danger"

    // Tampilkan alert menggunakan Bootstrap
    echo "<div class='alert alert-$messageType alert-dismissible fade show'
        role='alert'>
        $message
        <button type='button' class='btn-close' data-bs-dismiss='alert'
            aria-label='Close'></button>
    </div>";
}

try{
// Query untuk mengambil data skripsi
$sql = "SELECT m.nim, m.nama_mahasiswa, bk.status_pengumpulan_bebas_kompen
        FROM dbo.mahasiswa m
        JOIN dbo.bebas_kompen bk ON m.nim = bk.nim";
$result = sqlsrv_query($conn, $sql);

if($result == false){
    die("Kesalahan saat menjalankan query: " . print_r(sqlsrv_errors(), true));
}

$hasil=[];

// Ambil data dan cek apakah ada
while($rows = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
    $hasil[]=$rows;
}

sqlsrv_free_stmt($result);
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

    <title>Verifikasi</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

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

    .status .badge-pending {
        background-color: #FFD700;
    }

    .status .badge-empty {
        background-color: gray;
    }

    .status .badge-danger {
        background-color: red;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
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

                <div id="topbar">
                    
                </div>

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data Bebas Kompen</h1>
                    <p class="mb-4">Konfirmasi Data Mahasiswa dengan seksama!</p>

                    <!-- DataTables Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Mahasiswa</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NIM</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Status Bebas Kompen</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($hasil as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['nim']) ?></td>
                                            <td><?= htmlspecialchars($row['nama_mahasiswa']) ?></td>
                                            <td class="status">
                                                <span><?= htmlspecialchars($row['status_pengumpulan_bebas_kompen']) ?></span>
                                            </td>
                                            <td>
                                                <form action="buttonKonfirmasi/buttonBebasKompen.php" method="post"
                                                    style="display:inline;">
                                                    <input type="hidden" name="nim"
                                                        value="<?= htmlspecialchars($row['nim']) ?>">
                                                    <select name="status" class="form-control d-inline"
                                                        style="width:auto; display:inline;">
                                                        <option value="terkonfirmasi"
                                                            <?= $row['status_pengumpulan_bebas_kompen'] === 'terkonfirmasi' ? 'selected' : '' ?>>
                                                            konfirmasi
                                                        </option>
                                                        <option value="tidak terkonfirmasi"
                                                            <?= $row['status_pengumpulan_bebas_kompen'] === 'tidak terkonfirmasi' ? 'selected' : '' ?>>
                                                            tidak konfirmasi</option>
                                                    </select>
                                                    <button type="submit"
                                                        class="btn btn-primary btn-sm">konfirmasi</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>

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

                    <!-- Tampilan PDF -->
                    <div class="embed-responsive embed-responsive-4by3 mb-4">
                        <object id="pdfViewer" data="" type="application/pdf" class="embed-responsive-item">
                            PDF tidak dapat ditampilkan.
                        </object>
                    </div>

                    <!-- Verifikasi -->
                    <div class="card">
                        <div class="card-body">
                            <h6><strong>Status Verifikasi:</strong></h6>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="verifikasiTrue" name="verification"
                                    value="true">
                                <label class="form-check-label" for="verifikasiTrue">Terverifikasi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="verifikasiFalse" name="verification"
                                    value="false">
                                <label class="form-check-label" for="verifikasiFalse">Belum Terverifikasi</label>
                            </div>
                            <div class="mt-3">
                                <label for="keterangan"><strong>Keterangan:</strong></label>
                                <textarea id="keterangan" class="form-control" rows="3"
                                    placeholder="Tambahkan keterangan jika diperlukan"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                    <button type="button" class="btn btn-primary" id="saveVerification">
                        <i class="fas fa-save"></i> Simpan
                    </button>
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
    document.addEventListener("DOMContentLoaded", function() {
        const statusCells = document.querySelectorAll(".status span");
        statusCells.forEach(cell => {
            if (cell.textContent.trim() === "terkonfirmasi") {
                cell.classList.add("badge-success");
            } else if (cell.textContent.trim() === "belum upload") {
                cell.classList.add("badge-empty");
            } else if (cell.textContent.trim() === "pending") {
                cell.classList.add("badge-pending");
            } else if (cell.textContent.trim() === "tidak terkonfirmasi") {
                cell.classList.add("badge-danger");
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
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

    $('.edit-data').click(function() {
        var pdfFile = $(this).data('pdf'); // Get PDF file name correctly
        var pdfUrl = '../contohPDF/1.pdf'; // Set PDF path dynamically
        $('#pdfViewer').attr('data', pdfUrl); // Update the object element to show PDF
    });

    // $(document).ready(function () {
    //     // Handle Verifikasi button click
    //     $('.edit-data').click(function () {
    //         var id = $(this).data('id'); // Get the ID of the row
    //         var pdfFile = id + '.pdf'; // Generate the PDF file name based on ID
    //         var pdfUrl = '../contohPDF/' + pdfFile; // Set PDF path dynamically
    //         $('#pdfViewer').attr('data', pdfUrl); // Update the object element to show PDF
    //     });
    // });

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
    </script>

</body>

</html>