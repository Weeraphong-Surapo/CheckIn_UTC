<?php
// เรียกใช้งานคลาส DB และ Controller
require_once('../../Controller/StudentController.php');
require_once('function/head.php');
$DB = new DB_STUDENT;
if (!isset($_SESSION['login']) && isset($_SESSION['Student_id'])) {
    header('Location: index.php');
}
if(!isset($_SESSION))
{
session_start();
}
if (!isset($_SESSION['login']) || $_SESSION['Student_id'] == "") {
    header("Location: student_login.php");
}
$query = $DB->conn->query("SELECT * FROM tb_announce WHERE status = 1 AND Teacher_id = '$_SESSION[Teacher_id]'");
$result = $query->fetch_array();
if($query->num_rows > 0){
    $head = $result['head'];
    $announce = $result['description'];
}

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

<?php require_once('function/nav.php'); ?>

<div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h2 class="alert alert-primary"><i class='bx bxs-megaphone'></i> ประกาศจากอาจารย์</h2>
                        <div class="row">
                            <div class="col-lg-8 col-12 mb-2">
                                <b>เรื่อง </b><span><?= isset($head) ? $head : "ยังไม่มีประกาศ"; ?></span>
                            </div>
                            <div class="col-12 col-lg-4 mb-2">
                                <span>วันที่ <?= date('d') . ' เดือน ' . $month . ' ปี ' . date('Y') ?></span><br>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <b>รายละเอียด : </b>
                                <span><?= isset($announce) ? $announce : 'ยังไม่มีประกาศจากอาจารย์'; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../assets/js/swal.js"></script>
</body>

</html>