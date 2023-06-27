<?php
// เรียกใช้งานคลาส DB และ Controller
require_once('../../Controller/TeacherController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB;
$query = $DB->conn->query("SELECT * FROM tb_announce WHERE Teacher_id = '$_SESSION[Teacher_id]'");
?>
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5>ประกาศ</h5>
            <button class="btn btn-insert" onclick="insertAnnounce()">+ เพิ่มประกาศ</button>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>เรื่อง</th>
                            <th>รายละเอียด</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                        <?php
                        foreach ($query as $data) :
                        ?>
                    <tbody>
                        <tr>
                            <td><?= $data['head'] ?></td>
                            <td><?= $data['description'] ?></td>
                            <td width="5%">
                                <button class="btn btn-sm <?= $data['status'] == 0 ? 'btn-secondary' : 'btn-success'; ?>" onclick="toggleStatus(<?= $data['id'] ?>)"><?= $data['status'] == 0 ? 'ปิด' : 'เปิด'; ?></button>
                            </td>
                            <td width="13%">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-warning" onclick="editAnnounce(<?= $data['id'] ?>)"><i class='bx bx-edit icon'></i></button>
                                    <button class="btn btn-sm btn-danger" onclick="delAnnounce(<?= $data['id'] ?>)"><i class='bx bx-task-x icon'></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                <?php endforeach; ?>
                </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="ModalAnnounce" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="text-Announce"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formAnnounce">
                    <input type="hidden" name="idAnnounce" id="idAnnounce">
                    <div class="mb-2">
                        <label for="">หัวข้อเรื่อง</label>
                        <input type="text" name="head" id="head" class="form-control" placeholder="เรื่อง">
                    </div>
                    <p id="errorHead"></p>
                    <div class="mb-2">
                        <label for="">รายละเอียด</label>
                        <textarea name="description" id="description" cols="30" rows="5" class="form-control" placeholder="รายละเอียด"></textarea>
                    </div>
                    <p id="errorDes"></p>
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
<script src="../assets/js/student.js"></script>