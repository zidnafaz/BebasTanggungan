<?php 
include '../../koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nim'])) {
    $nim = $_POST['nim'];
    $status = $_POST['status'];

    $sql = "UPDATE dbo.tugas_akhir_softcopy SET status_pengumpulan_tugas_akhir_softcopy = ? WHERE NIM = ?";
    $params = array($status, $nim);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        // Redirect ke index.php dengan pesan error
        header(header: "Location: ../softcopy.php?message=Terjadi+kesalahan+saat+memperbarui+data&type=danger");
    } else {
        // Redirect ke index.php dengan pesan sukses
        header("Location: ../softcopy.php?message=Status+berhasil+diperbarui!&type=success");
    if ($status === 'terkonfirmasi'){
        $sqlConfirm ="UPDATE dbo.tugas_akhir_softcopy SET keterangan_pengumpulan_tugas_akhir_softcopy = 'Soft Copy Lengkap' WHERE NIM = ?";
        $paramsConfirm = array($nim);
        $stmtConfirm = sqlsrv_query($conn, $sqlConfirm,$paramsConfirm);
    }
    //else if($status === 'tidak terkonfirmasi'){

    // }
    }
    exit();
} else {
    // Redirect ke index.php dengan pesan error
    header("Location: ../softcopy.php?message=Data+tidak+valid&type=danger");
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