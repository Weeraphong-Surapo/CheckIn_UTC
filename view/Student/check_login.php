<?php 
// เรียกใช้งานคลาส DB และ Controller
require_once('../../Controller/StudentController.php');
require_once('function/head.php');
$DB = new DB_STUDENT;
if (isset($_SESSION['login']) && isset($_SESSION['Teacher_id'])) {
    header('Location: index.php');
}
?>

<body>
<form action="">
    <img src="../assets/images/logo2.jpg" alt="">
    <br>
    <span class="fs-3" id="">เข้าสู่ระบบ</span><br>
    <!-- <span class="text-mute">สำหรับอาจารย์</span> -->
    <div class="txt_field" id="enter_student">
        <input type="text" id="Student_id" name="Student_id" required>
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/js/blockui.js"></script>
    <script src="../assets/js/swal.js"></script>
</body>
<script>
    function ajaxlogin(url, type, data) {
        $.ajax({
            url: url,
            type: type,
            data: data,
            beforeSend: function() {
                $.blockUI({
                    message: $('#indicator'),
                    css: {
                        background: '#f2edf3',
                        color: '#da8cff',
                        border: 'none'
                    },
                    overlayCSS: {
                        background: '#ceacf2',
                        opacity: false
                    }
                })
            },
            error: function(xhr, textStatus) {
                alert(textStatus)
            },
            success: function(res) {
                console.log(res);
                if (res == 'no') {
                    $('#error').html('ไม่มีรหัสประจำตัวนี้ในระบบ!!')
                } else {
                    $('#error').empty()
                    $('#check_otp').hide()
                    $('#login').show()
                    $('#enter_student').hide()
                    $('#enter_otp').show()
                }
                $.unblockUI()
            }
        })
    }

    function alaxlogin_success(url, type, data) {
        $.ajax({
            url: url,
            type: type,
            data: data,
            beforeSend: function() {

            },
            error: function(xhr, textStatus) {
                alert(textStatus)
            },
            success: function(res) {
                if (res == "login") {
                    alertsuccess('success','เข้าสู่ระบบสำเร็จ','')
                    setTimeout(()=>{window.location='detail.php'},1000)
                } else {
                    $('#otp').val('')
                    alertsuccess('error', 'OTP ไม่ถูกต้อง', 'กรุณาเช็คในอีเมลล์อีกครั้ง')
                }
            }
        })
    }

    $(function() {
        $('#check_otp').click(function(e) {
            e.preventDefault();
            let otp = $('#otp').val()
            let student = $('#Student_id').val()
            ajaxlogin('function/action.php', 'post', {
                student: student,
                otp:otp,
                login: 1
            })
        })

        $('#login').click(function(e) {
            e.preventDefault();
            let otp = $('#otp').val()
            alaxlogin_success('function/action.php', 'post', {
                otp: otp,
                login_success: 1
            })
        })
    })
</script>

</html>