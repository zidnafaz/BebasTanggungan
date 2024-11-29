<?php
include 'koneksi.php';
include 'login.php';

// Pastikan $inputUsername memiliki nilai valid

try {
    // Query dengan parameter
    $sql = "
        SELECT 
            m.nim, 
            m.nama_mahasiswa, 
            ps.status_pengumpulan_penyerahan_skripsi, 
            pk.status_pengumpulan_penyerahan_pkl,
            toeic.status_pengumpulan_toeic, 
            bk.status_pengumpulan_bebas_kompen, 
            pd.status_pengumpulan_penyerahan_kebenaran_data
        FROM 
            dbo.mahasiswa m
        JOIN 
            dbo.penyerahan_skripsi ps ON m.nim = ps.nim
        JOIN 
            dbo.penyerahan_pkl pk ON m.nim = pk.nim
        JOIN 
            dbo.toeic ON m.nim = toeic.nim
        JOIN 
            dbo.bebas_kompen bk ON m.nim = bk.nim
        JOIN 
            dbo.penyerahan_kebenaran_data pd ON m.nim = pd.nim";

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
                <th>Status PKL</th>
                <th>Status TOEIC</th>
                <th>Status Bebas Kompen</th>
                <th>Status Kebenaran Data</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nim']) ?></td>
                    <td><?= htmlspecialchars($row['nama_mahasiswa']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengumpulan_penyerahan_skripsi']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengumpulan_penyerahan_pkl']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengumpulan_toeic']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengumpulan_bebas_kompen']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengumpulan_penyerahan_kebenaran_data']) ?></td>
                </tr>
            <?php endforeach; ?>
            <form action="generatePdf.html" method="post">
            <button type="submit">Generate PDF</button>
        </tbody>
    </table>
</body>
</html>
