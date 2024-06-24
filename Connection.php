<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
class Connection{
    private $conn;
    public function __construct(){
        $this->conn = new mysqli("127.0.0.1", "root", "", "thb");
    }
    
    public function getConnection(){
        return $this->conn;
    }
}
?>