<?php 
class DB_CONNECT{
  // Properties
  public $conn;

  // เชื่อมต่อฐานข้อมูล
  function __construct()
  {
    $this->conn = new mysqli('localhost', 'root', 'root', 'Checkin_Qrcode'); 
    $this->conn->set_charset("utf8");
    date_default_timezone_set('Asia/bangkok');
  }
}
?>