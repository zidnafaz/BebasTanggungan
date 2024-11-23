<?php
include '../koneksi.php';

// Query untuk mengambil data skripsi
$sql = "SELECT m.nim, m.nama_mahasiswa, 
        ph.status_pengumpulan_penyerahan_hardcopy
        FROM dbo.mahasiswa m
        JOIN dbo.penyerahan_hardcopy ph ON m.nim = ph.nim";
$result = sqlsrv_query($conn, $sql);

if($result == false){
    die("Kesalahan saat menjalankan query: " . print_r(sqlsrv_errors(), true));
}

$response = "";

// Ambil data dan cek apakah ada
$rows = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
if ($rows) {
    $no = 1;
    do {
        $status_badge = $rows['status_pengumpulan_penyerahan_hardcopy'] === 'Selesai' 
            ? '<span class="badge bg-success text-white">Selesai</span>' 
            : '<span class="badge bg-warning text-dark">Proses</span>';
        
        $response .= "<tr>
            <td>{$rows['nim']}</td>
            <td>{$rows['nama_mahasiswa']}</td>
            <td>{$rows['status_pengumpulan_penyerahan_hardcopy']}</td>
            <td><button class='btn btn-primary btn-sm'>action</button></td>
        </tr>";
        $no++;
    } while ($rows = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC));
} else {
    $response .= "<tr><td colspan='4'>Tidak ada data skripsi</td></tr>";
}

echo $response;

// Tutup koneksi
sqlsrv_close($conn);
?>
