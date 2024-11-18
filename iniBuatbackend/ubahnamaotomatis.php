<?php
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
    
    // Buat direktori jika belum ada
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Ambil nama file asli
    $originalFileName = basename($_FILES["file"]["name"]);
    
    // Dapatkan ekstensi file
    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    
    // Ambil label dari nama direktori
    $directoryLabel = basename($uploadDir); // Bagian terakhir dari path direktori

    // Buat nama file baru
    $newFileName = $id . '_' . $directoryLabel . '.' . $fileExtension;

    // Tentukan path lengkap untuk menyimpan file
    $target_file = $uploadDir . '/' . $newFileName;

    // Cek apakah file sudah ada
    if (file_exists($target_file)) {
        echo "Maaf, file dengan nama yang sama sudah ada.";
        exit;
    }

    // Pindahkan file ke direktori tujuan
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
        echo "File berhasil diupload ke: $target_file";
    } else {
        echo "Terjadi kesalahan saat mengupload file.";
    }
} else {
    echo "Tidak ada file yang diupload.";
}
?>
