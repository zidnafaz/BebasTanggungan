<?php 
include 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nim'])) {
    $nim = $_POST['nim'];
    $status = $_POST['status'];

    $sql = "UPDATE dbo.penyerahan_pkl SET status_pengumpulan_penyerahan_pkl = ? WHERE NIM = ?";
    $params = array($status, $nim);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        // Redirect ke index.php dengan pesan error
        header(header: "Location: ../AdminPerpus/pkl.php?message=Terjadi+kesalahan+saat+memperbarui+data&type=danger");
    } else {
        // Redirect ke index.php dengan pesan sukses
        header("Location: ../AdminPerpus/pkl.php?message=Status+berhasil+diperbarui!&type=success");
    }
    exit();
} else {
    // Redirect ke index.php dengan pesan error
    header("Location: ../AdminPerpus/pkl.php?message=Data+tidak+valid&type=danger");
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