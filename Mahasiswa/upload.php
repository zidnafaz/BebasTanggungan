<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi ID dari cookie
    if (!isset($_COOKIE['id'])) {
        echo "ID tidak ditemukan dalam cookie.";
        exit;
    }

    $id = htmlspecialchars($_COOKIE['id']); // Amankan data dari cookie

    // Mendapatkan direktori dari input hidden
    $uploadDir = htmlspecialchars($_POST['uploadDir']);
    $uploadDir = rtrim($uploadDir, '/'); // Pastikan tidak ada trailing slash

    // Tentukan tabel berdasarkan direktori
    $tableMap = [
        'data_alumni' => 'data_alumni',
        'skkm' => 'skkm',
        'foto_ijazah' => 'foto_ijazah',
        'ukt' => 'ukt',
        'penyerahan_hardcopy' => 'penyerahan_hardcopy',
        'tugas_akhir_softcopy' => 'tugas_akhir_softcopy',
        'bebas_pinjam_buku_perpustakaan' => 'bebas_pinjam_buku_perpustakaan',
        'hasil_kuisioner' => 'hasil_kuisioner',
        'penyerahan_skripsi' => 'penyerahan_skripsi',
        'penyerahan_pkl' => 'penyerahan_pkl',
        'toeic' => 'toeic',
        'bebas_kompen' => 'bebas_kompen',
        'penyerahan_kebenaran_data' => 'penyerahan_kebenaran_data',
        'publikasi_jurnal' => 'publikasi_jurnal',
        'aplikasi' => 'aplikasi',
        'skripsi' => 'skripsi'
    ];


    $directoryLabel = basename($uploadDir);
    $tableName = isset($tableMap[$directoryLabel]) ? $tableMap[$directoryLabel] : null;

    if (!$tableName) {
        echo "Nama tabel tidak valid.";
        exit;
    }

    // Buat direktori jika belum ada
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Ambil nama file asli
    $originalFileName = basename($_FILES["file"]["name"]);

    // Dapatkan ekstensi file
    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

    // Buat nama file baru
    $newFileName = $id . '_' . $directoryLabel . '.' . $fileExtension;

    // Tentukan path lengkap untuk menyimpan file
    $target_file = $uploadDir . '/' . $newFileName;

    // Cek apakah file sudah ada
    if (file_exists($target_file)) {
        // Hapus file lama
        if (!unlink($target_file)) {
            echo "Gagal menghapus file lama.";
            exit;
        }
    }

    // Pindahkan file ke direktori tujuan
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
        
        // Query untuk memperbarui status
        $sql = "UPDATE {$tableName} 
        SET status_pengumpulan_{$directoryLabel} = 'pending', 
            keterangan_pengumpulan_{$directoryLabel} = 'Menunggu Proses Verifikasi' 
        WHERE nim = ?";
        $params = [$id];

        // Eksekusi query
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Redirect ke halaman dengan status sukses
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '?status=success');
    } else {
        // Redirect ke halaman dengan status error
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '?status=error');
    }
} else {
    echo "Tidak ada file yang diupload.";
}
?>