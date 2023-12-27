<?php
class User
{
    public $id;
    public $nama_lengkap;
    public $email;
    public $username;
    public $password;
    public $alamat;
    public $jabatan;
    public $level;
    public $status;

    public function __construct($id, $nama_lengkap, $email, $username, $password,$alamat,$jabatan, $level,$status)
    {
        $this->id = $id;
        $this->nama_lengkap = $nama_lengkap;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->alamat = $alamat;
        $this->jabatan = $jabatan;
        $this->level = $level;
        $this->status = $status;
    }

    public function gantiPassword()
    {
        // TODO: Implementasi fungsi ganti password
    }

    public function pinjamBarang()
    {
        // TODO: Implementasi fungsi pinjam barang
    }

    public function gantiProfile()
    {
        // TODO: Implementasi fungsi ganti profile
    }

    public function kembalikan()
    {
        // TODO: Implementasi fungsi kembalikan barang
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNamaLengkap()
    {
        return $this->nama_lengkap;
    }

    public function setNamaLengkap($nama_lengkap)
    {
        $this->nama_lengkap = $nama_lengkap;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getAlamat()
    {
        return $this->alamat;
    }

    public function setAlamat($alamat)
    {
        $this->alamat = $alamat;
    }

    public function getJabatan()
    {
        return $this->jabatan;
    }

    public function setJabatan($jabatan)
    {
        $this->jabatan = $jabatan;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
}
?>
