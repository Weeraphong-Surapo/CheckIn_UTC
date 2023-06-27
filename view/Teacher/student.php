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
            <span class="fs-5 d-block mb-1">นักเรียนทั้งหมด</span>
            <select name="findroom" id="findroom" class="form-control w-25 float-start">
                <option value="" disabled selected>เลือกดูห้อง</option>
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
            <button class="btn btn-insert" onclick="insertStudent()"><i class='bx bx-user-plus'></i> เพิ่มนักเรียน</button>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table text-center" id="example">
                    <thead>
                        <tr>
                            <th>รหัส</th>
                            <th>ชื่อ - สกุล</th>
                            <th>จัดการ</th>
                        </tr>
                    <tbody>
                        
                        <?php 
                            if(isset($_GET['room'])){
                                $sql = "SELECT * FROM tb_student WHERE Room_ID = '$_GET[room]' AND Teacher_id = '$_SESSION[Teacher_id]'";
                            }else{
                                $sql = "SELECT * FROM tb_student WHERE Teacher_id = '$_SESSION[Teacher_id]'";
                            }
                            $result = $DB->conn->query($sql);
                        foreach ($result as $data) : 
                        ?>
                            <tr>
                                <td><?= $data['Student_id']; ?></td>
                                <td><?= $data['Student_name']; ?></td>
                                <td width="10%">
                                    <div class="btn-group" >
                                        <button class="btn btn-edit" data-id="<?php echo $data['id']; ?>"><i class='bx bx-edit icon'></i></button>
                                        <button class="btn btn-danger btn-del" data-id="<?= $data['id']; ?>" data-name="<?= $data['Student_name']; ?>" data-student-id="<?= $data['Student_id'] ?>"><i class='bx bx-task-x icon'></i></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="ModalStudent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="txt-modal">เพิ่มนักเรียน</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formStudent">
                    <input type="hidden" name="id-student" id="id-student">
                    <div class="mb-2">
                        <input type="text" name="student_id" id="student_id" class="form-control mb-1" placeholder="รหัสประจำตัวนักศึกษา">
                        <p id="error-student_id"></p>
                    </div>
                    <div class="mb-2">
                        <input type="text" name="student_name" id="student_name" class="form-control mb-1" placeholder="ชื่อ-สกุล นักศึกษา">
                        <p id="error-student_name"></p>
                    </div>
                    <div class="mb-2">
                        <input type="email" name="email" id="email" class="form-control mb-1" placeholder="อีเมลล์นักศึกษา">
                        <p id="error-email"></p>
                    </div>
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
                <button type="submit" class="btn btn-save">บันทึก</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php require_once('function/footer.php'); ?>
<script src="../assets/js/student.js"></script>