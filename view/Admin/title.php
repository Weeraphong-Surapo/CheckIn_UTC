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
           <h5>คำนำหน้า</h5>
           <button class="btn btn-insert" onclick="insertTitle()">เพิ่มคำนำหน้า</button>
            <div class="clearfix"></div>
           <div class="table-responsive">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>คำนำ</th>
                        <th>จัดการ</th>
                    </tr>
                    <tbody>
                        <?php 
                            foreach($DB->showTitle() as $data):
                        ?>
                        <tr>
                            <td><?= $data['title'];?></td>
                            <td width="25%">
                                <div class="btn-group">
                                    <button class="btn btn-edit" id="edit-title" data-id="<?= $data['id']; ?>"><i class='bx bx-edit icon'></i></button>
                                    <button class="btn btn-danger btn-del" id="del-title" data-name='<?= $data['title']; ?>' data-id="<?php echo $data['id']; ?>"><i class='bx bx-task-x icon'></i></button>
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
<div class="modal fade" id="ModalTitle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่มคำนำหน้า</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="formTitle">
            <input type="hidden" name="id_title" id="id_title">
            <input type="text" name="title" id="title" class="form-control mb-1" placeholder="กรอกคำนำหน้า">
            <p id="error-title"></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            <button type="submit" class="btn btn-primary">บันทึก</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once('function/footer.php'); ?>
<script src="../assets/js/title.js"></script>