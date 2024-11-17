<?php
include '../koneksi.php';

// Memeriksa apakah cookie 'nim' sudah ada
if (isset($_COOKIE['nim'])) {
    // Mengambil nim dari cookie
    $nim = $_COOKIE['nim'];

    // Query untuk mengambil data berdasarkan nim
    $query = "SELECT status_pengumpulan_data_alumni, keterangan_pengumpulan_data_alumni FROM data_alumni WHERE nim = ?";
    $params = array($nim);
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Looping data
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['status_pengumpulan_data_alumni']}</td>
                <td>{$row['keterangan_pengumpulan_data_alumni']}</td>
                <td>
                    <button class='btn btn-success btn-sm edit-data' data-pdf='document.pdf' data-toggle='modal' data-target='#uploadModal'>
                        <i class='fa fa-solid fa-cloud-arrow-up'></i> Upload
                    </button>
                </td>
            </tr>";
    }

    echo "</tbody></table>";

    // Menutup statement
    sqlsrv_free_stmt($stmt);
} else {
    echo "NIM belum diatur, silakan login terlebih dahulu.";
}

// Tutup koneksi
sqlsrv_close($conn);
?>
