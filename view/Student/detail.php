<?php
// เรียกใช้งานคลาส DB และ Controller
require_once('../../Controller/StudentController.php');
require_once('function/head.php');
$DB = new DB_STUDENT;

$name = '';
$query = $DB->conn->query("SELECT * FROM tb_check_student WHERE Student_id = '$_SESSION[id]'");
$row = $query->fetch_array();

$query_count_check = $DB->conn->query("SELECT * FROM tb_check_student WHERE Student_id = '$_SESSION[id]' AND Teacher_id = '$_SESSION[Teacher_id]' AND status = 1");
$count_check = $query_count_check->num_rows;

$query_count_no_check = $DB->conn->query("SELECT * FROM tb_check_student WHERE Student_id = '$_SESSION[id]' AND Teacher_id = '$_SESSION[Teacher_id]' AND status = 0");
$count_no_check = $query_count_no_check->num_rows;

$query_teacher = $DB->conn->query("SELECT * FROM tb_teacher WHERE id = '$_SESSION[Teacher_id]'");
$row_teacher = $query_teacher->fetch_array();

$department = $DB->conn->query("SELECT * FROM tb_department WHERE id = '$row_teacher[Department]'");
$department_name = $department->fetch_array();

$lavel = $DB->conn->query("SELECT * FROM tb_lavel WHERE id = '$row_teacher[lavel]'");
$lavel_name = $lavel->fetch_array();


?>

<?php require_once('function/nav.php'); ?>

<div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <h4 class="bg-">สรุปผลเข้าแถว</h4>
                            </div>
                            <div class="col-2">
                                
                            </div>
                        </div>

                        <hr>
                        <div class="rounded">
                            <div class="row">
                                <div class="row">
                                    <div class="col-12 col-lg-3 ">
                                        <img src="../assets/<?= $row_teacher['image']; ?>" width="170" height="160" alt="" class="mb-2">
                                    </div>
                                    <div class="col-12 col-lg-9">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>อาจารย์ <i class='bx bxs-user-circle' ></i></td>
                                                <td><?php echo $row_teacher['title'] . " " . $row_teacher['Teacher_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>เบอร์โทร <i class='bx bxs-phone'></i></td>
                                                <td><?= $row_teacher['phone']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>สาขางาน <i class='bx bx-sitemap'></i></td>
                                                <td><?php echo $lavel_name['lavel'] . ' / ' . $department_name['Department']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    
                        </center>
                        <h3 class="text-center">
                            <hr>สรุปการเข้าแถว
                        </h3>

                        <div class="table-responsive">
                            <table class="table text-center">
                                <tr>
                                    <th>จำนวนเข้าแถว</th>
                                    <th>เข้าแถว</th>
                                    <th>ขาดแถว</th>
                                </tr>
                                <?php
                                if ($query->num_rows > 0) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['count_check']; ?></td>
                                        <td><?php echo $count_check; ?></td>
                                        <td><?php echo $count_no_check; ?></td>
                                    </tr>
                                <?php } else {
                                    echo '<tr><td colspan="4"><h4>ยังไม่มีประวัติการเข้าแถว</h4></td></tr>';
                                } ?>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once('function/footer.php'); ?>
<script src="../assets/js/nav.js"></script>
</body>

</html>