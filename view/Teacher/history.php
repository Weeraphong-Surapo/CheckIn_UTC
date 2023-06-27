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
                    <h4 class="card-title mb-3">ประวัติการเช็คชื่อ</h4>
                </div>
                <!-- <div class="col-6" align="right">
                    <a href="function/MyReport.php" target="_blank" class="btn btn-primary">ดาวโหลด PDF</a>
                </div> -->
                <br><br>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>ปีการศึกษา</th>
                            <th>ภาคเรียน</th>
                            <th>ดาวโหลด</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <?php
                    $query_year_term = $DB->conn->query("SELECT * FROM tb_year_term_history WHERE Teacher_id = '$_SESSION[Teacher_id]' ORDER BY year ASC");
                    if($query_year_term->num_rows > 0){
                    foreach($query_year_term as $row):
                            ?>
                                <tbody>
                                    <tr>
                                        <td><?= $row['year']; ?></td>
                                        <td><?= $row['term']; ?></td>
                                        <td width="20%">
                                            <div class="btn-group">
                                                <a href="function/ReportHistory.php?id=<?php echo $row['id']?>" target="_blank" class="btn btn-outline-primary"><i class='bx bxs-printer' ></i> PDF</a>
                                                <a href="function/ExcelHistory.php?id=<?php echo $row['id']?>" target="_blank" class="btn btn-outline-success"><i class='bx bxs-file-export'></i> Excel</a>

                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" onclick="delHistory(<?= $row['id']?>,<?= $row['year']?>,<?= $row['term']?>)"><i class='bx bx-task-x icon'></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                    <?php endforeach; 
                    }else{
                        echo "<td colspan='4'>ยังไม่มีประวัติการเช็คชื่อ</td>";
                    }?>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">ยืนยันการลบข้อมูล</h1>
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


<?php require_once('function/footer.php'); ?>
<script src="../assets/js/student.js"></script>