<?php
interface CRUD
{
    public function create($data);
    public function read();
    public function update($data);
    public function delete($data);

}

?>