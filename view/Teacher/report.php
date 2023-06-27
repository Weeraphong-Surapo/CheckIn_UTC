<?php
// เรียกใช้งานคลาส DB และ Controller
require_once('../../Controller/TeacherController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB;
?>

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <h4 class="card-title mb-3">สรุปการเข้าแถว</h4>
                </div>
                <div class="col-6" align="right">
                    <a onclick="selectStudent()" class="btn btn-primary"><i class='bx bxs-printer'></i> PDF</a>
                    <button class="btn btn-success" onclick="resetStudent()"><i class='bx bxs-folder-open'></i> จบเทอม</button>
                    <button class="btn btn-danger del_check_student"><i class='bx bxs-trash'></i> ลบข้อมูล</button>
                </div>
                <br><br>
            </div>
            <div class="table-responsive">
                <table class="table text-center" id="example">
                    <thead>
                        <tr>
                            <th>รหัส</th>
                            <th class="name">ชื่อ</th>
                            <th>จำนวน</th>
                            <th>เข้า</th>
                            <th>ขาด</th>
                            <th>เป็น %</th>
                            <th>เตือน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM tb_student WHERE Teacher_id = '$_SESSION[Teacher_id]' ORDER BY Student_id ASC";
                        $result = $DB->conn->query($sql);
                        $count = 0;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_array()) :
                                $query_count = $DB->conn->query("SELECT * FROM tb_check_student WHERE Teacher_id = '$_SESSION[Teacher_id]'");
                                $query_count_check = $DB->conn->query("SELECT * FROM tb_check_student WHERE Student_id = '$row[id]' AND status = 1 AND Teacher_id = '$_SESSION[Teacher_id]'");
                                $count_check = $query_count_check->num_rows;
                                $query_count_no_check = $DB->conn->query("SELECT * FROM tb_check_student WHERE Student_id = '$row[id]' AND status = 0 AND Teacher_id = '$_SESSION[Teacher_id]'");
                                $count_no_check = $query_count_no_check->num_rows;
                                $check = $DB->conn->query("SELECT * FROM tb_check_student WHERE Student_id = '$row[id]' AND Teacher_id = '$_SESSION[Teacher_id]'");
                                if ($check->num_rows > 0) {
                                    $r_count = $query_count->fetch_array();
                                    $count = $r_count['count_check'];
                                }
                                if ($check->num_rows <= 0) {
                                    $count_no_check = $count;
                                } else {
                                    $count_no_check = $count - $count_check;
                                }
                                if ($query_count->num_rows >= 1) {
                                    $process = $count_check * 100 / $count;
                                    $percent = number_format($process, 2, '.', '');
                                }
                        ?>
                                <tr>
                                    <td width="25%"><?= $row['Student_id']; ?></td>
                                    <td width="25%" class="name"><?= $row['Student_name']; ?></td>
                                    <td width="10%"><?php echo $count; ?></td>
                                    <td width="10%"><?php echo $count_check; ?></td>
                                    <td width="10%"><?php echo $count_no_check; ?></td>
                                    <?php
                                    if (isset($percent)) {
                                        echo '<td width="10%">' . $percent . '%</td>';
                                    } else {
                                        echo '<td width="10%">0 %</td>';
                                    }
                                    ?>
                                    <td width="10%">
                                        <button class="btn btn-warning btn-fw" id="warn" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['Student_name']; ?>">เตือน</button>
                                    </td>
                                </tr>
                        <?php endwhile;
                        } ?>
                    </tbody>
                </table>
            </div>
            <br>
        </div>
    </div>
</div>

<div id="indicator" style="display:none;">
    <h3><img src="../assets/images/gmail.gif" class="img-fluid" alt=""></h3>กำลังแจ้งเตือนทาง Gmail...
</div>


<!-- Modal -->
<div class="modal fade" id="ModalConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">ยืนยันการบันทึกข้อมูล</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label for="">รหัสผ่าน : </label>
                    <input type="password" name="cPass" id="cPass" class="form-control" placeholder="รหัสผ่านของคุณ">
                </div>
                <p id="error-pass"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" id="submitReport">บันทึก</button>
            </div>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="modalSelectStudent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">เลือกกลุ่ม รายงานผล</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <select name="room" id="room" class="form-control">
                        
                        <?php
                        $sql = "SELECT * FROM tb_room WHERE Room_ID = '$_SESSION[room1]'";
                        $query1 = $DB->conn->query($sql);
                        $r_1 = $query1->fetch_array();
                        if (!empty($_SESSION['room2'])) {
                            $sql = "SELECT * FROM tb_room WHERE Room_ID = '$_SESSION[room2]'";
                            $query2 = $DB->conn->query($sql);
                            $r_2 = $query2->fetch_array();
                        }
                        ?>
                        <option value="<?php echo $r_1['Room_ID'] ?>"><?php echo $r_1['room']; ?></option>
                        <?php if (!empty($_SESSION['room2'])) {
                            echo '<option value="' . $r_2['Room_ID'] . '">' . $r_2['room'] . '</option>';
                        } ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="reportSelect()">ออก PDF</button>
            </div>
        </div>
    </div>
</div>
<?php require_once('function/footer.php'); ?>
<script src="../assets/js/student.js"></script>
<script src="../assets/js/blockui.js"></script>