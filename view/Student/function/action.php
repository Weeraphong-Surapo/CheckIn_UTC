<?php 
session_start();
require_once('../../../Controller/StudentController.php');
$DB = new DB_STUDENT;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../assets/phpmailer/src/Exception.php';
require '../../assets/phpmailer/src/PHPMailer.php';
require '../../assets/phpmailer/src/SMTP.php';

function smtp_mailer($to, $subject, $msg)
{
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    // $mail->isSMTP();
    // $mail->Host = 'mail.bigshop.world';
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'shopphp147852@gmail.com';
    $mail->Password = 'xuvbfmckomlptvst';
    // $mail->Username = 'checkutc@bigshop.world';
    // $mail->Password = 'CXxH37cng*e#';
    // $mail->Password = 'Bigcza123456';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('checkutc@bigshop.world','CheckUTCQrcode');

    $mail->addAddress($to);

    $mail->isHTML(true);

    $mail->Subject = $subject;
    $mail->Body = $msg;
    $mail->send();
}

// ตรวจสอบ OTP
if (isset($_POST['login_success'])) {
    $otp = $_POST['otp'];
    $DB->checkOTP($otp);
}

// ส่งรหัส OTP ไปอีเมลล์
if (isset($_POST['login']) ) {
    $otp = isset($_POST['otp']) ? $_POST['otp'] : '';
    $Student = isset($_POST['student']) ? $_POST['student'] : '';
    if(!empty($otp)){
        $DB->checkOTP($otp);
    }else{
        $DB->sendOTP($Student);
    }
}

// ออกจากระบบ
if(isset($_POST['logout'])){
    unset($_SESSION['login']);
    unset($_SESSION['id']);
    unset($_SESSION['Student_id']);
    unset($_SESSION['Student_name']);
    unset($_SESSION['Teacher_id']);
    session_destroy();
}

?>