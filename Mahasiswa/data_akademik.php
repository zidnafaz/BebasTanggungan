<?php
include '../koneksi.php';

if (isset($_COOKIE['id'])) {
    $nim = $_COOKIE['id'];

    // Query untuk tiap tabel
    $query = [
        'data_alumni' => "SELECT 'Data Alumni' AS nama, status_pengumpulan_data_alumni AS status, keterangan_pengumpulan_data_alumni AS keterangan FROM data_alumni WHERE nim = ?",
        'skkm' => "SELECT 'SKKM' AS nama, status_pengumpulan_skkm AS status, keterangan_pengumpulan_skkm AS keterangan FROM skkm WHERE nim = ?",
        'foto_ijazah' => "SELECT 'Foto Ijazah' AS nama, status_pengumpulan_foto_ijazah AS status, keterangan_pengumpulan_foto_ijazah AS keterangan FROM foto_ijazah WHERE nim = ?",
        'ukt' => "SELECT 'UKT' AS nama, status_pengumpulan_ukt AS status, keterangan_pengumpulan_ukt AS keterangan FROM ukt WHERE nim = ?"
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
