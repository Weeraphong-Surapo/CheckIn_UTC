<?php
// เรียกใช้งาน DB และ Controller
require_once('../../Controller/AdminController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB_Admin;
?>

<div class="container">
    <div class="card p-3 shadow-sm">
        <div class="card-body">
            <h4 class="card-title">อาจารย์ทั้งหมดในระบบ</h4>
            <button class="float-end btn btn-insert" onclick="insertTeacher()"><i class='bx bx-plus'>เพิ่มอาจารย์</i></button>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table text-center p-0" id="example">
                    <thead>
                        <tr>
                            <th>ชื่ออาจารย์</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($DB->showTeacher() as $row) :
                            if ($row['type'] != 999) :
                        ?>
                                <tr>
                                    <td width="70%"><?= $row['title'] . " " . $row['Teacher_name']; ?></td>
                                    <td width="30%">
                                        <div class="btn-group">
                                            <button class="btn btn-success btn-fw" id="show-teacher" data-id="<?= $row['id']; ?>"><i class='bx bx-show' ></i></button>
                                            <button class="btn btn-warning btn-fw" id="edit-teacher" data-id="<?= $row['id']; ?>"><i class='bx bx-edit icon'></i></button>
                                            <button class="btn btn-danger btn-fw" id="del-teacher" data-name='<?= $row['Teacher_name']; ?>' data-id="<?php echo $row['id']; ?>"><i class='bx bx-task-x icon'></i></button>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            endif;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php require_once('function/modalTeacher.php'); ?>
<?php require_once('function/footer.php'); ?>
<script src="../assets/js/teacher.js"></script>