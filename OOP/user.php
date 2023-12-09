<?php

// user.php

class User
{
    private $koneksi;

    public function __construct($koneksi)
    {
        $this->koneksi = $koneksi;
    }

    public function getAllUsers()
    {
        $result = mysqli_query($this->koneksi, "SELECT * FROM user");

        $users = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $users[] = $row;
            }
        } else {
            echo "Error: " . mysqli_error($this->koneksi);
        }

        return $users;
    }

    // Add more methods as needed, e.g., addUser, editUser, deleteUser, etc.
}

?>
