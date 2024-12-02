<?php
include '../koneksi.php';

if (isset($_COOKIE['id'])) {
    $nim = $_COOKIE['id'];

    // Query untuk tiap tabel
    $query = [
        'penyerahan_hardcopy' => "SELECT 'Penyerahan Hardcopy' AS nama, status_pengumpulan_penyerahan_hardcopy AS status, keterangan_pengumpulan_penyerahan_hardcopy AS keterangan FROM penyerahan_hardcopy WHERE nim = ?",
        'tugas_akhir_softcopy' => "SELECT 'Tugas Akhir Softcopy' AS nama, status_pengumpulan_tugas_akhir_softcopy AS status, keterangan_pengumpulan_tugas_akhir_softcopy AS keterangan FROM tugas_akhir_softcopy WHERE nim = ?",
        'bebas_pinjam_buku_perpustakaan' => "SELECT 'Bebas Pinjam Buku Perpustakaan' AS nama, status_pengumpulan_bebas_pinjam_buku_perpustakaan AS status, keterangan_pengumpulan_bebas_pinjam_buku_perpustakaan AS keterangan FROM bebas_pinjam_buku_perpustakaan WHERE nim = ?",
        'hasil_kuisioner' => "SELECT 'Hasil Kuisioner' AS nama, status_pengumpulan_hasil_kuisioner AS status, keterangan_pengumpulan_hasil_kuisioner AS keterangan FROM hasil_kuisioner WHERE nim = ?"
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
                'tidak terkonfirmasi' => 'bg-danger text-white',
                'terkonfirmasi' => 'bg-success text-white',
                default => 'bg-light text-dark'
            };

            $button = ($row['status'] === 'belum upload' || $row['status'] === 'tidak terkonfirmasi') ?
                "<button onclick=\"setUploadDir('{$key}')\" class=\"btn btn-primary btn-sm\" data-toggle=\"modal\" data-target=\"#uploadModal\">
                    <i class=\"fas fa-solid fa-cloud-arrow-up\"></i> Upload
                </button>" :
                "<button class=\"btn btn-secondary btn-sm\" disabled>Disable</button>";

            echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama']}</td>
                <td><span class='badge {$statusClass} p-2 rounded text-uppercase fs-5' style='cursor: pointer;' title='{$row['status']}'>
                        {$row['status']}
                    </span></td>
                <td>{$row['keterangan']}</td>
                <td>{$button}</td>
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
