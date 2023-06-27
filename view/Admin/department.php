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
        <h4 class="card-title">สาขางานทั้งหมด</h4>
                <button class="float-end btn btn-insert" onclick="insertDepartment()">เพิ่มสาขางาน</button>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table text-center p-0">
                        <thead>
                            <tr>
                                <th>สาขางาน</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($DB->showDepartment() as $row) :
                            ?>
                                <tr>
                                    <td width="70%"><?php echo $row['Department'] ?></td>
                                    <td width="30%">
                                        <div class="btn-group">
                                            <button class="btn btn-warning btn-fw" id="edit-department" data-id="<?= $row['id']; ?>"><i class='bx bx-edit icon'></i></button>
                                            <button class="btn btn-danger btn-fw" id="del-department" data-id="<?= $row['id'];?>" data-name="<?= $row['Department'];?>"><i class='bx bx-task-x icon'></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalDepartment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">สาขางาน</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_edit" id="id_edit">
                <div class="mb-1">
                    <input type="text" name="department" id="department" class="form-control" placeholder="สาขางาน">
                </div>
                <p style="color:red;" id="error"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" id="insertDepartment">บันทึก</button>
            </div>
        </div>
    </div>
</div>


<?php require_once('function/footer.php'); ?>
<script src="../assets/js/department.js"></script>