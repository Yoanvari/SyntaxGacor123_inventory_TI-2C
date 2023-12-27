<?php

function antiinjection($koneksi, $data)
{
    $koneksi = new DatabaseConnection();
    $filter_sql = mysqli_real_escape_string($koneksi->getConnection(), stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
    return $filter_sql;
}
