<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once('connectDB.php');

class DB_Admin extends DB_CONNECT
{

    // โชว์คำนำหน้าทั้งหมด
    function showTitle()
    {
        $sql = "SELECT * FROM tb_title";
        $result = $this->conn->query($sql);
        return $result;
    }

    // เพิ่มคำนำหน้า || อัพเดตคำนำหน้า
    function insertORupdateTitle($id, $title)
    {
        if (!empty($id)) {
            $sql = "UPDATE tb_title SET title = '$title' WHERE id = '$id'";
        } else {
            $sql = "INSERT INTO tb_title(title) VALUE('$title')";
        }
        $this->conn->query($sql);
    }

    // ลบคำนำหน้า
    function delTitle($id)
    {
        $sql = "DELETE FROM tb_title WHERE id = '$id'";
        $this->conn->query($sql);
    }

    // แก้ไขคำนำหน้า
    function editTitle($id)
    {
        $sql = "SELECT * FROM tb_title WHERE id = '$id'";
        $query = $this->conn->query($sql);
        $row = $query->fetch_array();
        echo json_encode($row);
    }

    // โชว์ระดับชั้น
    function showLavel()
    {
        $sql = "SELECT * FROM tb_lavel";
        $result = $this->conn->query($sql);
        return $result;
    }

    // เพิ่มระดับชั้น
    function insertLavel($id, $lavel)
    {
        if (!empty($id)) {
            $sql = "UPDATE tb_lavel SET lavel = '$lavel' WHERE id = '$id'";
        } else {
            $sql = "INSERT INTO tb_lavel(lavel) VALUE('$lavel')";
        }
        $this->conn->query($sql);
    }

    // ลบระดับชั้น
    function delLavel($id)
    {
        $sql = "DELETE FROM tb_lavel WHERE id = '$id'";
        $this->conn->query($sql);
    }

    // แก้ไขระดับชั้น
    function editLavel($id)
    {
        $query = $this->conn->query("SELECT * FROM tb_lavel WHERE id = '$id'");
        $row = $query->fetch_array();
        echo json_encode($row);
    }

    // โชว์สาขางาน
    function showDepartment()
    {
        $sql = "SELECT * FROM tb_department";
        $result = $this->conn->query($sql);
        return $result;
    }

    // เพิ่มสาขางาน และ อัพเดตสาขางาน
    function insertDepartment($id, $department)
    {
        if (!empty($_POST['id_edit'])) {
            $sql = "UPDATE tb_department SET Department = '$department' WHERE id = '$id'";
        } else {
            $sql = "INSERT INTO tb_department(Department) VALUE('$department')";
        }
        $this->conn->query($sql);
    }

    // แก้ไขสาขางาน
    function editDepartment($id)
    {
        $sql = "SELECT * FROM tb_department WHERE id = '$id'";
        $query = $this->conn->query($sql);
        $row = $query->fetch_array();
        $arr = array('Department' => $row['Department'], 'id' => $row['id']);
        echo json_encode($arr);
    }

    // ลบสาขางาน
    function delDepartment($id)
    {
        $sql = "DELETE FROM tb_department WHERE id = '$id'";
        $this->conn->query($sql);
    }

    // โชว์อาจารย์ทั้งหมด
    function showTeacher()
    {
        $sql = "SELECT * FROM tb_teacher";
        $result = $this->conn->query($sql);
        return $result;
    }

    // เพิ่มอาจารย์
    function insertTeacher($id, $title, $name, $username, $pass, $phone, $department, $lavel,$room1,$room2)
    {
        $password = md5($pass);
        if (!empty($_POST['id'])) {
            $check_lavel = $this->conn->query("SELECT * FROM tb_teacher WHERE lavel = '$lavel' AND Department = '$department' AND room1 = '$room1' AND room2 = '$room2' AND id != '$id'");
            if($check_lavel->num_rows >=1 ){
                $row = $check_lavel->fetch_array();
                $name = $row['Teacher_name'];
                $array = array("status"=>"moreclass","name"=>"$name");

            }else{
                $array = array("status"=>"yes","name"=>"");
                $sql = "UPDATE tb_teacher SET title = '$title',Teacher_name = '$name',username = '$username',password = '$password' , phone = '$phone', lavel = '$lavel',Department = '$department' WHERE id = '$id'";
            }
        } else {
            $check = "SELECT * FROM tb_teacher WHERE Department = '$department' AND lavel = '$lavel' AND room1 = '$room1' AND room2 = '$room2'";
            $result = $this->conn->query($check);
            if ($result->num_rows > 0) {
                $array = array("status"=>"no","name"=>"");
            } else {
                $sql = "INSERT INTO tb_teacher(title,Teacher_name,username,password,phone,Department,lavel,room1,room2)
                VALUES('$title','$name','$username','$password','$phone','$department','$lavel','$room1','$room2')";
                $array = array("status"=>"yes","name"=>"");    
            }
        }
        echo isset($array) ? json_encode($array) : '';
        $sql = isset($sql) ? $sql : '';
        if ($sql != '') {
            $this->conn->query($sql);
        }
    }

