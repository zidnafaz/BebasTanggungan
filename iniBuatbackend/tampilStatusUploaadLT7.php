<?php
include 'koneksi.php';
include 'login.php';

// Pastikan $inputUsername memiliki nilai valid

try {
    // Query dengan parameter
    $sql = "
        select m.nim, m.nama_mahasiswa, skripsi.status_pengumpulan_skripsi, 
            a.status_pengumpulan_aplikasi, pj.status_pengumpulan_publikasi_jurnal
        from mahasiswa m
        JOIN dbo.skripsi ON m.nim = skripsi.nim
        JOIN dbo.aplikasi a ON m.nim = a.nim
        JOIN dbo.publikasi_jurnal pj ON m.nim = pj.nim";

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
                <th>Status Skripsi</th>
                <th>Status Aplikasi</th>
                <th>Status Publikasi Jurnal</th>
                <form action="coba.html" method="post">
        <button type="submit">Panggil File PHP</button>
    </form>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nim']) ?></td>
                    <td><?= htmlspecialchars($row['nama_mahasiswa']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengumpulan_skripsi']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengumpulan_aplikasi']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengumpulan_publikasi_jurnal']) ?></td>
                </tr>
            <?php endforeach; ?>
            <form action="generatePdf.html" method="post">
            <button type="submit">Generate PDF</button>
        </tbody>
    </table>
</body>
</html>
