<?php 
include '../../koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nim'])) {
    $nim = $_POST['nim'];
    $status = $_POST['status'];

    $sql = "UPDATE dbo.bebas_pinjam_buku_perpustakaan SET status_pengumpulan_bebas_pinjam_buku_perpustakaan = ? WHERE NIM = ?";
    $params = array($status, $nim);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        // Redirect ke index.php dengan pesan error
        header(header: "Location: ../bebas_pinjaman.php?message=Terjadi+kesalahan+saat+memperbarui+data&type=danger");
    } else {
        // Redirect ke index.php dengan pesan sukses
        header("Location: ../bebas_pinjaman.php?message=Status+berhasil+diperbarui!&type=success");
    if ($status === 'terkonfirmasi'){
        $sqlConfirm ="UPDATE dbo.bebas_pinjam_buku_perpustakaan SET keterangan_pengumpulan_bebas_pinjam_buku_perpustakaan = 'Bebas Pinjaman' WHERE NIM = ?";
        $paramsConfirm = array($nim);
        $stmtConfirm = sqlsrv_query($conn, $sqlConfirm,$paramsConfirm);
    }
    //else if($status === 'tidak terkonfirmasi'){

    // }
    }
    exit();
} else {
    // Redirect ke index.php dengan pesan error
    header("Location: ../bebas_pinjaman.php?message=Data+tidak+valid&type=danger");
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