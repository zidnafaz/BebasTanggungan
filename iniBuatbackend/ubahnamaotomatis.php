<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Direktori tempat file akan disimpan
    $target_dir = "uploads/";
    
    // Ambil nama file asli
    $originalFileName = basename($_FILES["fileToUpload"]["name"]);
    
    // Dapatkan ekstensi file
    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    
    // Buat nama file baru (misalnya, menggunakan timestamp)
    $newFileName = 'NIM ijazah' . '.' . $fileExtension; // Menggunakan uniqid untuk nama unik
    
    // Tentukan path lengkap untuk menyimpan file
    $target_file = $target_dir . $newFileName;

    // Cek apakah file sudah ada
    if (file_exists($target_file)) {
        echo "Maaf, file sudah ada.";
        exit;
    }

    // Cek ukuran file (misalnya, maksimum 5MB)

    // Cek apakah file adalah gambar (opsional)
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check === false) {
        echo "Maaf, file yang diupload bukan gambar.";
        exit;
    }

    // Pindahkan file ke direktori tujuan
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "File " . htmlspecialchars($newFileName) . " telah diupload.";
    } else {
        echo "Maaf, terjadi kesalahan saat mengupload file.";
    }
} else {
    echo "Tidak ada file yang diupload.";
}
?>