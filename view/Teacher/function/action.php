<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [ // lowercase letters only in font key
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf'
        ]
    ],
    'default_font' => 'sarabun'
]);

require_once('../../../Controller/TeacherController.php');

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
$DB = new DB;

// แก้ไขข้อมูล
if (isset($_POST['editstudent'])) {
    $id = $_POST['id'];
    $DB->fetchData($id);
}

// ลบข้อมูลนักเรียน
if (isset($_POST['delStudent'])) {
    $id = $_POST['id'];
    $student_id = $_POST['student_id'];
    $DB->delData($id,$student_id);
}

// เพิ่มข้อมูลนักเรียน
if (isset($_POST['insertStudent'])) {
    $id = $_POST['id'];
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $email = $_POST['email'];
    $teacher = $_SESSION['Teacher_id'];
    $room = $_POST['room'];
    if (!empty($id)) {
        $DB->updateData($student_id, $student_name, $email, $teacher, $id,$room);
    } else {
        $DB->insertData($student_id, $student_name, $email, $teacher,$room);
    }
}


// ส่งอีเมลล์หานักเรียน
if (isset($_POST['warn'])) {
    $id = $_POST['id'];
    $email = $DB->sendEmail($id);
    $row = $email->fetch_array();
    $email = $row['Email'];
    $htmnl = "แจ้งเตือน {$row['Name']} คุณขาดแถวมากเกินไป กรุณามาเข้าแถวด้วย";
    smtp_mailer($email, 'CHECK IN WARNING', $htmnl);
}

// เช็คชื่อนักเรียน
if (isset($_POST['checkin'])) {
    $id = $_POST['id'];
    if (isset($_POST['update'])) {
        $sql = $DB->cancelCheck($id);
    } else {
        $sql = $DB->Checkin($id);
    }
    $DB->conn->query($sql);
}

// บันทึกข้อมูลลงสรุปผลเข้าแถว 
if (isset($_POST['insert'])) {
    $c = $_POST['c'];
    $DB->insertStudent($c);
}

// เข้าสู่ระบบอาจารย์
if (isset($_POST['loginTeacher'])) {
    $username = $_POST['username'];
    $pass = $_POST['password'];
    $check = $_POST['check'];
    $DB->login($username, $pass,$check);
}


// ดาวโหลดPDF
if (isset($_POST['createPdf'])) {
    $sql = "SELECT * FROM tb_check_student";
    $result = $DB->conn->query($sql);
    $outp = "";
    $outp .= "<table>
        <tr>
          <th>เลขประจำตัว</th>
          <th>ชื่อ - นามสกุล</th>
          <th colspan='3'>การมาเข้าแถว</th>
        </tr>
        <tr id='headtable'>
          <td colspan='2'></td>
          <td>รวมเข้าแถว</td>
          <td>มา</td>
          <td>ขาด</td>
        </tr>
      <tr id='bodytable'>";
    while ($data = $result->fetch_array()) {
        $outp .= "<td>{$data['Student_id']}</td>";
        $outp .= "<td>{$data['Name']}</td>";
        $outp .= "<td>{$data['count_check']}</td>";
        $outp .= "<td>{$data['count_check_in']}</td>";
        $outp .= "<td>{$data['count_no_check']}</td>";
    }
    $outp .= "</tr></table>";
    $mpdf->WriteHTML($outp);
    $mpdf->Output('myfile.pdf','D');
}


// แก้ไขรูปภาพ
if(isset($_POST['editImage'])){
    $id = $_POST['id'];
    $DB->editImage($id);
}

// อัพเดตรูปภาพ
if(isset($_POST['updateImage'])){
    $id = $_POST['id'];
    $image = $_FILES['file'];
    $DB->updateImage($id,$image);
}

// ออกจากระบบ
if (isset($_POST['logout'])) {
    unset($_SESSION['login']);
    unset($_SESSION['type']);
    unset($_SESSION['Teacher_id']);
    unset($_SESSION['Teacher_name']);
}

// รีเซตการเข้าแถว
if (isset($_POST['resetStudent'])) {
    $DB->resetStudent();
}

