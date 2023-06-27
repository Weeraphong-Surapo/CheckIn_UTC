<?php
// เรียกใช้งาน DB และ Controller
require_once('../../Controller/AdminController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB_Admin;
$sql = "SELECT * FROM tb_area";
$query = $DB->conn->query($sql);
$data = $query->fetch_array();
$lat = $data['lat'];
$lng = $data['lng'];
$area = $data['radius'];
?>
<div class="container">
    <div class="card p-3">
        <div class="card-body">
            <h2>พื้นที่เปิดเช็คอิน</h2>
            <div class="row">
                <div class="col-lg-7">
                    <img src="../assets/images/area.png" alt="" class="img-fluid">
                </div>
                <div class="col-lg-5">
                    <div class="mb-2">
                        <label for="">ละติจูด</label>
                        <input type="text" class="form-control" value="<?php echo $lat; ?>" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="">ลองจิจูด</label>
                        <input type="text" class="form-control" value="<?php echo $lng; ?>" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="">กำหนดรัศมี Check In (เมตร)</label>
                        <input type="text" class="form-control" value="<?php echo $area; ?>" disabled>
                    </div>
                    <button class="btn btn-outline-warning" onclick="editArea()">แก้ไข</button>
                </div>
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