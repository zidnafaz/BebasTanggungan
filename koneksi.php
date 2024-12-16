<?php
class Koneksi {
    private $host = "FAZA\MSSQLSERVERFAZA";
    private $dbName = "Bebas_Tanggungan";
    private $user = "";
    private $password = "";
    private $conn;

    public function connect() {
        if ($this->conn == null) {
            $connInfo = array("Database" => $this->dbName, "UID" => $this->user, "PWD" => $this->password);
            $this->conn = sqlsrv_connect($this->host, $connInfo);

            if (!$this->conn) {
                die("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
            }
        }
        return $this->conn;
    }

    public function close() {
        if ($this->conn) {
            sqlsrv_close($this->conn);
        }
    }
}
?>
