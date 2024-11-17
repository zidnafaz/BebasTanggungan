<?php
include 'koneksi.php';
include 'login.php';

// Pastikan $inputUsername memiliki nilai valid

try {
    // Query dengan parameter
    $sql = "
        select m.nim, m.nama_mahasiswa, ta.status_pengumpulan_tugas_akhir_softcopy, hk.status_pengumpulan_hasil_kuisioner
            , bpb.status_pengumpulan_bebas_pinjam_buku_perpustakaan, ph.status_pengumpulan_penyerahan_hardcopy
        from dbo.mahasiswa m
        JOIN dbo.tugas_akhir_softcopy ta ON m.nim = ta.nim
        JOIN dbo.hasil_kuisioner hk ON m.nim = hk.nim
        JOIN dbo.bebas_pinjam_buku_perpustakaan bpb ON m.nim = bpb.nim
        JOIN dbo.penyerahan_hardcopy ph ON m.nim = ph.nim";

    // Parameter query

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Ambil hasil
    $results = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $results[] = $row;
    }

    // Tutup statement
    sqlsrv_free_stmt($stmt);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Data Mahasiswa</h1>
    <table>
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Status Softcopy Tugas Akhir</th>
                <th>Status Kuisioner</th>
                <th>Status Bebas Pinjam Perpustakaan</th>
                <th>Status Penyerahan Hardcopy</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nim']) ?></td>
                    <td><?= htmlspecialchars($row['nama_mahasiswa']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengumpulan_tugas_akhir_softcopy']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengumpulan_hasil_kuisioner']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengumpulan_bebas_pinjam_buku_perpustakaan']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengumpulan_penyerahan_hardcopy']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
