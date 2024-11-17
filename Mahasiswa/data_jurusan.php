<?php
include '../koneksi.php';

if (isset($_COOKIE['nim'])) {
    $nim = $_COOKIE['nim'];
    $params = array($nim);

    $queries = [
        "penyerahan_skripsi" => "SELECT status_pengumpulan_penyerahan_skripsi, keterangan_pengumpulan_penyerahan_skripsi FROM penyerahan_skripsi WHERE nim = ?",
        "penyerahan_pkl" => "SELECT status_pengumpulan_penyerahan_pkl, keterangan_pengumpulan_penyerahan_pkl FROM penyerahan_pkl WHERE nim = ?",
        "toeic" => "SELECT status_pengumpulan_toeic, keterangan_pengumpulan_toeic FROM toeic WHERE nim = ?",
        "bebas_kompen" => "SELECT status_pengumpulan_bebas_kompen, keterangan_pengumpulan_bebas_kompen FROM bebas_kompen WHERE nim = ?",
        "kebenaran_data" => "SELECT status_pengumpulan_penyerahan_kebenaran_data, keterangan_pengumpulan_penyerahan_kebenaran_data FROM penyerahan_kebenaran_data WHERE nim = ?"
    ];

    $no = 1;
    foreach ($queries as $key => $query) {
        $stmt = sqlsrv_query($conn, $query, $params);
        if ($stmt && sqlsrv_has_rows($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$no}</td>
                        <td>" . ucfirst(str_replace('_', ' ', $key)) . "</td>
                        <td>{$row['status_pengumpulan_' . $key]}</td>
                        <td>{$row['keterangan_pengumpulan_' . $key]}</td>
                        <td>
                            <button class='btn btn-success btn-sm edit-data' data-pdf='document.pdf' data-toggle='modal' data-target='#uploadModal'>
                                <i class='fa fa-solid fa-cloud-arrow-up'></i> Upload
                            </button>
                        </td>
                    </tr>";
                $no++;
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data untuk " . ucfirst(str_replace('_', ' ', $key)) . ".</td></tr>";
        }
        sqlsrv_free_stmt($stmt);
    }
    sqlsrv_close($conn);
} else {
    echo "NIM belum diatur, silakan login terlebih dahulu.";
}

?>
