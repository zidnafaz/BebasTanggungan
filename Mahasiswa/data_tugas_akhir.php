<?php
include '../koneksi.php';

if (isset($_COOKIE['id'])) {
    $nim = $_COOKIE['id'];

    if (isset($_GET['table'])) {
        $currentTable = $_GET['table']; // Nama tabel dari parameter URL
    }    

    $query = [
        'skripsi' => "SELECT 'Skripsi' AS nama, status_pengumpulan_skripsi AS status, keterangan_pengumpulan_skripsi AS keterangan FROM skripsi WHERE nim = ?",
        'aplikasi' => "SELECT 'Aplikasi' AS nama, status_pengumpulan_aplikasi AS status, keterangan_pengumpulan_aplikasi AS keterangan FROM aplikasi WHERE nim = ?",
        'publikasi' => "SELECT 'Publikasi Jurnal' AS nama, status_pengumpulan_publikasi_jurnal AS status, keterangan_pengumpulan_publikasi_jurnal AS keterangan FROM publikasi_jurnal WHERE nim = ?"
    ];

    $no = 1;
    foreach ($query as $key => $sql) {
        $stmt = sqlsrv_query($conn, $sql, [$nim]);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            switch ($row['status']) {
                case 'belum upload':
                    $statusClass = 'bg-secondary text-white'; // Abu-abu
                    break;
                case 'pending':
                    $statusClass = 'bg-warning text-dark'; // Kuning
                    break;
                case 'tidak terkonfirmasi':
                    $statusClass = 'bg-danger text-white'; // Merah
                    break;
                case 'terkonfirmasi':
                    $statusClass = 'bg-success text-white'; // Hijau
                    break;
                default:
                    $statusClass = 'bg-light text-dark'; // Default
            }

            $button = ($row['status'] === 'belum upload' || $row['status'] === 'tidak terkonfirmasi') ?
                "<button onclick=\"$('#uploadDir').val('uploads/{$key}')\" class=\"btn btn-success btn-sm\" data-toggle=\"modal\" data-target=\"#uploadModal\">
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
