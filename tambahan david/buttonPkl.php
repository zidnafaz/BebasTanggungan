<?php 
include '../../koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nim'])) {
    $nim = $_POST['nim'];
    $status = $_POST['status'];

    $sql = "UPDATE dbo.penyerahan_pkl SET status_pengumpulan_penyerahan_pkl = ? WHERE NIM = ?";
    $params = array($status, $nim);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        // Redirect ke index.php dengan pesan error
        header(header: "Location: ../pkl.php?message=Terjadi+kesalahan+saat+memperbarui+data&type=danger");
    } else {
        // // Redirect ke index.php dengan pesan sukses
        // header("Location: ../pkl.php?message=Status+berhasil+diperbarui!&type=success");
    if ($status === 'terkonfirmasi'){
        $sqlConfirm ="UPDATE dbo.penyerahan_pkl SET keterangan_pengumpulan_penyerahan_pkl = 'laporan lengkap' WHERE NIM = ?";
        $paramsConfirm = array($nim);
        $stmtConfirm = sqlsrv_query($conn, $sqlConfirm,$paramsConfirm);
    }
    else if($status === 'tidak terkonfirmasi'){
        echo "<script>
                var reason = prompt('Anda memilih status \"Tidak Terkonfirmasi\". Silakan masukkan keterangan tambahan:');
                if (reason !== null && reason.trim() !== '') {
                    // Kirim ulang form dengan tambahan keterangan
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = ''; // Tetap di halaman ini
                    var reasonInput = document.createElement('input');
                    reasonInput.type = 'hidden';
                    reasonInput.name = 'reason';
                    reasonInput.value = reason;
                    form.appendChild(reasonInput);
                    document.body.appendChild(form);
                    form.submit();
                    
                } else {
                    alert('Anda harus memberikan keterangan untuk status \"Tidak Terkonfirmasi\".');
                    window.location.href = '../pkl.php';
                }
            </script>";
            exit();
    }
    if (isset($_POST['reason'])) {
        $reason = $_POST['reason'];
        $sqlReason = "UPDATE dbo.penyerahan_pkl SET keterangan_pengumpulan_penyerahan_pkl = ? WHERE NIM = ?";
        $paramsReason = array($reason, $nim);
        $stmtReason = sqlsrv_query($conn, $sqlReason, $paramsReason);
        if ($stmtReason === false) {
            // Redirect dengan pesan error
            header("Location: ../pkl.php?message=Gagal+menyimpan+keterangan&type=danger");
            exit();
        }
    }
    // Redirect dengan pesan sukses
    header("Location: ../pkl.php?message=Status+berhasil+diperbarui!&type=success");
    exit();
    }
} else {
    // Redirect ke index.php dengan pesan error
    header("Location: ../pkl.php?message=Data+tidak+valid&type=danger");
    exit();
}

?>