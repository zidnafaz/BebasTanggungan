<?php
session_start();
header('Content-Type: application/json');

require_once '../Koneksi.php';

$db = new Koneksi();
$conn = $db->connect();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.html");
    exit();
}

$nim = $_SESSION['id'];

$query = "
    SELECT 
        SUM(CASE WHEN da.status_pengumpulan_data_alumni = '4' THEN 1 ELSE 0 END +
            CASE WHEN skkm.status_pengumpulan_skkm = '4' THEN 1 ELSE 0 END +
            CASE WHEN fi.status_pengumpulan_foto_ijazah = '4' THEN 1 ELSE 0 END +
            CASE WHEN ukt.status_pengumpulan_ukt = '4' THEN 1 ELSE 0 END +
            CASE WHEN ph.status_pengumpulan_penyerahan_hardcopy = '4' THEN 1 ELSE 0 END +
            CASE WHEN tas.status_pengumpulan_tugas_akhir_softcopy = '4' THEN 1 ELSE 0 END +
            CASE WHEN bpbp.status_pengumpulan_bebas_pinjam_buku_perpustakaan = '4' THEN 1 ELSE 0 END +
            CASE WHEN hk.status_pengumpulan_hasil_kuisioner = '4' THEN 1 ELSE 0 END +
            CASE WHEN ps.status_pengumpulan_penyerahan_skripsi = '4' THEN 1 ELSE 0 END +
            CASE WHEN ppkl.status_pengumpulan_penyerahan_pkl = '4' THEN 1 ELSE 0 END +
            CASE WHEN toeic.status_pengumpulan_toeic = '4' THEN 1 ELSE 0 END +
            CASE WHEN bk.status_pengumpulan_bebas_kompen = '4' THEN 1 ELSE 0 END +
            CASE WHEN pkd.status_pengumpulan_penyerahan_kebenaran_data = '4' THEN 1 ELSE 0 END +
            CASE WHEN pj.status_pengumpulan_publikasi_jurnal = '4' THEN 1 ELSE 0 END +
            CASE WHEN apl.status_pengumpulan_aplikasi = '4' THEN 1 ELSE 0 END +
            CASE WHEN skripsi.status_pengumpulan_skripsi = '4' THEN 1 ELSE 0 END) AS terverifikasi,

        SUM(CASE WHEN da.status_pengumpulan_data_alumni = '3' THEN 1 ELSE 0 END +
            CASE WHEN skkm.status_pengumpulan_skkm = '3' THEN 1 ELSE 0 END +
            CASE WHEN fi.status_pengumpulan_foto_ijazah = '3' THEN 1 ELSE 0 END +
            CASE WHEN ukt.status_pengumpulan_ukt = '3' THEN 1 ELSE 0 END +
            CASE WHEN ph.status_pengumpulan_penyerahan_hardcopy = '3' THEN 1 ELSE 0 END +
            CASE WHEN tas.status_pengumpulan_tugas_akhir_softcopy = '3' THEN 1 ELSE 0 END +
            CASE WHEN bpbp.status_pengumpulan_bebas_pinjam_buku_perpustakaan = '3' THEN 1 ELSE 0 END +
            CASE WHEN hk.status_pengumpulan_hasil_kuisioner = '3' THEN 1 ELSE 0 END +
            CASE WHEN ps.status_pengumpulan_penyerahan_skripsi = '3' THEN 1 ELSE 0 END +
            CASE WHEN ppkl.status_pengumpulan_penyerahan_pkl = '3' THEN 1 ELSE 0 END +
            CASE WHEN toeic.status_pengumpulan_toeic = '3' THEN 1 ELSE 0 END +
            CASE WHEN bk.status_pengumpulan_bebas_kompen = '3' THEN 1 ELSE 0 END +
            CASE WHEN pkd.status_pengumpulan_penyerahan_kebenaran_data = '3' THEN 1 ELSE 0 END +
            CASE WHEN pj.status_pengumpulan_publikasi_jurnal = '3' THEN 1 ELSE 0 END +
            CASE WHEN apl.status_pengumpulan_aplikasi = '3' THEN 1 ELSE 0 END +
            CASE WHEN skripsi.status_pengumpulan_skripsi = '3' THEN 1 ELSE 0 END) AS belum_upload,

        SUM(CASE WHEN da.status_pengumpulan_data_alumni = '1' THEN 1 ELSE 0 END +
            CASE WHEN skkm.status_pengumpulan_skkm = '1' THEN 1 ELSE 0 END +
            CASE WHEN fi.status_pengumpulan_foto_ijazah = '1' THEN 1 ELSE 0 END +
            CASE WHEN ukt.status_pengumpulan_ukt = '1' THEN 1 ELSE 0 END +
            CASE WHEN ph.status_pengumpulan_penyerahan_hardcopy = '1' THEN 1 ELSE 0 END +
            CASE WHEN tas.status_pengumpulan_tugas_akhir_softcopy = '1' THEN 1 ELSE 0 END +
            CASE WHEN bpbp.status_pengumpulan_bebas_pinjam_buku_perpustakaan = '1' THEN 1 ELSE 0 END +
            CASE WHEN hk.status_pengumpulan_hasil_kuisioner = '1' THEN 1 ELSE 0 END +
            CASE WHEN ps.status_pengumpulan_penyerahan_skripsi = '1' THEN 1 ELSE 0 END +
            CASE WHEN ppkl.status_pengumpulan_penyerahan_pkl = '1' THEN 1 ELSE 0 END +
            CASE WHEN toeic.status_pengumpulan_toeic = '1' THEN 1 ELSE 0 END +
            CASE WHEN bk.status_pengumpulan_bebas_kompen = '1' THEN 1 ELSE 0 END +
            CASE WHEN pkd.status_pengumpulan_penyerahan_kebenaran_data = '1' THEN 1 ELSE 0 END +
            CASE WHEN pj.status_pengumpulan_publikasi_jurnal = '1' THEN 1 ELSE 0 END +
            CASE WHEN apl.status_pengumpulan_aplikasi = '1' THEN 1 ELSE 0 END +
            CASE WHEN skripsi.status_pengumpulan_skripsi = '1' THEN 1 ELSE 0 END) AS pending,

        SUM(CASE WHEN da.status_pengumpulan_data_alumni = '2' THEN 1 ELSE 0 END +
            CASE WHEN skkm.status_pengumpulan_skkm = '2' THEN 1 ELSE 0 END +
            CASE WHEN fi.status_pengumpulan_foto_ijazah = '2' THEN 1 ELSE 0 END +
            CASE WHEN ukt.status_pengumpulan_ukt = '2' THEN 1 ELSE 0 END +
            CASE WHEN ph.status_pengumpulan_penyerahan_hardcopy = '2' THEN 1 ELSE 0 END +
            CASE WHEN tas.status_pengumpulan_tugas_akhir_softcopy = '2' THEN 1 ELSE 0 END +
            CASE WHEN bpbp.status_pengumpulan_bebas_pinjam_buku_perpustakaan = '2' THEN 1 ELSE 0 END +
            CASE WHEN hk.status_pengumpulan_hasil_kuisioner = '2' THEN 1 ELSE 0 END +
            CASE WHEN ps.status_pengumpulan_penyerahan_skripsi = '2' THEN 1 ELSE 0 END +
            CASE WHEN ppkl.status_pengumpulan_penyerahan_pkl = '2' THEN 1 ELSE 0 END +
            CASE WHEN toeic.status_pengumpulan_toeic = '2' THEN 1 ELSE 0 END +
            CASE WHEN bk.status_pengumpulan_bebas_kompen = '2' THEN 1 ELSE 0 END +
            CASE WHEN pkd.status_pengumpulan_penyerahan_kebenaran_data = '2' THEN 1 ELSE 0 END +
            CASE WHEN pj.status_pengumpulan_publikasi_jurnal = '2' THEN 1 ELSE 0 END +
            CASE WHEN apl.status_pengumpulan_aplikasi = '2' THEN 1 ELSE 0 END +
            CASE WHEN skripsi.status_pengumpulan_skripsi = '2' THEN 1 ELSE 0 END) AS ditolak
    FROM mahasiswa m
    LEFT JOIN data_alumni da ON m.nim = da.nim
    LEFT JOIN skkm ON m.nim = skkm.nim
    LEFT JOIN foto_ijazah fi ON m.nim = fi.nim
    LEFT JOIN ukt ON m.nim = ukt.nim
    LEFT JOIN penyerahan_hardcopy ph ON m.nim = ph.nim
    LEFT JOIN tugas_akhir_softcopy tas ON m.nim = tas.nim
    LEFT JOIN bebas_pinjam_buku_perpustakaan bpbp ON m.nim = bpbp.nim
    LEFT JOIN hasil_kuisioner hk ON m.nim = hk.nim
    LEFT JOIN penyerahan_skripsi ps ON m.nim = ps.nim
    LEFT JOIN penyerahan_pkl ppkl ON m.nim = ppkl.nim
    LEFT JOIN toeic ON m.nim = toeic.nim
    LEFT JOIN bebas_kompen bk ON m.nim = bk.nim
    LEFT JOIN penyerahan_kebenaran_data pkd ON m.nim = pkd.nim
    LEFT JOIN publikasi_jurnal pj ON m.nim = pj.nim
    LEFT JOIN aplikasi apl ON m.nim = apl.nim
    LEFT JOIN skripsi ON m.nim = skripsi.nim
    WHERE m.nim = ?
";

// Prepare statement
$params = array($nim);
$stmt = sqlsrv_query($conn, $query, $params);

// Check for query failure
if ($stmt === false) {
    echo json_encode(["error" => "Query failed", "details" => sqlsrv_errors()]);
    exit;
}

// Fetch the result
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

// Return the result as JSON
echo json_encode([
    "terverifikasi" => $row['terverifikasi'],
    "belum_upload" => $row['belum_upload'],
    "pending" => $row['pending'],
    "ditolak" => $row['ditolak']
]);

// Close the connection
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>