<?php
require_once '../Koneksi.php';

class Mahasiswa{
    private $conn;

    public function getMahasiswaByNIM($nim) {
        
        $db = new Koneksi();
        $this->conn = $db->connect();

        $sql = "SELECT * FROM dbo.mahasiswa WHERE nim = ?";
        $params = array($nim);
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            throw new Exception("Kesalahan pada query: " . print_r(sqlsrv_errors(), true));
        }

        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC) ?? null;
    }
}
?>