    // แก้ไขอาจารย์
    function editTeacher($id)
    {
        $sql = "SELECT * FROM tb_teacher WHERE id = '$id'";
        $query = $this->conn->query($sql);
        $row = $query->fetch_array();
        echo json_encode($row);
    }


    // เช็คจำนวนนักเรียนก่อนลบอาจารย์
    function check_count_student($id)
    {
        $sql = "SELECT * FROM tb_student WHERE Teacher_id = '$id'";
        $count = $this->conn->query($sql);
        if ($count->num_rows > 0) {
            echo 'no';
        } else {
            $sql = "DELETE FROM tb_teacher WHERE id = '$id'";
            $this->conn->query($sql);
        }
    }


    // ดูข้อมูลอาจารย์
    function viewTeacher($id)
    {
        $sql = "SELECT * FROM tb_teacher WHERE id = '$id'";
        $query = $this->conn->query($sql);
      
        $outp = '';
        while ($row = $query->fetch_array()) {
            $department = $this->conn->query("SELECT * FROM tb_department WHERE id = '$row[Department]'");
            $department_name = $department->fetch_array();
            $room1 = $this->conn->query("SELECT * FROM tb_room WHERE Room_ID = '$row[room1]'");
            $r_room1 = $room1->fetch_array();
            $room2 = $this->conn->query("SELECT * FROM tb_room WHERE Room_ID = '$row[room2]'");
            $r_room2 = $room2->fetch_array();
            $lavel = $this->conn->query("SELECT * FROM tb_lavel WHERE id = '$row[lavel]'");
            $lavel_name = $lavel->fetch_array();
            $outp .= '<table class="table table-bordered"><tr><td>สาขางาน : </td><td>' . $department_name['Department'] . ' / ' . $lavel_name['lavel'] . '</td>';
            $outp .= '<tr><td>ห้องที่ดูแล  </td><td>' . $r_room1['room'] .' - '. $r_room2['room'] . '</td>';
            $outp .= '<tr><td>ชื่อ  </td><td>' . $row['title'] . $row['Teacher_name'] . '</td>';
            $outp .= '<tr><td>เบอร์โทร  </td><td>' . $row['phone'] . '</td>';
            $outp .= '<tr><td>ชื่อผู้ใช้  </td><td>' . $row['username'] . '</td>';
            $outp .= '<tr><td>รหัสผ่าน  </td><td>' . $row['password'] . '</td></tr></table>';
        }
        echo $outp;
    }

