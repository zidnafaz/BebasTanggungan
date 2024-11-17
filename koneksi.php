<?php
    $host = "FAZA\MSSQLSERVERFAZA";
    $connInfo = array("Database" => "Bebas_Tanggungan", "UID" => "", "PWD" => "");
    $conn = sqlsrv_connect($host, $connInfo);

    if ($conn) {
        echo "Koneksi berhasil";
    } else {
        echo "Koneksi gagal";
        die(print_r(sqlsrv_errors(), true));
    }

?>