<?php
include 'koneksi.php';
include 'login.php';

// Pastikan $inputUsername memiliki nilai valid

try {
    // Query dengan parameter
    $sql = "
        SELECT m.nim, m.nama_mahasiswa, da.status_pengumpulan_data_alumni, fi.status_pengumpulan_foto_ijazah, 
            skkm.status_pengumpulan_skkm, ukt.status_pengumpulan_ukt
        FROM dbo.mahasiswa m
        JOIN dbo.data_alumni da ON m.nim = da.nim
        JOIN dbo.foto_ijazah fi ON m.nim = fi.nim
        JOIN dbo.skkm ON m.nim = skkm.nim
        JOIN dbo.ukt ON m.nim = ukt.nim;";

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
                <th>Status Data Alumni</th>
                <th>Status Foto Ijazah</th>
                <th>Status SKKM</th>
                <th>Status UKT</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nim']) ?></td>
                    <td><?= htmlspecialchars($row['nama_mahasiswa']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengumpulan_data_alumni']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengumpulan_foto_ijazah']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengumpulan_skkm']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengumpulan_ukt']) ?></td>
                </tr>
            <?php endforeach; ?>
            <form action="generatePdf.html" method="post">
        <button type="submit">Generate PDF</button>
        </tbody>
    </table>
</body>
</html>
