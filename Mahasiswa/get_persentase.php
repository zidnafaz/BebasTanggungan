<?php
header('Content-Type: application/json');

include '../koneksi.php';

$nim = $_COOKIE['id'];

$query = "
    SELECT 
        SUM(CASE WHEN da.status_pengumpulan_data_alumni = 'terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN skkm.status_pengumpulan_skkm = 'terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN fi.status_pengumpulan_foto_ijazah = 'terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN ukt.status_pengumpulan_ukt = 'terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN ph.status_pengumpulan_penyerahan_hardcopy = 'terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN tas.status_pengumpulan_tugas_akhir_softcopy = 'terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN bpbp.status_pengumpulan_bebas_pinjam_buku_perpustakaan = 'terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN hk.status_pengumpulan_hasil_kuisioner = 'terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN ps.status_pengumpulan_penyerahan_skripsi = 'terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN ppkl.status_pengumpulan_penyerahan_pkl = 'terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN toeic.status_pengumpulan_toeic = 'terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN bk.status_pengumpulan_bebas_kompen = 'terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN pkd.status_pengumpulan_penyerahan_kebenaran_data = 'terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN pj.status_pengumpulan_publikasi_jurnal = 'terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN apl.status_pengumpulan_aplikasi = 'terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN skripsi.status_pengumpulan_skripsi = 'terkonfirmasi' THEN 1 ELSE 0 END) AS terkonfirmasi,

        SUM(CASE WHEN da.status_pengumpulan_data_alumni = 'belum upload' THEN 1 ELSE 0 END +
            CASE WHEN skkm.status_pengumpulan_skkm = 'belum upload' THEN 1 ELSE 0 END +
            CASE WHEN fi.status_pengumpulan_foto_ijazah = 'belum upload' THEN 1 ELSE 0 END +
            CASE WHEN ukt.status_pengumpulan_ukt = 'belum upload' THEN 1 ELSE 0 END +
            CASE WHEN ph.status_pengumpulan_penyerahan_hardcopy = 'belum upload' THEN 1 ELSE 0 END +
            CASE WHEN tas.status_pengumpulan_tugas_akhir_softcopy = 'belum upload' THEN 1 ELSE 0 END +
            CASE WHEN bpbp.status_pengumpulan_bebas_pinjam_buku_perpustakaan = 'belum upload' THEN 1 ELSE 0 END +
            CASE WHEN hk.status_pengumpulan_hasil_kuisioner = 'belum upload' THEN 1 ELSE 0 END +
            CASE WHEN ps.status_pengumpulan_penyerahan_skripsi = 'belum upload' THEN 1 ELSE 0 END +
            CASE WHEN ppkl.status_pengumpulan_penyerahan_pkl = 'belum upload' THEN 1 ELSE 0 END +
            CASE WHEN toeic.status_pengumpulan_toeic = 'belum upload' THEN 1 ELSE 0 END +
            CASE WHEN bk.status_pengumpulan_bebas_kompen = 'belum upload' THEN 1 ELSE 0 END +
            CASE WHEN pkd.status_pengumpulan_penyerahan_kebenaran_data = 'belum upload' THEN 1 ELSE 0 END +
            CASE WHEN pj.status_pengumpulan_publikasi_jurnal = 'belum upload' THEN 1 ELSE 0 END +
            CASE WHEN apl.status_pengumpulan_aplikasi = 'belum upload' THEN 1 ELSE 0 END +
            CASE WHEN skripsi.status_pengumpulan_skripsi = 'belum upload' THEN 1 ELSE 0 END) AS belum_upload,

        SUM(CASE WHEN da.status_pengumpulan_data_alumni = 'pending' THEN 1 ELSE 0 END +
            CASE WHEN skkm.status_pengumpulan_skkm = 'pending' THEN 1 ELSE 0 END +
            CASE WHEN fi.status_pengumpulan_foto_ijazah = 'pending' THEN 1 ELSE 0 END +
            CASE WHEN ukt.status_pengumpulan_ukt = 'pending' THEN 1 ELSE 0 END +
            CASE WHEN ph.status_pengumpulan_penyerahan_hardcopy = 'pending' THEN 1 ELSE 0 END +
            CASE WHEN tas.status_pengumpulan_tugas_akhir_softcopy = 'pending' THEN 1 ELSE 0 END +
            CASE WHEN bpbp.status_pengumpulan_bebas_pinjam_buku_perpustakaan = 'pending' THEN 1 ELSE 0 END +
            CASE WHEN hk.status_pengumpulan_hasil_kuisioner = 'pending' THEN 1 ELSE 0 END +
            CASE WHEN ps.status_pengumpulan_penyerahan_skripsi = 'pending' THEN 1 ELSE 0 END +
            CASE WHEN ppkl.status_pengumpulan_penyerahan_pkl = 'pending' THEN 1 ELSE 0 END +
            CASE WHEN toeic.status_pengumpulan_toeic = 'pending' THEN 1 ELSE 0 END +
            CASE WHEN bk.status_pengumpulan_bebas_kompen = 'pending' THEN 1 ELSE 0 END +
            CASE WHEN pkd.status_pengumpulan_penyerahan_kebenaran_data = 'pending' THEN 1 ELSE 0 END +
            CASE WHEN pj.status_pengumpulan_publikasi_jurnal = 'pending' THEN 1 ELSE 0 END +
            CASE WHEN apl.status_pengumpulan_aplikasi = 'pending' THEN 1 ELSE 0 END +
            CASE WHEN skripsi.status_pengumpulan_skripsi = 'pending' THEN 1 ELSE 0 END) AS pending,

        SUM(CASE WHEN da.status_pengumpulan_data_alumni = 'tidak terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN skkm.status_pengumpulan_skkm = 'tidak terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN fi.status_pengumpulan_foto_ijazah = 'tidak terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN ukt.status_pengumpulan_ukt = 'tidak terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN ph.status_pengumpulan_penyerahan_hardcopy = 'tidak terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN tas.status_pengumpulan_tugas_akhir_softcopy = 'tidak terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN bpbp.status_pengumpulan_bebas_pinjam_buku_perpustakaan = 'tidak terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN hk.status_pengumpulan_hasil_kuisioner = 'tidak terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN ps.status_pengumpulan_penyerahan_skripsi = 'tidak terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN ppkl.status_pengumpulan_penyerahan_pkl = 'tidak terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN toeic.status_pengumpulan_toeic = 'tidak terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN bk.status_pengumpulan_bebas_kompen = 'tidak terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN pkd.status_pengumpulan_penyerahan_kebenaran_data = 'tidak terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN pj.status_pengumpulan_publikasi_jurnal = 'tidak terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN apl.status_pengumpulan_aplikasi = 'tidak terkonfirmasi' THEN 1 ELSE 0 END +
            CASE WHEN skripsi.status_pengumpulan_skripsi = 'tidak terkonfirmasi' THEN 1 ELSE 0 END) AS tidak_terkonfirmasi
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
    "terkonfirmasi" => $row['terkonfirmasi'],
    "belum_upload" => $row['belum_upload'],
    "pending" => $row['pending'],
    "tidak_terkonfirmasi" => $row['tidak_terkonfirmasi']
]);

// Close the connection
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
