<?php
// เรียกใช้งาน DB และ Controller
require_once('../../Controller/AdminController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB_Admin;
$query_open_scan = $DB->conn->query("SELECT * FROM `tb_opn_scan`");
$row_open_scan = $query_open_scan->fetch_array();
$open = $row_open_scan['open'];
$close = $row_open_scan['close'];
$mont_open = explode("-", $open);
$y_open = $mont_open[0] + 543;
$r_mont_open = $mont_open[1];
$d_open = $mont_open[2];
$show_mont_open = "";


$mont_close = explode("-", $close);
$y_close = $mont_close[0] + 543;
$r_mont_close = $mont_close[1];
$d_close = $mont_close[2];
$show_mont_close = "";

switch ($r_mont_open) {
    case "01":
        $show_mont_open = "มกราคม";
        break;
    case "02":
        $show_mont_open = "กุมภาพันธ์";
        break;
    case "03":
        $show_mont_open = "มีนาคม";
        break;
    case "04":
        $show_mont_open = "เมษายน";
        break;
    case "05":
        $show_mont_open = "พฤษภาคม";
        break;
    case "06":
        $show_mont_open = "มิถุนายน";
        break;
    case "07":
        $show_mont_open = "กรกฎาคม";
        break;
    case "08":
        $show_mont_open = "สิงหาคม";
        break;
    case "09":
        $show_mont_open = "กันยายน";
        break;
    case "10":
        $show_mont_open = "ตุลาคม";
        break;
    case "11":
        $show_mont_open = "พฤศจิกายน";
        break;
    case "12":
        $show_mont_open = "ธันวาคม";
        break;
}

switch ($r_mont_close) {
    case "01":
        $show_mont_close = "มกราคม";
        break;
    case "02":
        $show_mont_close = "กุมภาพันธ์";
        break;
    case "03":
        $show_mont_close = "มีนาคม";
        break;
    case "04":
        $show_mont_close = "เมษายน";
        break;
    case "05":
        $show_mont_close = "พฤษภาคม";
        break;
    case "06":
        $show_mont_close = "มิถุนายน";
        break;
    case "07":
        $show_mont_close = "กรกฎาคม";
        break;
    case "08":
        $show_mont_close = "สิงหาคม";
        break;
    case "09":
        $show_mont_close = "กันยายน";
        break;
    case "10":
        $show_mont_close = "ตุลาคม";
        break;
    case "11":
        $show_mont_close = "พฤศจิกายน";
        break;
    case "12":
        $show_mont_close = "ธันวาคม";
        break;
}

// time
$time = $DB->conn->query("SELECT * FROM tb_time");
$result_time = $time->fetch_array();
$open = $result_time['time_open'];
$close = $result_time['time_close'];
$id = $result_time['id'];

// term 
$query = $DB->conn->query("SELECT * FROM tb_term");
$fetch = $query->fetch_array();
$term_r = $fetch['term'];

// year
$query_year = $DB->conn->query("SELECT * FROM tb_school_year");
$f_year = $query_year->fetch_array();
$year_r = $f_year['school_year'];

// area
$sql = "SELECT * FROM tb_area";
$query = $DB->conn->query($sql);
$data = $query->fetch_array();
$lat = $data['lat'];
$lng = $data['lng'];
$area = $data['radius'];
?>

<div class="container">
    <div class="card p-3 shadow-sm">
        <div class="card-body">
            <h4 class="card-title">ระดับชั้นทั้งหมด</h4>
            <div class="table-responsive">
                <table class="table text-center table-bordered  p-0">
                    <thead>
                        <tr>
                            <th>หัวข้อ</th>
                            <th>รายละเอียด</th>
                            <th width="10%">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>เวลาเปิดแสกน
                            </td>
                            <td>
                                เปิด <?php echo $open; ?> น.
                            </td>
                            <td>
                                <button class="btn btn-warning" onclick="editOpen(<?= $id ?>)"><i class='bx bx-edit icon'></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>เวลาปิดแสกน
                            </td>
                            <td>
                                ปิด <?php echo $close; ?> น.
                            </td>
                            <td>
                            <button class="btn btn-warning" onclick="editClose(<?= $id ?>)"><i class='bx bx-edit icon'></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>วัน เปิดภาคเรียน</td>
                            <td><?php echo $d_open . " " . $show_mont_open . " " . $y_open; ?></td>
                            <td><input type="date" name="date_open" id="date_open" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>วัน ปิดภาคเรียน</td>
                            <td><?php echo $d_close . " " . $show_mont_close . " " . $y_close; ?></td>
                            <td><input type="date" name="date_close" id="date_close" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>ภาคเรียน</td>
                            <td><?php echo $term_r ?></td>
                            <td><button class="btn btn-warning btn-fw" onclick="editTerm()"><i class='bx bxs-edit'></i></button></td>
                        </tr>
                        <tr>
                            <td>ปีการศึกษา</td>
                            <td><?php echo $year_r ?></td>
                            <td><button class="btn btn-warning btn-fw" onclick="editYear()"><i class='bx bxs-edit'></i></button></td>
                        </tr>
                        <tr>
                            <td>ละติจูด</td>
                            <td><?php echo $lat; ?></td>
                            <td rowspan="3"><button class="btn btn-warning" onclick="editArea()" style="margin-top: 20%;"><i class='bx bxs-edit'></i></button></td>
                        </tr>
                        <tr>
                            <td>ลองจิจูด</td>
                            <td><?php echo $lng; ?></td>
                        </tr>
                        <tr>
                            <td>รัศมีพื้นที่ (เมตร)</td>
                            <td><?php echo $area; ?> เมตร</td>
                        </tr>
                    </tbody>
                </table>
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

<!-- Modal -->
<div class="modal fade" id="ModlaPass" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">ยืนยันรหัสผ่าน</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label for="">รหัสผ่าน</label>
                    <input type="password" name="c_pass" id="c_pass" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" id="check_pass" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ModlaArea" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">แก้ไขพื้นที่</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label for="">ละติจูด</label>
                    <input type="text" name="lat" id="lat" class="form-control" value="<?php echo $lat; ?>">
                </div>
                <div class="mb-2">
                    <label for="">ลองจิจูด</label>
                    <input type="text" name="lag" id="lng" class="form-control" value="<?php echo $lng; ?>">
                </div>
                <div class="mb-3">
                    <label for="">กำหนดรัศมี Check In (เมตร)</label>
                    <input type="text" name="area" id="area" class="form-control" value="<?php echo $area; ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" id="update" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>
<?php require_once('function/footer.php'); ?>
<script src="../assets/js/option.js"></script>
<script src="../assets/js/time.js"></script>
<script src="../assets/js/year.js"></script>
<script src="../assets/js/year_term.js"></script>
<script>
    function editArea() {
        $('#ModlaPass').modal('show')
        $('#check_pass').click(function() {
            var pas = $('#c_pass').val()
            $.ajax({
                url: 'function/action.php',
                type: 'post',
                data: {
                    pass: pas,
                    check_pass: 1
                },
                success: function(res) {
                    if (res == 'yes') {
                        $('#ModlaPass').modal('hide')
                        $('#ModlaArea').modal('show')
                        $('#update').click(function() {
                            var lat = $('#lat').val()
                            var lng = $('#lng').val()
                            var area = $('#area').val()
                            var option = {
                                url: 'function/action.php',
                                type: 'post',
                                data: {
                                    lat: lat,
                                    lng: lng,
                                    area: area,
                                    updateArea: 1
                                },
                                success: function(res) {
                                    alertsuccess('success', 'อัพเดตเรียบร้อย', '')
                                    setTimeout(() => {
                                       location.reload() 
                                    }, 700);
                                }
                            }
                            $.ajax(option)
                        })
                    } else {
                        alertsuccess('error', 'รหัสผ่านไม่ถูกต้อง', '')
                        $('#c_pass').val('')
                    }
                }
            })
        })
    }
</script>