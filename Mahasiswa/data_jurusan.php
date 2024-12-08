<?php
include '../koneksi.php';

if (isset($_COOKIE['id'])) {
    $nim = $_COOKIE['id'];

    // Query untuk tiap tabel
    $query = [
        'skripsi' => "SELECT 'Skripsi' AS nama, status_pengumpulan_skripsi AS status, keterangan_pengumpulan_skripsi AS keterangan FROM skripsi WHERE nim = ?",
        'aplikasi' => "SELECT 'Aplikasi' AS nama, status_pengumpulan_aplikasi AS status, keterangan_pengumpulan_aplikasi AS keterangan FROM aplikasi WHERE nim = ?",
        'publikasi_jurnal' => "SELECT 'Publikasi Jurnal' AS nama, status_pengumpulan_publikasi_jurnal AS status, keterangan_pengumpulan_publikasi_jurnal AS keterangan FROM publikasi_jurnal WHERE nim = ?"
    ];

    $no = 1;
    foreach ($query as $key => $sql) {
        $stmt = sqlsrv_query($conn, $sql, [$nim]);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $statusClass = match ($row['status']) {
                'belum upload' => 'bg-secondary text-white',
                'pending' => 'bg-warning text-dark',
                'ditolak' => 'bg-danger text-white',
                'terverifikasi' => 'bg-success text-white',
                default => 'bg-light text-dark'
            };

            // Tentukan file download berdasarkan key
            $fileExtension = $key === 'aplikasi' ? ['zip', 'rar'] : ['pdf']; // Tentukan ekstensi file sesuai dengan key
            $filePath = '../Documents/Uploads/' . $key . '/' . $nim . '_' . basename($key) . '.' . (in_array($key, ['aplikasi']) ? 'zip' : 'pdf'); // Sesuaikan ekstensi untuk aplikasi
            $downloadButton = '';
            $uploadButton = '';

            // Tombol Upload: aktif jika status 'belum upload' atau 'ditolak', disabled jika status lainnya
            if ($row['status'] === 'belum upload' || $row['status'] === 'ditolak') {
                $uploadButton = "<button onclick=\"setUploadDir('{$key}')\" class=\"btn btn-primary btn-sm\" data-toggle=\"modal\" data-target=\"#uploadModal\">
                                    <i class=\"fas fa-solid fa-cloud-arrow-up\"></i> Upload 
                                  </button>";
            } else {
                $uploadButton = "<button class=\"btn btn-secondary btn-sm\" disabled><i class=\"fas fa-solid fa-cloud-arrow-up\"></i> Disable</button>";
            }

            // Tombol Download: aktif jika statusnya 'pending', 'ditolak', atau 'terverifikasi', dan file ada
            if (in_array($row['status'], ['pending', 'ditolak', 'terverifikasi']) && file_exists($filePath)) {
                $downloadButton = "<a href='{$filePath}' class='btn btn-success btn-sm' download>
                                    <i class='fas fa-download'></i> Download
                                  </a>";
            } else {
                $downloadButton = "<button class=\"btn btn-secondary btn-sm\" disabled><i class='fas fa-download'></i> Disable</button>";
            }

            // Tampilkan baris tabel dengan tombol Upload dan Download
            echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama']}</td>
                <td><span class='badge {$statusClass} p-2 rounded text-uppercase fs-5' style='cursor: pointer;' title='{$row['status']}'>
                        {$row['status']}
                    </span></td>
                <td>{$row['keterangan']}</td>
                <td>{$uploadButton} {$downloadButton}</td>
            </tr>";
            $no++;
        }
        sqlsrv_free_stmt($stmt);
    }
} else {
    echo "<tr><td colspan='5'>NIM belum diatur. Silakan login terlebih dahulu.</td></tr>";
}

sqlsrv_close($conn);
?>
