<?php
session_start();
require_once '../Koneksi.php';

$db = new Koneksi();
$conn = $db->connect();

if (isset($_SESSION['id'])) {
    $nim = $_SESSION['id'];

    // Query untuk tiap tabel
    $query = [
        'penyerahan_skripsi' => "SELECT 'Penyerahan Laporan Skripsi' AS nama, status_pengumpulan_penyerahan_skripsi AS status, keterangan_pengumpulan_penyerahan_skripsi AS keterangan FROM penyerahan_skripsi WHERE nim = ?",
        'penyerahan_pkl' => "SELECT 'Penyerahan Laporan PKL' AS nama, status_pengumpulan_penyerahan_pkl AS status, keterangan_pengumpulan_penyerahan_pkl AS keterangan FROM penyerahan_pkl WHERE nim = ?",
        'toeic' => "SELECT 'TOEIC' AS nama, status_pengumpulan_toeic AS status, keterangan_pengumpulan_toeic AS keterangan FROM toeic WHERE nim = ?",
        'bebas_kompen' => "SELECT 'Bebas Kompen' AS nama, status_pengumpulan_bebas_kompen AS status, keterangan_pengumpulan_bebas_kompen AS keterangan FROM bebas_kompen WHERE nim = ?",
        'penyerahan_kebenaran_data' => "SELECT 'Pernyataan Kebenaran Data' AS nama, status_pengumpulan_penyerahan_kebenaran_data AS status, keterangan_pengumpulan_penyerahan_kebenaran_data AS keterangan FROM penyerahan_kebenaran_data WHERE nim = ?"
    ];

    $no = 1;
    foreach ($query as $key => $sql) {
        $stmt = sqlsrv_query($conn, $sql, [$nim]);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $statusClassMap = match ($row['status']) {
                '1' => ['status' => 'pending', 'class' => 'bg-warning text-dark'],
                '2' => ['status' => 'ditolak', 'class' => 'bg-danger text-white'],
                '3' => ['status' => 'belum upload', 'class' => 'bg-secondary text-white'],
                '4' => ['status' => 'terverifikasi', 'class' => 'bg-success text-white'],
                default => ['status' => 'unknown', 'class' => 'bg-light text-dark'],
            };
        
            // Ambil status dan class
            $statusText = $statusClassMap['status'];
            $statusClass = $statusClassMap['class'];
        
            // Tentukan file download berdasarkan key
            $filePath = '../Documents/Uploads/' . $key . '/' . $nim . '_' . basename($key) . '.pdf'; // Sesuaikan dengan ekstensi file yang diharapkan (misal .pdf)
            $downloadButton = '';
            $uploadButton = '';
        
            // Tombol Upload: aktif jika status 'belum upload' atau 'ditolak', disabled jika status lainnya
            if (in_array($row['status'], ['3', '2'])) { // '3' untuk 'belum upload', '2' untuk 'ditolak'
                $uploadButton = "<button onclick=\"setUploadDir('{$key}')\" class=\"btn btn-primary btn-sm\" data-toggle=\"modal\" data-target=\"#uploadModal\">
                                    <i class=\"fas fa-solid fa-cloud-arrow-up\"></i> Upload 
                                  </button>";
            } else {
                $uploadButton = "<button class=\"btn btn-secondary btn-sm\" disabled><i class=\"fas fa-solid fa-cloud-arrow-up\"></i> Upload</button>";
            }
        
            // Tombol Download: aktif jika statusnya 'pending', 'ditolak', atau 'terverifikasi', dan file ada
            if (in_array($row['status'], ['1', '2', '4']) && file_exists($filePath)) { // '1', '2', '4' sesuai status
                $downloadButton = "<a href='{$filePath}' class='btn btn-success btn-sm' download>
                                    <i class='fas fa-download'></i> Download
                                  </a>";
            } else {
                $downloadButton = "<button class=\"btn btn-secondary btn-sm\" disabled><i class='fas fa-download'></i> Download</button>";
            }
        
            echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama']}</td>
                <td><span class='badge {$statusClass} p-2 rounded text-uppercase fs-5' style='cursor: pointer;' title='{$statusText}'>
                        {$statusText}
                    </span></td>
                <td>{$row['keterangan']}</td>
                <td>{$uploadButton} {$downloadButton}</td>
            </tr>";
            $no++;
        }
        sqlsrv_free_stmt($stmt);
    }
} else {
    header("Location: ../index.html");
    exit();
}

sqlsrv_close($conn);
?>