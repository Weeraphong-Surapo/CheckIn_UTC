<?php
require_once('../../../Controller/AdminController.php');
// สร้างออปเจ็คจากคลาส DB_Admin
$DB = new DB_Admin;

// เพิ่มคำนำหน้า
if(isset($_POST['addTitle'])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $DB->insertORupdateTitle($id,$title);
}

// ลบคำนำหน้า
if(isset($_POST['deltitle'])){
    $id = $_POST['id'];
    $DB->delTitle($id);
}

// แก้ไขคำนำหน้า
if(isset($_POST['editTitle'])){
    $id = $_POST['id'];
    $DB->editTitle($id);
}

// เพิ่มระดับชั้น
if(isset($_POST['addLavel'])){
    $id = $_POST['id'];
    $lavel = $_POST['lavel'];
    $DB->insertLavel($id,$lavel);
}

// ลบระดับชั้น
if(isset($_POST['delLavel'])){
    $id = $_POST['id'];
    $DB->delLavel($id);
}

// โชว์ระดับชั้น
if(isset($_POST['showLavel'])){
    $id = $_POST['lavel'];
    $DB->editLavel($id);
}

// เพิ่มสาขางาน และ อัพเดตสาขางาน
if(isset($_POST['insertDepartment'])){
    $id = $_POST['id_edit'];
    $department = $_POST['department'];
    $DB->insertDepartment($id,$department);
}

// ลบสาขางาน
if(isset($_POST['delDepartment'])){
    $id = $_POST['id'];
    $DB->delDepartment($id);
}

// แก้ไขสาขางาน
if(isset($_POST['editDepartment'])){
    $id = $_POST['id'];
    $DB->editDepartment($id);
}

