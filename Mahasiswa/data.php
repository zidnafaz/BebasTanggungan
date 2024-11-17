<?php
include '../koneksi.php';

// Memeriksa apakah cookie 'nim' sudah ada
if (isset($_COOKIE['nim'])) {
    // Mengambil nim dari cookie
    $nim = $_COOKIE['nim'];

    // Query untuk mengambil data dari tabel skripsi
    $query_skripsi = "SELECT status_pengumpulan_skripsi, keterangan_pengumpulan_skripsi FROM skripsi WHERE nim = ?";
    $params = array($nim);
    $stmt_skripsi = sqlsrv_query($conn, $query_skripsi, $params);

    // Query untuk mengambil data dari tabel aplikasi
    $query_aplikasi = "SELECT status_pengumpulan_aplikasi, keterangan_pengumpulan_aplikasi FROM aplikasi WHERE nim = ?";
    $stmt_aplikasi = sqlsrv_query($conn, $query_aplikasi, $params);

    // Query untuk mengambil data dari tabel publikasi_jurnal
    $query_publikasi_jurnal = "SELECT status_pengumpulan_publikasi_jurnal, keterangan_pengumpulan_publikasi_jurnal FROM publikasi_jurnal WHERE nim = ?";
    $stmt_publikasi_jurnal = sqlsrv_query($conn, $query_publikasi_jurnal, $params);

    if ($stmt_skripsi === false || $stmt_aplikasi === false || $stmt_publikasi_jurnal === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Inisialisasi nomor urut
    $no = 1;

    // Menampilkan data dari tabel skripsi
    while ($row_skripsi = sqlsrv_fetch_array($stmt_skripsi, SQLSRV_FETCH_ASSOC)) {
        echo "<tr>
                <td>{$no}</td>
                <td>Skripsi</td>
                <td>{$row_skripsi['status_pengumpulan_skripsi']}</td>
                <td>{$row_skripsi['keterangan_pengumpulan_skripsi']}</td>
                <td>
                    <button class='btn btn-success btn-sm edit-data' data-pdf='document.pdf' data-toggle='modal' data-target='#uploadModal'>
                        <i class='fa fa-solid fa-cloud-arrow-up'></i> Upload
                    </button>
                </td>
            </tr>";
        $no++;
    }

    // Menampilkan data dari tabel aplikasi
    while ($row_aplikasi = sqlsrv_fetch_array($stmt_aplikasi, SQLSRV_FETCH_ASSOC)) {
        echo "<tr>
                <td>{$no}</td>
                <td>Aplikasi</td>
                <td>{$row_aplikasi['status_pengumpulan_aplikasi']}</td>
                <td>{$row_aplikasi['keterangan_pengumpulan_aplikasi']}</td>
                <td>
                    <button class='btn btn-success btn-sm edit-data' data-pdf='document.pdf' data-toggle='modal' data-target='#uploadModal'>
                        <i class='fa fa-solid fa-cloud-arrow-up'></i> Upload
                    </button>
                </td>
            </tr>";
        $no++;
    }

    // Menampilkan data dari tabel publikasi_jurnal
    while ($row_publikasi_jurnal = sqlsrv_fetch_array($stmt_publikasi_jurnal, SQLSRV_FETCH_ASSOC)) {
        echo "<tr>
                <td>{$no}</td>
                <td>Publikasi Jurnal</td>
                <td>{$row_publikasi_jurnal['status_pengumpulan_publikasi_jurnal']}</td>
                <td>{$row_publikasi_jurnal['keterangan_pengumpulan_publikasi_jurnal']}</td>
                <td>
                    <button class='btn btn-success btn-sm edit-data' data-pdf='document.pdf' data-toggle='modal' data-target='#uploadModal'>
                        <i class='fa fa-solid fa-cloud-arrow-up'></i> Upload
                    </button>
                </td>
            </tr>";
        $no++;
    }

    echo "</tbody></table>";

    // Menutup statement
    sqlsrv_free_stmt($stmt_skripsi);
    sqlsrv_free_stmt($stmt_aplikasi);
    sqlsrv_free_stmt($stmt_publikasi_jurnal);
} else {
    echo "NIM belum diatur, silakan login terlebih dahulu.";
}

// Tutup koneksi
sqlsrv_close($conn);
?>
