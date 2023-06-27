<?php
// เรียกใช้งานคลาส DB และ Controller
require_once('../../Controller/TeacherController.php');
require_once('function/headlogin.php');
$DB = new DB;
// if(isset($_SESSION['type']) && $_SESSION['type'] == 'teacher'){
//     header('Location: index');
// }
?>

<form action="">
    <img src="../assets/images/logo_main.png" alt="" class="img-fluid">
    <br>
    <span class="d-block fs-5 mt-2 mb-1 text-center">ระบบเช็คชื่อเข้าแถว Qrcode</span>
    <div align="center">
        <span class="text-muted ">เข้าใช้งานระบบ</span><br>
    </div>
        <div class="txt_field">
            <input type="text" id="username" name="username" value="<?= isset($_COOKIE['user']) ?  $_COOKIE['user'] : ''; ?>" required>
            <span></span>
            <label>ชื่อผู้ใช้งาน</label>
        </div>
        <span id="error-username"></span>
        <div class="txt_field">
            <input type="password"  id="password" name="password" value="<?= isset($_COOKIE['pass']) ?  $_COOKIE['pass'] : ''; ?>" required>
            <span></span>
            <label>รหัสผ่าน</label>
        </div>
        <span id="error-password"></span>

        <div class="main-cb">
            <input type="checkbox" class="aa" name="check" <?php echo isset($_COOKIE['user']) ? 'checked' : '';?> style="accent-color: blue;" id="check">
            <span style="font-size: 14px; color: #047edf;">จดจำฉันในระบบ</span>
        </div>
        <button onclick="loginTeacher(event)">เข้าสู่ระบบ</button>
    </form>

<script src="../assets/js/jquery-3.6.1.min.js"></script>
<?php require_once('function/footer.php'); ?>
<script src="../assets/js/login.js"></script>
<script src="../assets/js/blockui.js"></script>