<?php
// เรียกใช้งาน DB และ Controller
require_once('../../Controller/TeacherController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB;
?>
<div class="container">
    <div class="card p-3">
        <div class="card-body">
            <h2>ประวัติการเช็คชื่อรายวัน</h2>
            <form action="" method="post" id="formFind">
                <input type="date" name="find_report" id="find_report" class="form-control mb-2">
            </form>
            <div class="table-responsive">
                <table class="table text-center">
                    <tr>
                        <th>เลขที่</th>
                        <th>รหัส</th>
                        <th>ชื่อ</th>
                        <th>สถานะ</th>
                    </tr>
                    <?php
                    if(isset($_POST['find_report'])){
                    $query = $DB->conn->query("SELECT * FROM tb_check_student WHERE check_date = '$_POST[find_report]' AND Teacher_id = '$_SESSION[Teacher_id]'");
                    if ($query->num_rows > 0) {
                        echo '<div class="alert alert-info p-2">วันที่ '.date_format(date_create($_POST['find_report']),'d/m/Y').'</div>';
                        $i =1;
                        foreach ($query as $row) {
                            $student = $DB->conn->query("SELECT * FROM tb_student WHERE id = '$row[Student_id]' AND Teacher_id = '$_SESSION[Teacher_id]'");
                            $data = $student->fetch_array();
                    ?>
                            <tbody id="result_find">
                                <tr>
                                    <td><?php echo $i++;?></td>
                                    <td><?php echo $data['Student_id']?></td>
                                    <td><?php echo $data['Student_name']?></td>
                                    <td>
                                    <div class="form-check">
                                            <label class="form-check-label color-check">
                                                <input class="checkbox checkin" type="checkbox" <?php echo $row['status'] == 1 ? 'checked' : ''; ?> data-id="<?= $row['Student_id']; ?>" date-id="<?php echo $row['check_date']?>">
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                    <?php }
                    } else {
                        echo '<div class="alert alert-info p-2">วันที่ '.date_format(date_create($_POST['find_report']),'d/m/Y').'</div>';
                        echo '<tr><td colspan="4">ไม่มีข้อมูล</td></tr>';
                    } 
                    }?>


                </table>
                <button id="btn-save" class="btn btn-primary float-end" style="display: none;">บันทึก</button>
            </div>
        </div>
    </div>
</div>



<?php require_once('function/footer.php'); ?>
<script src="../assets/js/report_day.js"></script>