// ลบข้อมูลการเข้าแถว
if(isset($_POST['del_cehck_student'])){
    $DB->del_check_student();
}

// แก้ไขรหัสผ่านเข้าระบบ อาจารย์
if(isset($_POST['check_pass'])){
    $old_pass = $_POST['old_pass'];
    $DB->editPass($old_pass);
}

// อัพเดตรหัสผ่านเข้าระบบ อาจารย์
if(isset($_POST['updatePass'])){
    $new_pass = $_POST['new_pass'];
    $DB->updatePass($new_pass);
}

// อัพเดตสเตตัสประกาศ
if(isset($_POST['updateAnnounce'])){
    $id = $_POST['id'];
    $DB->updateAnnounce($id);
}

// ลบข้อมูลประกาศ
if(isset($_POST['delAnnounce'])){
    $id = $_POST['id'];
    $DB->conn->query("DELETE FROM tb_announce WHERE id = '$id'");
}

// แก้ไขประกาศ
if(isset($_POST['editAnnounce'])){
    $id = $_POST['id'];
    $DB->editAnnounce($id);
}

// เพิ่มประกาศ และ อัพเดตประกาศ
if(isset($_POST['submitAnnounce'])){
    $id = $_POST['id'];
    $head = $_POST['head'];
    $description = $_POST['description'];
    $DB->insertAndUpdateAnnounce($id,$head,$description);
}

// แก้ไขชื่อ
if(isset($_POST['editName'])){
    $id = $_POST['id'];
    $DB->editName($id);
}
// อัพเดตชื่อ
if(isset($_POST['updateName'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $DB->updateName($id,$name);
}

// แก้ไขเบอร์โทร
if(isset($_POST['editPhone'])){
    $id = $_POST['id'];
    $DB->editPhone($id);
}

// อัพเดตเบร์โทร
if(isset($_POST['updatePhone'])){
    $id = $_POST['id'];
    $phone = $_POST['phone'];
    $DB->updatePhone($id,$phone);
}

// ยืนยันการบันทึกข้อมูลการเช็คแถวเทอมนี้
if(isset($_POST['confirmReport'])){
    $pass = $_POST['pass'];
    $username = $_SESSION['username'];
    $DB->confirmReport($pass,$username);
}

// ลบประวัติการเช็คชื่อ
if(isset($_POST['delHistory'])){
    $year = $_POST['year'];
    $term = $_POST['term'];
    $id = $_POST['id'];
    $DB->delHistory($id,$year,$term);
}

if(isset($_POST['find_report'])){
    $date = $_POST['date'];
    $DB->findReport($date);
}

if(isset($_POST['updateCheck'])){
    $id = $_POST['id'];
    $date_id = $_POST['date_id'];
    if (isset($_POST['update'])) {
        $sql = $DB->cancelUpdateCheck($id,$date_id);
        echo $sql;
    } else {
        $sql = $DB->UpdateCheckin($id,$date_id);
        echo $sql;
    }
    $DB->conn->query($sql);

}

// หาข้อมูลผู้ใช้งาน
if(isset($_POST['updateProfile'])){
    $phone = $_POST['phone'];
    $fullname = $_POST['fullname'];
    $id = $_POST['id'];
    $line = $_POST['line'];
    $DB->updateProfile($fullname,$phone,$id,$line);
}

if(isset($_POST['checkQrcode'])){
    $date = date('d-m-y');
    $lastResult = $_POST['lastResult'];
    $result = explode("&",$lastResult);
    $res = 0;
    $room = $result[0];
    $date = $result[1];
    $student_id = $result[2];
    $array = array();
    if(!empty($date) && !empty($room) && !empty($student_id)){
        if ($date == $date) {
            $sql = "UPDATE tb_student SET status = 1 WHERE Student_id = '$student_id'";
            $query = $DB->conn->query($sql);
            $array = array('status'=>1,'student'=>$student_id);
        } else {
            $array = array('status'=>0);
        }
    }else{
        $array = array('status'=>0);
    }
    echo json_encode($array);
}
