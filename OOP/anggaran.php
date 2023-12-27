<?php
class anggaran extends Controller
{
    public function __construct($koneksi)
    {
        parent::__construct($koneksi->getConnection());
    }
    public function read()
    {
        $result = $this->connection->query("select * from anggaran");
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $row;
    }

    public function create($data)
    {
        $result = $this->connection->query("INSERT INTO anggaran (asal, tahun_pengadaan) VALUES ('" . $data['asal'] . "','" . $data['tahun_pengadaan'] . "')");
        return $result;
    }

    public function update($data)
    {
        $result = $this->connection->query("UPDATE anggaran SET asal = '" . $data['asal'] . "', tahun_pengadaan = '" . $data['tahun_pengadaan'] . "' WHERE idAnggaran = '" . $data['idAnggaran'] . "'");
        return $result;
    }

    public function delete($data)
    {
        $result = $this->connection->query("DELETE FROM anggaran WHERE idAnggaran = '" . $data['id'] . "'");
        return $result;
    }

}
