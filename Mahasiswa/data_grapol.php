<?php
include '../koneksi.php';

if (isset($_COOKIE['id'])) {
    $nim = $_COOKIE['id'];

    // Query untuk tiap tabel
    $query = [
        'penyerahan_hardcopy' => "SELECT 'Bukti Penyerahan Hardcopy Skripsi' AS nama, status_pengumpulan_penyerahan_hardcopy AS status, keterangan_pengumpulan_penyerahan_hardcopy AS keterangan FROM penyerahan_hardcopy WHERE nim = ?",
        'tugas_akhir_softcopy' => "SELECT 'Bukti Upload Softcopy Skripsi' AS nama, status_pengumpulan_tugas_akhir_softcopy AS status, keterangan_pengumpulan_tugas_akhir_softcopy AS keterangan FROM tugas_akhir_softcopy WHERE nim = ?",
        'bebas_pinjam_buku_perpustakaan' => "SELECT 'Bukti Bebas Pinjam Buku Perpustakaan' AS nama, status_pengumpulan_bebas_pinjam_buku_perpustakaan AS status, keterangan_pengumpulan_bebas_pinjam_buku_perpustakaan AS keterangan FROM bebas_pinjam_buku_perpustakaan WHERE nim = ?",
        'hasil_kuisioner' => "SELECT 'Bukti Pengisian Kuisioner' AS nama, status_pengumpulan_hasil_kuisioner AS status, keterangan_pengumpulan_hasil_kuisioner AS keterangan FROM hasil_kuisioner WHERE nim = ?"
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
            $filePath = '../Documents/Uploads/' . $key . '/' . $nim . '_' . basename($key) . '.pdf'; // Sesuaikan dengan ekstensi file yang diharapkan (misal .pdf)
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
