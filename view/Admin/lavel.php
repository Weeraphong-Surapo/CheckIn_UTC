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
        <h4 class="card-title">ระดับชั้นทั้งหมด</h4>
                <button class="float-end btn btn-insert btn-fw" onclick="insertlavel()"><i class='bx bx-plus'></i>เพิ่มระดับ</button>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table text-center p-0">
                        <thead>
                            <tr>
                                <th>ระดับชั้น</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($DB->showLavel() as $row) :
                            ?>
                                <tr>
                                    <td width="70%"><?= $row['lavel'] ?></td>
                                    <td width="30%">
                                        <div class="btn-group">
                                            <button class="btn btn-warning btn-fw" id="edit-lavel" data-id="<?php echo $row['id']; ?>"><i class='bx bxs-edit'></i></button>
                                            <button class="btn btn-danger btn-fw" id="del-lavel" data-id="<?php echo $row['id']; ?>"><i class='bx bx-task-x icon'></i></button>
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
<div class="modal fade" id="ModalLavel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">เพิ่มระดับชั้น</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formLavel">
                    <input type="hidden" name="id" id="id">
                    <div class="mb-2">
                        <label for="">ระดับชั้น</label>
                        <input type="text" name="lavel" id="lavel" class="form-control" placeholder="ระดับชั้น">
                        <p id="error-lavel"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" id="insertLavel">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once('function/footer.php'); ?>
<script src="../assets/js/lavel.js"></script>