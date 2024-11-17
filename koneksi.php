<?php
$host   = "FAZA\MSSQLSERVERFAZA"; // Ganti dengan nama server Anda
$connInfo = array(
    "Database" => "Bebas_Tanggungan", // Ganti dengan nama database Anda
    "UID" => "", // Ganti dengan username database Anda
    "PWD" => "" // Ganti dengan password database Anda
);
$conn = sqlsrv_connect($host, $connInfo);

if ($conn) {      
    // Koneksi berhasil
} else {     
    echo "Koneksi Gagal";      
    die(print_r(sqlsrv_errors(), true)); 
} 
?>