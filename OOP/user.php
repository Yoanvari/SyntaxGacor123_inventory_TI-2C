<?php
require_once 'Controller.php';
class User extends Controller
{
    public function __construct($koneksi)
    {
        parent::__construct($koneksi->getConnection());
    }
    public function read()
    {
        $result = $this->connection->query("select * from user");
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $row;
    }
    public function create($data)
    {
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $result = $this->connection->query("INSERT INTO user (nama_lengkap, email, username, password, alamat, jabatan, jenis_kelamin, level, status) 
                                  VALUES ('" . $data['nama_lengkap'] . "', '" . $data['email'] . "', '" . $data['username'] . "', '" . $password . "', '" . $data['alamat'] . "', '" . $data['jabatan'] . "', '" . $data['jenis_kelamin'] . "', '" . $data['level'] . "', '" . $data['status'] . "')");
        return $result;
    }

    public function update($data)
    {
        $result = $this->connection->query("UPDATE user SET 
        nama_lengkap = '{$data['nama_lengkap']}', 
        email = '{$data['email']}', 
        username = '{$data['username']}', 
        alamat = '{$data['alamat']}', 
        jenis_kelamin = '{$data['jenis_kelamin']}', 
        status = '{$data['status']}' 
        WHERE id = {$data['id']}");
        return $result;
    }
    public function isUserAdmin($userId)
    {
        $query = "SELECT level FROM user WHERE id = {$userId}";
        $result = $this->connection->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['level'] === 'admin';
        }

        return false;
    }

    public function delete($id)
    {
        $result = $this->connection->query("DELETE FROM user WHERE id = {$id}");
        return $result;
    }

}

?>