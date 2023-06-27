<?php 
session_status();
require_once('connectDB.php');

class DB_STUDENT extends DB_CONNECT{

    // ส่ง OTP ไปทางอีเมลล์
    function sendOTP($Student_id){
        $query = $this->conn->query("SELECT * FROM tb_student WHERE Student_id = '$Student_id'");
        $student = $query->fetch_array();
        if ($query->num_rows >= 1) {
            $email = $student['Email'];
            $otp = rand(11111, 99999);
            $this->conn->query("UPDATE tb_student SET otp = '$otp' WHERE Student_id = '$Student_id'");
            $htmnl = "รหัส OTP เข้าระบบของคุณคือ <b>" . $otp."</b>";
            smtp_mailer($email, 'OTP LOGIN SYSTEM', $htmnl);
        } else {
            echo 'no';
        }   
    }

    function checkOTP($otp){
        $check_otp = $this->conn->query("SELECT * FROM tb_student WHERE otp = '$otp'");
        $otp_student = $check_otp->fetch_array();
        if($check_otp->num_rows >= 1){
            if ($_POST['otp'] == $otp_student['otp']) {
                $_SESSION['login'] = true;
                $_SESSION['id'] = $otp_student['id'];
                $_SESSION['Student_id'] = $otp_student['Student_id'];
                $_SESSION['Student_name'] = $otp_student['Student_name'];
                $_SESSION['Room_ID'] = $otp_student['Room_ID'];
                $_SESSION['Teacher_id'] = $otp_student['Teacher_id'];
                setcookie( "Student_id", $otp_student['Student_id'], time()+ 60*60*24*365, "/");
                echo 'login';
            }else{
                echo 'otp_fail';
            }
        }else{
            echo 'fail';
        }
    }
}
