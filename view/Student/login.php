<?php
// เรียกใช้งานคลาส DB และ Controller
require_once('../../Controller/StudentController.php');
require_once('function/headlogin.php');
$DB = new DB_STUDENT;
?>

<form action="">
    <img src="../assets/images/logo_main.png" alt="" class="img-fluid">
    <br>
    <span class="d-block fs-5 mt-2 mb-1 text-center">ระบบเช็คชื่อเข้าแถว Qrcode</span>
    <div align="center">
        <span class="text-muted ">เข้าใช้งานระบบ</span><br>
    </div>
    <div class="txt_field" id="enter_student">
        <input type="text" id="Student_id"
            value="<?php echo isset($_COOKIE['Student_id']) ? $_COOKIE['Student_id']: '' ?>" name="Student_id" required>
        <span></span>
        <label>รหัสประจำตัว</label>
    </div>
    <span id="error-studentId"></span>
    <span id="error"></span>
    <div class="txt_field" id="enter_otp" style="display: none;">
        <input type="text" id="otp" name="otp" required>
        <span></span>
        <label>OTP</label>
    </div>
    <span id="error-password"></span>
    <button id="check_otp">รับ OTP</button>
    <button id="login" style="display: none;">เข้าสู่ระบบ</button>
</form>


<?php require_once('function/footer.php'); ?>
<script src="../assets/js/blockui.js"></script>
<script src="../assets/js/login_student.js"></script>