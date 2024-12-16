<?php
require_once '../Koneksi.php';

class Admin {
    private $conn;

    public function getAdminById($nim)
    {
        $db = new Koneksi();
        $this->conn = $db->connect();

        $sql = "SELECT id_karyawan, nama_karyawan, nomor_telfon_karyawan, alamat_karyawan, tanggal_lahir_karyawan, jenis_kelamin_karyawan 
                FROM dbo.admin a
                WHERE a.id_karyawan = ?";
        $params = array($nim);
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            throw new Exception("Kesalahan pada query: " . print_r(sqlsrv_errors(), true));
        }

        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC) ?? null;
    }
}
?>