    // เช็คจำนวนสาขางาน
    function check_count_department()
    {
        $sql = "SELECT * FROM tb_department";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    // แก้ไขปีการศึกษา
    function editYear()
    {
        $sql = "SELECT * FROM tb_time";
        $result = $this->conn->query($sql);
        $fetch = $result->fetch_array();
        $outp = '';
        $outp .= '<input type="hidden" value="editTime" class="form-control" id="inputType">';
        $outp .= '<input type="text" value="' . $fetch['time_close'] . '" class="form-control" id="inputTime">';
        $outp .= '<p id="errorYear"></p>';
        echo $outp;
    }

    // อัพเดตปีการศึกษา
    function updateYear($year)
    {
        $sql = "UPDATE tb_time SET time_open = '$year'";
        $this->conn->query($sql);
    }


    // แก้ไขภาคเรียน
    function editTerm()
    {
        $sql = "SELECT * FROM tb_time";
        $result = $this->conn->query($sql);
        $fetch = $result->fetch_array();
        $outp = '';
        $outp .= '<input type="hidden" value="editTimeClose" class="form-control" id="inputType">';
        $outp .= '<input type="text" value="' . $fetch['time_open'] . '" class="form-control" id="inputTimeClose">';
        $outp .= '<p id="errorTerm"></p>';
        echo $outp;
    }

    // อัพเดตภาคเรียน
    function updateTerm($time)
    {
        $sql = "UPDATE tb_time SET time_close = '$time'";
        $this->conn->query($sql);
    }

    // แก้ไขชื่อ
    function editName($id)
    {
        $sql = "SELECT * FROM tb_teacher WHERE id = '$id'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_array();
        $outp = '';
        $outp .= '<input type="hidden" id="editName" name="editName" value="' . $row['id'] . '">';
        $outp .= '<input type="text" name="Name" id="Name" class="form-control" value="' . $row['Teacher_name'] . '">';
        echo $outp;
    }

    // อัพเดตชื่อ
    function updateName($id, $name)
    {
        $sql = "UPDATE tb_teacher SET Teacher_name = '$name' WHERE id = '$id'";
        $this->conn->query($sql);
    }

    // แก้ไขเบอร์โทร
    function editPhone($id)
    {
        $sql = "SELECT * FROM tb_teacher WHERE id = '$id'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_array();
        $outp = '';
        $outp .= '<input type="hidden" id="editPhone" name="editPhone" value="' . $row['id'] . '">';
        $outp .= '<input type="text" name="Phone" id="Phone" class="form-control" value="' . $row['phone'] . '">';
        echo $outp;
    }

    // อัพเดตเบอร์โทร
    function updatePhone($id, $phone)
    {
        $sql = "UPDATE tb_teacher SET phone = '$phone' WHERE id = '$id'";
        $this->conn->query($sql);
    }

    // แก้ไขรูปภาพ
    function editImage($id)
    {
        $sql = "SELECT image,id FROM tb_teacher WHERE id = '$id'";
        $resutl = $this->conn->query($sql);
        $row = $resutl->fetch_array();
        echo json_encode($row);
    }

    // อัพเดตรูปภาพ
    function updateImage($id, $image)
    {
        $file = rand(1000, 100000) . "-" . $image['name'];
        $file_loc = $image['tmp_name'];
        $folder = "../../assets/upload/";

        $new_file_name = strtolower($file);

        $fainal = str_replace(' ', '-', $new_file_name);
        $newname = 'upload/' . $fainal;
        move_uploaded_file($file_loc, $folder . $fainal);
        $sql = "UPDATE tb_teacher SET image = '$newname' WHERE id = '$id'";
        $this->conn->query($sql);
    }

    // เช็ครหัสผ่าน
    function checkPass($pass)
    {
        $password = md5($pass);
        $sql = "SELECT * FROM tb_teacher WHERE id = '$_SESSION[Teacher_id]' AND password = '$password' AND type = 999";
        $query = $this->conn->query($sql);
        if ($query->num_rows >= 1) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    function updatePass($pass){
        $password = md5($pass);
        $sql = "UPDATE tb_teacher SET password = '$password' WHERE id = '$_SESSION[Teacher_id]'";
        $query = $this->conn->query($sql);
    }

    // อัพเดตพื้นที่
    function updateArea($lat, $lng, $area)
    {
        $sql = "UPDATE tb_area SET lat = '$lat',lng = '$lng', radius = '$area'";
        $this->conn->query($sql);
    }

    // อัพเดตวันที่เปิดภาคเรียน
    function updateOpen($date)
    {
        $this->conn->query("UPDATE `tb_opn_scan` SET `open`='$date' WHERE 1");
    }

    // อัพเดตวันที่ปิดภาคเรียน
    function updateClose($date)
    {
        $this->conn->query("UPDATE `tb_opn_scan` SET `close`='$date' WHERE 1");
    }

    // แก้ไขปีการศึกษา
    function editYears()
    {
        $query = $this->conn->query("SELECT * FROM tb_school_year");
        $row = $query->fetch_array();
        echo json_encode($row);
    }

    // อัพเดตปีการศึกษา
    function saveYear($year)
    {
        $query = $this->conn->query("UPDATE tb_school_year SET school_year = '$year'");
        if ($query) {
            echo 'success';
        } else {
            echo 'error';
        }
    }

    // อัพเดตภาคเรียน
    function saveTerm($term)
    {
        $query = $this->conn->query("UPDATE tb_term SET term = '$term'");
        if ($query) {
            echo 'success';
        } else {
            echo 'error';
        }
    }

    // แก้ไขปีการศึกษา
    function editTerms(){
        $query = $this->conn->query("SELECT * FROM tb_term");
        $row = $query->fetch_array();
        echo json_encode($row);
    }

    // ลบวันหยุดปฎิทิน
    function delCalendar($id){
        $query = $this->conn->query("DELETE FROM tb_schedule_list WHERE id = '$id'");
        if($query){
            echo 'success';
        }else{
            echo 'error';
        }
    }

    function updateProfileAdmin($id,$fullname,$phone){
        $sql = "UPDATE tb_teacher SET Teacher_name = '$fullname', phone = '$phone' WHERE id ='$id'";
        if($this->conn->query($sql)){
            echo $phone;
        }else{
            echo 'error';
        }

    }
}
