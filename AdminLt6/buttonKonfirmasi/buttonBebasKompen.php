<?php 
include '../../koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nim'])) {
    $nim = $_POST['nim'];
    $status = $_POST['status'];

    $sql = "UPDATE dbo.bebas_kompen SET status_pengumpulan_bebas_kompen = ? WHERE NIM = ?";
    $params = array($status, $nim);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        // Redirect ke index.php dengan pesan error
        header(header: "Location:../kompen.php?message=Terjadi+kesalahan+saat+memperbarui+data&type=danger");
    } else {
        // Redirect ke index.php dengan pesan sukses
        header("Location:../kompen.php?message=Status+berhasil+diperbarui!&type=success");
        if ($status === 'terkonfirmasi'){
            $sqlConfirm ="UPDATE dbo.bebas_kompen SET keterangan_pengumpulan_bebas_kompen = 'Bebas Kompen' WHERE NIM = ?";
            $paramsConfirm = array($nim);
            $stmtConfirm = sqlsrv_query($conn, $sqlConfirm,$paramsConfirm);
        }
    }

    exit();
} else {
    // Redirect ke index.php dengan pesan error
    header("Location:../kompen.php?message=Data+tidak+valid&type=danger");
    exit();
}
    // if ($stmt === false) {
    //     die(print_r(sqlsrv_errors(), true));
    // }else{
    //     echo "<script>
    //     alert('Status berhasil diperbarui!');
    //     window.location.href = '../AdminPerpus/pkl.php';
    //     </script>";
    //     exit();
    // }

    
//}
?>