// เพิ่มอาจารย์
if(isset($_POST['add_teacher'])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $name = $_POST['teacher'];
    $username = $_POST['username'];
    $pass = $_POST['password'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $lavel = $_POST['lavel'];
    $room1 = $_POST['room1'];
    $room2 = $_POST['room2'];
    $DB->insertTeacher($id,$title,$name,$username,$pass,$phone,$department,$lavel,$room1,$room2);
}

// ลบอาจารย์
if(isset($_POST['delTeacher'])){
    $id = $_POST['id'];
    $DB->check_count_student($id);
}

// แก้ไขอาจารย์
if(isset($_POST['edit_teacher'])){
    $id = $_POST['id'];
    $DB->editTeacher($id);
}

// ดูข้อมูลอาจารย์
if(isset($_POST['view_teacher'])){
    $id = $_POST['id'];
    $DB->viewTeacher($id);
}

// ตรวจสอบจำนวนสาขางาน
if(isset($_POST['check_count_department'])){
    $DB->check_count_department();
}

// ออกจากระบบ
if(isset($_POST['logout'])){
    session_destroy();
}

// แก้ไขปีการศึกษา
// if(isset($_POST['editYear'])){
//     $DB->editYear();

// }

// แก้ไขเวลาปิด
if(isset($_POST['editclose'])){
    $DB->editYear();
}

// อัพเดตปีการศึกษา
if(isset($_POST['updateYear'])){
    $time_open = $_POST['Term'];
    $DB->updateYear($time_open);
}

// แก้ไขภาคเรียน
if(isset($_POST['editopen'])){
    $DB->editTerm();
}

// อัพเดตภาคเรียน
if(isset($_POST['updateTerm'])){
    $time_close = $_POST['Year'];
    $DB->updateTerm($time_close);
}

// แก้ไขชื่อ
if(isset($_POST['editName'])){
    $DB->editName();
}

// อัพเดตชื่อ
if(isset($_POST['updateName'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $DB->updateName($id,$name);
}

if(isset($_POST['updatePass'])){
    $pass = $_POST['new_pass'];
    $DB->updatePass($pass);
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

// เช็ครหัสผ่านก่อนแก้ไขพื้นที่
if(isset($_POST['check_pass'])){
    $pass = $_POST['old_pass'];
    $query = $DB->checkPass($pass);
}

// อัพเดตพื้นที่
if(isset($_POST['updateArea'])){
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $area = $_POST['area'];
    $DB->updateArea($lat,$lng,$area);
}

// อัพเดตวันที่เปิดภาคเรียน
if(isset($_POST['updateOpen'])){
    $date = $_POST['date'];
    $DB->updateOpen($date);
}

// อัพเดตวันที่ปิดภาคเรียน
if(isset($_POST['updateClose'])){
    $date = $_POST['date'];
    $DB->updateClose($date);
}

// แก้ไขเทอม
if(isset($_POST['editTerms'])){
    $id = $_POST['id'];
    $DB->editTerms($id);
}

// อัพเดตเทอม
if(isset($_POST['saveTerm'])){
    $term = $_POST['term'];
    $DB->saveTerm($term);
}

// แก้ไขปีการศึกษา
if(isset($_POST['editYears'])){
    $DB->editYears();
}

// อัพเดตปีการศึกษา
if(isset($_POST['saveYear'])){
    $year = $_POST['year'];
    $DB->saveYear($year);
}

if(isset($_POST['delCalendar'])){
    $id = $_POST['id'];
    $DB->delCalendar($id);
}

if(isset($_POST['insert'])){
    if(empty($_POST['id'])){
        $sql = "INSERT INTO `tb_schedule_list` (`title`,`description`,`start_datetime`,`end_datetime`) VALUES ('$_POST[title]','$_POST[des]','$_POST[start_datetime]','$_POST[end_datetime]')";
    }else{
        $sql = "UPDATE `tb_schedule_list` set `title` = '{$_POST['title']}', `description` = '{$_POST['des']}', `start_datetime` = '{$_POST['start_datetime']}', `end_datetime` = '{$_POST['end_datetime']}' where `id` = '{$_POST['id']}'";
    }
    $save = $DB->conn->query($sql);
    if($save){
        echo 'success';
    }else{
        echo 'error';
    }
}

if(isset($_POST['updateTeachers'])){
    $query = $DB->conn->query("UPDATE tb_teacher SET lavel = '$_POST[lavel]' , Department = '$_POST[department]' WHERE id = '$_POST[id]'");
}

if(isset($_POST['updateProfiles'])){
    $phone = $_POST['phone'];
    $fullname = $_POST['fullname'];
    $id = $_POST['id'];
    $DB->updateProfileAdmin($id,$fullname,$phone);
}

if(isset($_POST['addRoom'])){
    $room = $_POST['room'];
    if(!empty($_POST['id'])){
        $sql = "UPDATE `tb_room` SET `room`= '$room' WHERE Room_ID = '$_POST[id]'";
        echo 'update';
    }else{
        $sql = "INSERT INTO tb_room(room) VALUES('$room')";
        echo 'insert';
    }
    $query = $DB->conn->query($sql);
}

if(isset($_POST['delRoom'])){
    $id = $_POST['id'];
    $sql = "DELETE FROM tb_room WHERE Room_ID = '$id'";
    $query = $DB->conn->query($sql);
}

if(isset($_POST['editRoom'])){
    $id = $_POST['id'];
    $sql = "SELECT * FROM tb_room WHERE Room_ID = '$id'";
    $query = $DB->conn->query($sql);
    $row = $query->fetch_array();
    echo json_encode($row);
}

if(isset($_POST['findroom'])){
    $id = $_POST['room'];
    $sql = "SELECT * FROM tb_room WHERE Room_ID != '$id'";
    $query = $DB->conn->query($sql);
    $oupt = '';
    $oupt .= '<option selected disabled>เลือกห้องที่ดูแล</option>';
    foreach($query as $row){
        $oupt .= '<option value="'.$row['Room_ID'].'">'.$row['room'].'</option>';
    }
    echo $oupt;
}
?>