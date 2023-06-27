<?php
if(!isset($_SESSION))
{
session_start();
}
if(!isset($_SESSION['Student_id'])){
  header("Location: ../Student/login.php");
}
require_once('../../Controller/StudentController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB_STUDENT;


$query = $DB->conn->query("SELECT * FROM tb_announce WHERE status = 1 AND Teacher_id = '$_SESSION[Teacher_id]'");
$result = $query->fetch_array();
if ($query->num_rows > 0) {
  $head = $result['head'];
  $announce = $result['description'];
}

$teacher = $DB->conn->query("SELECT * FROM tb_teacher WHERE id = '$_SESSION[Teacher_id]'");
$row  = $teacher->fetch_array();
$depart = $DB->conn->query("SELECT * FROM tb_department WHERE id = '$row[Department]'");
$row_depart = $depart->fetch_array();
$department = $row_depart['Department']; 

$months = array(
  1 => "มกราคม",
  2 => "กุมภาพันธ์",
  3 => "มีนาคม",
  4 => "เมษายน",
  5 => "พฤษภาคม",
  6 => "มิถุนายน",
  7 => "กรกฎาคม",
  8 => "สิงหาคม",
  9 => "กันยายน",
  10 => "ตุลาคม",
  11 => "พฤศจิกายน",
  12 => "ธันวาคม"
);
$date = date('d-m-y');
foreach ($months as $k => $v) {
  if (date('m') == $k) {
    $month =  $v;
  }
}

?>

<div class="container mt-4">
  <div class="row">
    <div class="col-lg-7 col-12 col-md-12 mb-4">
      <div class="card">
        <div class="card-header bg-success text-white">
        <i class='bx bx-volume-full'></i> ประกาศจากที่ปรึกษา
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-lg-4 mb-2">
              <h5>เรื่อง : <?= isset($head) ? $head : "ยังไม่มีประกาศ"; ?></h5>
            </div>
            <div class="col-12 col-lg-8 mb-2 ">
              <span class="float-lg-end">วันที่ <?= date('d') . ' เดือน ' . $month . ' ปี ' . date('Y')+543 ?></span><br>
            </div>
          </div>
          <span class="text-muted"><?= isset($announce) ? $announce : 'ยังไม่มีประกาศจากอาจารย์'; ?></span>
        </div>
      </div>
    </div>
    <div class="col-lg-5 col-12 col-md-12">
      <div class="card">
        <div class="card-header bg-primary text-white">
        <i class='bx bxs-briefcase' style="font-size: 15px;"></i> ยินดีต้อนรับเข้าสู่ระบบสำหรับนักศึกษา
        </div>
        <div class="card-body">
          <div class="row text-muted">
            <div class="col-6 mb-2">
              <span>สถานศึกษา</span>
            </div>
            <div class="col-6 mb-2">
              <span>วิทยาลัยเทคนิคอุบลราชธานี</span>
            </div>
            <div class="col-6 mb-2">
              <span>รหัสประจำตัว</span>
            </div>
            <div class="col-6 mb-2">
              <span><?php echo $_SESSION['Student_id'];?></span>
            </div>
            <div class="col-6 mb-2">
              <span>ชื่อ - สกุล</span>
            </div>
            <div class="col-6 mb-2">
              <span><?php echo $_SESSION['Student_name'];?></span>
            </div>
            <div class="col-6 mb-2">
              <span>กลุ่มเรียน</span>
            </div>
            <div class="col-6 mb-2">
              <span><?php echo $department;?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once('function/footer.php'); ?>
<script src="../assets/js/nav.js"></script>