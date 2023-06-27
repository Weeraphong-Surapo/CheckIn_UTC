<?php
// เรียกใช้งานคลาส DB และ Controller
require_once('../../Controller/TeacherController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB;
$query = $DB->conn->query("SELECT room1,room2 FROM tb_teacher WHERE id = '$_SESSION[Teacher_id]'");
$row = $query->fetch_array();
$room1 = !empty($row['room1']) ? $row['room1'] : 's';
$room2 = !empty($row['room2']) ? $row['room2'] : '';



$r_1 = $DB->conn->query("SELECT * FROM tb_room WHERE Room_ID = '$room1'");
$r_room1 = $r_1->fetch_array();

if (!empty($room2)) {
    $sql = "SELECT * FROM tb_room WHERE Room_ID = '$room2'";
    $query = $DB->conn->query($sql);
    $r = $query->fetch_array();
}
?>
<div class="container">
    <div class="card p-3">
        <div class="card-body">
            <span class="fs-5 d-block mb-1">เลือกชั้นเรียน</span>
            <div class="row">
                <div class="col-6 col-lg-6 col-md-6 mb-3">
                    <a href="c_student?c=<?php echo $room1;?>">
                        <div class="card shadow-sm card_c">
                            <div class="card-body">
                            <p class="text-center"><?php echo $r_room1['room'];?></p>
                            <center>
                                <i class='bx bxs-user-check' style="font-size: 20px; color:black;"></i>
                            </center>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
                if (!empty($room2)) :
                ?>
                    <div class="col-6 col-lg-6 col-md-6">
                        <a href="c_student?c=<?php echo $room2;?>">
                            <div class="card shadow-sm card_c">
                                <div class="card-body">
                                    <p class="text-center"><?php echo $r['room']?></p>
                                    <center>
                                <i class='bx bxs-user-check' style="font-size: 20px; color:black;"></i>
                            </center>
                                </div>
                            </div>
                    </div>
                    </a>
                <?php endif; ?>
                <!-- <div class="col-6 col-lg-6 col-md-6">
                        <a href="check">
                            <div class="card shadow-sm card_c">
                                <div class="card-body">
                                    <p class="text-center ">เช็คชื่อนักเรียต่างห้อง</p>
                                    <center>
                                <i class='bx bxs-user-check' style="font-size: 20px; color:black;"></i>
                            </center>
                                </div>
                            </div>
                    </div> -->
            </div>
        </div>
    </div>
</div>


<?php require_once('function/footer.php'); ?>