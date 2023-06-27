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
            <h4 class="card-title">จัดการปีการศึกษา / ภาคเรียน</h4>
            <p style="color:red;">จะมีผลต่อการแสดงผล PDF Excel แต่ละภาคเรียน *</p>
            <div class="row">
                <div class="col-12 col-lg-6 col-md-12">
                    <div class="table-responsive">
                        <table class="table text-center p-0">
                            <thead>
                                <tr>
                                    <th>ภาคเรียน</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = $DB->conn->query("SELECT * FROM tb_term");
                                foreach ($query as $row) :
                                ?>
                                    <tr>
                                        <td width="70%"><?= $row['term'] ?></td>
                                        <td width="30%">
                                            <div class="btn-group">
                                                <button class="btn btn-warning btn-fw" onclick="editTerm(<?php echo $row['id'] ?>)"><i class='bx bxs-edit'></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-md-12">
                    <table class="table text-center p-0">
                        <thead>
                            <tr>
                                <th>ปีการศึกษา</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query_term = $DB->conn->query("SELECT * FROM tb_school_year");
                            foreach ($query_term as $row) :
                            ?>
                                <tr>
                                    <td width="70%"><?= $row['school_year'] ?></td>
                                    <td width="30%">
                                        <div class="btn-group">
                                            <button class="btn btn-warning btn-fw" onclick="editYear(<?php echo $row['id']?>)"><i class='bx bxs-edit'></i></button>
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
</div>


<!-- Modal -->
<div class="modal fade" id="ModalEditTerm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">แก้ไขภาคเรียน</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="">ภาคเรียน :</label>
                <select name="term" id="term" class="form-control">
                    <option value="1">ภาคเรียนที่ 1</option>
                    <option value="2">ภาคเรียนที่ 2</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="saveTerm()">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalEditYear" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">แก้ไขปีการศึกษา</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label for="">ปีการศึกษา</label>
                    <input type="text" name="year" id="year" class="form-control">
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="saveYear()">บันทึก</button>
            </div>
        </div>
    </div>
</div>
<?php require_once('function/footer.php'); ?>
<script src="../assets/js/year_term.js"></script>