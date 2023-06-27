<?php
// เรียกใช้งาน DB และ Controller
require_once('../../Controller/AdminController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB_Admin;
$time = $DB->conn->query("SELECT * FROM tb_time");
$result_time = $time->fetch_array();
$open = $result_time['time_open'];
$close = $result_time['time_close'];
$id = $result_time['id'];
?>

<div class="container">
    <div class="card p-3 shadow-sm">
        <div class="card-body">
            <h2>เวลาที่เปิด และ ปิดสแกน</h2>
            <hr>
            <p class="text-danger">กรุณากรอกเวลาถูกต้อง เช่น 06:00 , 07:00 , 08:00 หรือ 06:30 , 06:15 เป็นต้น*</p>
            <div class="row">
                <div class="col-12 col-lg-6 col-md-12">
                    <h5 class="text-center">เปิด <?php echo $open; ?> น.</h5>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>เวลาเปิด</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $open; ?></td>
                                <td>
                                    <button class="btn btn-warning" onclick="editYear(<?= $id ?>)"><i class='bx bx-edit icon'></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 col-lg-6 col-md-12">
                    <h5 class="text-center">ปิด <?php echo $close; ?> น.</h5>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>เวลาปิด</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $close; ?></td>
                                <td>
                                    <button class="btn btn-warning" onclick="editTerm(<?= $id ?>)"><i class='bx bx-edit icon'></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalYear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="textYear"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="result">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary" id="submit">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<?php require_once('function/footer.php'); ?>
<script src="../assets/js/year.js"></script>