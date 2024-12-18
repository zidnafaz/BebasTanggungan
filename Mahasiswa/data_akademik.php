<?php
session_start();
require_once '../Koneksi.php';

$db = new Koneksi();
$conn = $db->connect();

if (isset($_SESSION['id'])) {
    $nim = $_SESSION['id'];

    // Query untuk tiap tabel
    $query = [
        'data_alumni' => "SELECT 'Bukti Pengisian Data Alumni' AS nama, status_pengumpulan_data_alumni AS status, keterangan_pengumpulan_data_alumni AS keterangan FROM data_alumni WHERE nim = ?",
        'skkm' => "SELECT 'Bukti Memenuhi SKKM' AS nama, status_pengumpulan_skkm AS status, keterangan_pengumpulan_skkm AS keterangan FROM skkm WHERE nim = ?",
        'foto_ijazah' => "SELECT 'Bukti Upload Foto Ijazah' AS nama, status_pengumpulan_foto_ijazah AS status, keterangan_pengumpulan_foto_ijazah AS keterangan FROM foto_ijazah WHERE nim = ?",
        'ukt' => "SELECT 'Bukti Lunas UKT' AS nama, status_pengumpulan_ukt AS status, keterangan_pengumpulan_ukt AS keterangan FROM ukt WHERE nim = ?"
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