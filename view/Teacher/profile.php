<?php
// เรียกใช้งาน DB และ Controller
require_once('../../Controller/TeacherController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB;
$sql = "SELECT * FROM tb_teacher WHERE id = '$_SESSION[Teacher_id]'";
$result = $DB->conn->query($sql);
$row = $result->fetch_array();
$department = $DB->conn->query("SELECT * FROM tb_department WHERE id = '$row[Department]'");
$department_name = $department->fetch_array();
$lavel = $DB->conn->query("SELECT * FROM tb_lavel WHERE id = '$row[lavel]'");
$lavel_name = $lavel->fetch_array();
?>
<div class="container">
    <div class="card px-5">
        <div class="card-body">
            <h2 class="text-center">ข้อมูลส่วนตัว</h2>
            <div align="center">
              <?php 
                  echo '<img src="../assets/'.$row['image'].'" alt="" width="240" height="240" class="rounded" >';
              ?>
              <button class="btn btn-sm btn-warning d-block mt-1" onclick="editImage(<?= $row['id'] ?>)">เปลี่ยนรูปภาพ</button>
            </div>
            <table class="table table-bordered mt-3">
              <tr>
                <td>สถานะ </td>
                <td><?= $row['type'] == 999 ? 'ผู้ดูแลระบบ': 'อาจารย์ผู้ดูแล';?></td>
              </tr>
              <tr>
                <td>ชื่อ </td>
                <td><?= $row['title']." " .$row['Teacher_name'];?></td>
              </tr>
              <tr>
                <td>แผนกที่ดูแล </td>
                <td><?= $department_name['Department'].' / '.$lavel_name['lavel'];?></td>
              </tr>
              <tr>
                <td>เบอร์โทร </td>
                <td><?= $row['phone'];?></td>
              </tr>
              <tr>
                <td>ชื่อผู้ใช้งาน </td>
                <td><?= $row['username'];?></td>
              </tr>
              <tr>
                <td>ไลน์แจ้งเตือน </td>
                <td><?= $row['line_token'] == "" || null ? 'ไม่มี Token' :  substr($row['line_token'],0,16)."...";?></td>
              </tr>
            </table>

            <center>
              <button class="btn btn-warning" onclick="editProfile(<?php echo $_SESSION['Teacher_id']?>)">แก้ไขข้อมูล</button>
              <button class="btn btn-primary" id="editPass">แก้ไขรหัสผ่าน</button>
            </center>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">เปลี่ยนรหัสผ่าน</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="old_pass">
            <label for="old_pass">รหัสผ่านเดิม</label>
            <input type="password" name="old_pass" id="old_pass" class="form-control" placeholder="รหัสผ่านเดิม">
        </div>
        <p id="error-old-pass"></p>
        <div class="new_pass" style="display: none;">
            <label for="new_pass">รหัสผ่านใหม่</label>
            <input type="password" name="new_pass" id="new_pass" class="form-control">
        </div>
        <p id="error-new-pass"></p>
        <!-- <button type="button" id="togglePass">Show</button> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" id="btn-old-pass">ตรวจเช็ค</button>
        <button type="button" class="btn btn-primary" id="btn-new-pass" style="display: none;">บันทึกรหัสผ่าน</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="ModalEditImage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">แก้ไขรูปภาพ</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="FormUpdateImage">
        <input type="hidden" name="idOldImage" id="idOldImage">
        <img src="" alt="" class="img-fluid" id="showImage">
        <input type="file" name="image_old" id="image_old" class="form-control mt-1">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        <button type="submit" class="btn btn-primary" id="updateImage" style="display: none;">อัพเดต</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="ModalName" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="textName"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="resultName">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" onclick="submitName()" id="btnName">บันทึก</button>
        <button type="button" class="btn btn-primary" onclick="submitPhone()" id="btnPhone">บันทึก</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalProfiles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">แก้ไขข้อมูล</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="">
          <input type="hidden" name="idTeacher" id="idTeacher" value="<?php echo $_SESSION['Teacher_id']?>">
          <div class="mb-2">
            <label for="">สถานะ</label>
            <input type="text" name="status" id="status" value="<?= $row['type'] == 1 ? 'ผู้ดูแลระบบ': 'อาจารย์ผู้ดูแล';?>" class="form-control" disabled>
          </div>
          <div class="mb-2">
            <label for="">ชื่อ</label>
            <input type="text" name="fullname" value="<?= $row['Teacher_name'];?>" id="fullname" class="form-control">
          </div>
          <div class="mb-2">
            <label for="">แผนกที่ดูแล</label>
            <input type="text" name="departments" id="departments" value="<?php echo $department_name['Department'].' / '.$lavel_name['lavel']?>"  class="form-control" disabled>
          </div>
          <div class="mb-2">
            <label for="">เบอร์โทร</label>
            <input type="text" name="phones" value="<?= $row['phone'];?>" id="phones" class="form-control">
          </div>
          <div class="mb-2">
            <label for="">ชื่อผู้ใช้งาน</label>
            <input type="text" name="users" id="users" value="<?= $row['username'];?>" class="form-control" disabled>
          </div>
          <div class="mb-2">
            <label for="">ไลน์แจ้งเตือน</label>
            <input type="text" name="line" id="line" value="<?= $row['line_token'];?>" class="form-control" placeholder="<?= $row['line_token'] == "" || null ? 'ไม่มี Token' : $row['line_token']?>">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" onclick="updateProfile()">บันทึก</button>
      </div>
    </div>
  </div>
</div>

<?php require_once('function/footer.php'); ?>
<script src="../assets/js/profile.js"></script>