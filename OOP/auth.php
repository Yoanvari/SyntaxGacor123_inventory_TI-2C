<?php
class DatabaseConnection
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "tes";

    private $koneksi;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($conn->connect_errno) {
            die("Koneksi database gagal: " . $this->koneksi->connect_error);
        }
        $this->koneksi = $conn;
    }

    public function getConnection()
    {
        return $this->koneksi;
    }

    public function closeConnection()
    {
        $this->koneksi->close();
    }
}
