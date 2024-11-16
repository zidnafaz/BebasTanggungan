<?php
if (isset($_POST["submit"])) {
    $targetdir = "uploads/";
    $targetfile = $targetdir . basename($_FILES["myfile"]["name"]);
    $fileType = strtolower(pathinfo($targetfile, PATHINFO_EXTENSION));

    // Daftar ekstensi yang diizinkan
    $allowedExtensions = array("txt", "pdf", "doc", "docx", "jpg", "jpeg", "png", "gif");
    $maxSize = 5 * 1024 * 1024; // 5 MB

    // Cek apakah ekstensi file diizinkan dan ukuran file valid
    if (in_array($fileType, $allowedExtensions) && $_FILES["myfile"]["size"] <= $maxSize) {
        // Pindahkan file ke direktori tujuan
        if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $targetfile)) {
            echo "File uploaded successfully";
            echo "<br>";

            // Cek apakah file yang diupload adalah gambar
            if (in_array($fileType, array("jpg", "jpeg", "png", "gif"))) {
                echo '<img width="200" src="' . $targetfile . '" alt="thumbnail">';
            } else {
                echo "File diupload bukan gambar, tidak ada thumbnail yang ditampilkan.";
            }
        } else {
            echo "Error uploading file";
        }
    } else {
        echo "Invalid file type or size";
    }
}
?>