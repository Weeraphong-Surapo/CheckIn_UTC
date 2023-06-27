<?php

use Mpdf\Tag\Em;
use Mpdf\Tag\Q;

require_once('connectDB.php');

if (!isset($_SESSION)) {
  session_start();
}
// คลาส ชื่อ DB สามารถแก้ไขชื่อใด้
class DB extends DB_CONNECT
{

  // โชว์ข้อมูล นักเรียนทั้งหมด
  function showData()
  {
    $sql = "SELECT * FROM tb_student WHERE Teacher_id = '$_SESSION[Teacher_id]'";
    $result = $this->conn->query($sql);
    return $result;
  }


  // แก้ไขข้อมูลนักเรียน
  function fetchData($id)
  {
    $sql = "SELECT * FROM tb_student WHERE id = '$id'";
    $query = $this->conn->query($sql);
    $row = $query->fetch_array();
    echo json_encode($row);
  }

  // ลบข้อมูลนักเรียน
  function delData($id, $student_id)
  {
    $sql = "DELETE FROM tb_student WHERE id = '$id'";
    $this->conn->query($sql);
    $del_check_student = "DELETE FROM tb_check_student WHERE Student_id = '$student_id'";
    $this->conn->query($del_check_student);
  }

  // เพิ่มข้อมูลข้อมูล
  function insertData($student_id, $student_name, $email, $teacher_id,$room)
  {
    $check_student = $this->conn->query("SELECT * FROM tb_student WHERE Student_id = '$student_id'");
    if ($check_student->num_rows >= 1) {
      echo 'no';
    } else {
      $sql = "INSERT INTO tb_student(Student_id,Student_name,Email,Teacher_id,Room_ID)
                  VALUES('$student_id','$student_name','$email','$teacher_id','$room')";
      $this->conn->query($sql);
    }
  }

  // อัพเดตข้อมูลข้อมูล
  function updateData($student_id, $student_name, $email, $teacher_id, $id,$room)
  {
    $sql = "UPDATE tb_student SET Student_id = '$student_id', Student_name = '$student_name',Email = '$email',Teacher_id = '$teacher_id' , Room_ID = '$room' WHERE id = '$id'";
    $this->conn->query($sql);
  }


  // เอาอีเมล์นักเรียน
  function sendEmail($id)
  {
    $sql = "SELECT * FROM tb_student WHERE id = '$id'";
    $result = $this->conn->query($sql);
    return $result;
  }

  // ยกเลิกการติ้กเช็คชื่อ
  function cancelCheck($id)
  {
    $sql = "UPDATE tb_student SET status = 0 WHERE Student_id = '$id'";
    return $sql;
  }

  // ติ้กเช็คชื่อนักเรียน
  function Checkin($id)
  {
    $sql = "UPDATE tb_student SET status = 1 WHERE Student_id = '$id'";
    return $sql;
  }


  // เพิ่มข้อมูลการเข้าแถวของนักเรียน
  function insertStudent($c)
  {
    $count = 1;
    $date = date('Y-m-d');
    $find_student = $this->conn->query("SELECT * FROM tb_student WHERE Room_ID = '$c' AND Teacher_id = '$_SESSION[Teacher_id]'");
    while ($row = $find_student->fetch_array()) {
      $check = $this->conn->query("SELECT * FROM tb_check_student WHERE Room_ID = '$c' AND check_date = '$date' AND Teacher_id = '$_SESSION[Teacher_id]'");
      $rows = $check->fetch_array();
      if ($check->num_rows > 0) {
        if (($rows['check_date'] != date("Y-m-d"))) {
          $find_check = $this->conn->query("SELECT * FROM tb_check_student WHERE Room_ID = '$c' AND Teacher_id = '$_SESSION[Teacher_id]'");
          if($find_check->num_rows > 0){
            $row_find = $find_check->fetch_array();
            $count += $row_find['count_check'];
          }
          $update = $this->conn->query("UPDATE tb_check_student SET count_check = '$count' WHERE Teacher_id = '$_SESSION[Teacher_id]'");
          $insert = $this->conn->query("INSERT INTO tb_check_student(Student_id,Teacher_id,count_check,status,check_date)
                                         VALUES('$row[id]','$_SESSION[Teacher_id]','$count','$row[status]','$date')");
        }
      } else {
        echo 'insert';
        $find_check = $this->conn->query("SELECT * FROM tb_check_student WHERE Room_ID = '$c' AND Teacher_id = '$_SESSION[Teacher_id]'");
        if($find_check->num_rows > 0){
          $row_find = $find_check->fetch_array();
          $count += $row_find['count_check'];
        }
        $update = $this->conn->query("UPDATE tb_check_student SET count_check = '$count' WHERE Teacher_id = '$_SESSION[Teacher_id]'");
        $inserts = $this->conn->query("SELECT * FROM tb_student WHERE Room_ID = '$c' AND Teacher_id = '$_SESSION[Teacher_id]'");
        while ($row = $inserts->fetch_array()) {
          $insert = $this->conn->query("INSERT INTO tb_check_student(Student_id,Teacher_id,status,count_check,check_date,Room_ID)
                                     VALUES('$row[id]','$_SESSION[Teacher_id]','$row[status]','$count','$date','$c')");
        }
      }
    }
    $status = $this->conn->query("UPDATE tb_student SET status = 0");
    
    $d_m = date('d-m');
    $y = date('Y')+543;
    $date = $d_m .'-'.$y;
    $time = date('H:i');
    $find_room = $this->conn->query("SELECT * FROM tb_room WHERE Room_ID = '$c'");
    $r_room = $find_room->fetch_array();
    $room = $r_room['room'];
    $find_department = $this->conn->query("SELECT * FROM tb_department WHERE id = '$_SESSION[department]'");
    $r_department = $find_department->fetch_array();
    $department = $r_department['Department'];
    $line = $this->conn->query("SELECT * FROM tb_teacher WHERE id = '$_SESSION[Teacher_id]'");
    $token = $line->fetch_array();
    if(!empty($token['line_token']) || $token['line_token'] != null){
      $sToken = $token['line_token'];
      $sMessage = "วันที่ {$date} \n";
      $sMessage .= "เช็คชื่อเข้าแถว {$department} {$room} เรียบร้อย\n";
  
      $data = array(
          'message' => $sMessage,
      );
  
  
      $chOne = curl_init();
      curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
      curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($chOne, CURLOPT_POST, 1);
      curl_setopt($chOne, CURLOPT_POSTFIELDS, $data);
      $headers = array('Content-type: multipart/form-data', 'Authorization: Bearer ' . $sToken . '',);
      curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
      $result = curl_exec($chOne);
  
    }
    
    // $count = 1;
    // $no_check = 0;
    // $result = $this->conn->query("SELECT * FROM tb_check_student WHERE Teacher_id = '$_SESSION[Teacher_id]'");
    // if ($result->num_rows > 0) {
    //   $count_total = $result->fetch_array();
    //   $count = $count_total['count_check'] +1;
    //   $no_check = $count_total['count_check'];
    // }
    // $sql = "SELECT * FROM tb_student WHERE Teacher_id = '$_SESSION[Teacher_id]'";
    // $query = $this->conn->query($sql);
    // while ($row = $query->fetch_array()) {
    //   $result = $this->conn->query("SELECT * FROM tb_check_student WHERE Student_id = '$row[Student_id]'");
    //   $fetch = $result->fetch_array();
    //   if ($result->num_rows >= 1) {
    //     if ($row['status'] != 0) {
    //       $count_check_in = $fetch['count_check_in'] + 1;
    //       $sql_check = "UPDATE tb_check_student SET count_check = '$count', count_check_in = $count_check_in , Teacher_id = '$_SESSION[Teacher_id]' WHERE Student_id = '$row[Student_id]'";
    //     } else {
    //       $count_no_check = $fetch['count_no_check'] + 1;
    //       $sql_check = "UPDATE tb_check_student SET count_check = '$count', count_no_check = $count_no_check , Teacher_id = '$_SESSION[Teacher_id]' WHERE Student_id = '$row[Student_id]'";
    //     }
    //     echo $sql_check;
    //     $this->conn->query($sql_check);
    //   } else {
    //     if ($row['status'] != 0) {
    //       $sql_check_new = "INSERT INTO tb_check_student(Student_id,Name,Email,Teacher_id,count_check,count_check_in,count_no_check)
    //                               VALUES('$row[Student_id]','$row[Student_name]','$row[Email]','$row[Teacher_id]','$count',1,'$no_check')";
    //     } else {
    //       $sql_check_new = "INSERT INTO tb_check_student(Student_id,Name,Email,Teacher_id,count_check,count_check_in,count_no_check)
    //             VALUES('$row[Student_id]','$row[Student_name]','$row[Email]','$row[Teacher_id]','$count',0,1)";
    //     }
    //     $this->conn->query($sql_check_new);
    //   }
    // }
    // $reset_status = "UPDATE tb_student SET status = 0 WHERE Teacher_id = '$_SESSION[Teacher_id]'";
    // $this->conn->query($reset_status);
  }



  // เข้าสู่ระบบ อาจารย์
  function login($username, $password,$check)
  {
    $pass = md5($password);
    if($check === "on"){
      setcookie( "user", $username, time()+ 60*60*24*365, "/");
      setcookie( "pass", $password, time()+ 60*60*24*365, "/");
    }else{
      unset($_COOKIE['user']);
      unset($_COOKIE['pass']);
      setcookie("user",'', time()- 60*60*24*365, "/");
      setcookie( "pass", '', time()- 60*60*24*365, "/");
    }
    $query = $this->conn->query("SELECT * FROM tb_teacher WHERE username = '$username'");
    if ($query->num_rows >= 1) {
      $query_pass = $this->conn->query("SELECT * FROM tb_teacher WHERE username = '$username' AND password = '$pass'");
      if ($query_pass->num_rows >= 1) {
        $query_user = $this->conn->query("SELECT * FROM tb_teacher WHERE username = '$username' AND password = '$pass'");
        $user = $query_user->fetch_array();
        if ($user['type'] == 999) {
          $_SESSION['login'] = true;
          $_SESSION['type'] = 'Admin';
          $_SESSION['username'] = $user['username'];
          $_SESSION['Teacher_id'] = $user['id'];
          $_SESSION['Teacher_name'] = $user['Teacher_name'];
          echo 'admin';
        } else {
          $_SESSION['login'] = true;
          $_SESSION['type'] = 'Teacher';
          $_SESSION['username'] = $user['username'];
          $_SESSION['Teacher_name'] = $user['Teacher_name'];
          $_SESSION['department'] = $user['Department'];
          $_SESSION['lavel'] = $user['lavel'];
          $_SESSION['room1'] = $user['room1'];
          $_SESSION['room2'] = $user['room2'];
          $_SESSION['Teacher_id'] = $user['id'];
          echo 'teacher';
        }
      } else {
        echo "passwordfail";
      }
    } else {
      echo "userfail";
    }
  }

  // รีเซตการเข้าแถว และ เพิ่มเข้าสู่ประวัติ
  function resetStudent()
  {
    $query_year = $this->conn->query("SELECT * FROM tb_school_year");
    $row_year = $query_year->fetch_array();
    $year = $row_year['school_year'];

    $query_term = $this->conn->query("SELECT * FROM tb_term");
    $row_term = $query_term->fetch_array();
    $term = $row_term['term'];

    $check_insert = $this->conn->query("SELECT * FROM tb_year_term_history WHERE year = '$year' AND term = '$term' AND Teacher_id = '$_SESSION[Teacher_id]'");
    if($check_insert->num_rows >= 1){
      echo 'no';
    }else{
      $query_scan = $this->conn->query("SELECT * FROM `tb_opn_scan`");
      $row_scan = $query_scan->fetch_array();
      $open = $row_scan['open'];
      $close = $row_scan['close'];
  
      $this->conn->query("INSERT INTO tb_year_term_history(year,term,lavel,Teacher_id,open_scan,close_scan) VALUES('$year','$term','$_SESSION[lavel]','$_SESSION[Teacher_id]','$open','$close')");
  
      $query_check_student = $this->conn->query("SELECT * FROM tb_check_student WHERE Teacher_id = '$_SESSION[Teacher_id]'");
  
      foreach ($query_check_student as $row) {
        $query_count_check = $this->conn->query("SELECT * FROM tb_check_student WHERE Teacher_id = '$_SESSION[Teacher_id]' AND status = 1 AND Student_id = '$row[Student_id]'");
        $count_check = $query_count_check->num_rows;
        $query_count_no_check = $this->conn->query("SELECT * FROM tb_check_student WHERE Teacher_id = '$_SESSION[Teacher_id]' AND status = 0 AND Student_id = '$row[Student_id]'");
        $count_no_check = $query_count_no_check->num_rows;
        $student_id = $row['Student_id'];
        $teacher_id = $row['Teacher_id'];
        $total_count_check = $row['count_check'];
  
        $sql_check_history = "INSERT INTO tb_check_history(Student_id,Teacher_id,count_check,count_check_in,count_no_check,term,year)
                              VALUES('$student_id','$teacher_id','$total_count_check','$count_check','$count_no_check','$term','$year')";
        $this->conn->query($sql_check_history);
      }
      $sql = "DELETE FROM tb_check_student WHERE Teacher_id = '$_SESSION[Teacher_id]'";
      $this->conn->query($sql);
    }
  }

  // ลบข้อมูลการเช็คแถว
  function del_check_student()
  {
    $sql = "DELETE FROM tb_check_student WHERE Teacher_id = '$_SESSION[Teacher_id]'";
    $this->conn->query($sql);
  }

  // แก้ไขรหัสผ่าน
  function editPass($pass)
  {
    $password = md5($pass);
    $sql = "SELECT * FROM tb_teacher WHERE password = '$password' AND id = '$_SESSION[Teacher_id]'";
    $result = $this->conn->query($sql);
    if ($result->num_rows >= 1) {
      echo 'yes';
    } else {
      echo 'no';
    }
  }

  // อัพเดตรหัสผ่าน
  function updatePass($pass)
  {
    $password = md5($pass);
    $sql = "UPDATE tb_teacher SET password = '$password' WHERE id = '$_SESSION[Teacher_id]'";
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

  // อัพเดตสเตตัสประกาศ
  function updateAnnounce($id)
  {
    $check_st = $this->conn->query("SELECT * FROM tb_announce WHERE Teacher_id = '$_SESSION[Teacher_id]' AND status = 1");
    $check_update = $this->conn->query("SELECT * FROM tb_announce WHERE Teacher_id = '$_SESSION[Teacher_id]' AND id = '$id' AND status = 1");
    if ($check_st->num_rows <= 0) {
      $check = $this->conn->query("SELECT * FROM tb_announce WHERE Teacher_id = '$_SESSION[Teacher_id]' AND id = '$id'");
      $row = $check->fetch_array();
      $st = $row['status'];

      if ($st != 1) {
        $st_full = 1;
      } else if ($st != 0) {
        $st_full = 0;
      }
      $this->conn->query("UPDATE tb_announce SET status = '$st_full' WHERE Teacher_id = '$_SESSION[Teacher_id]' AND id = '$id'");
    } else if ($check_update->num_rows >= 1) {
      $this->conn->query("UPDATE tb_announce SET status = 0 WHERE Teacher_id = '$_SESSION[Teacher_id]' AND id = '$id'");
    } else {
      echo 'no';
    }
  }

  // แก้ไขประกาศ
  function editAnnounce($id)
  {
    $query = $this->conn->query("SELECT * FROM tb_announce WHERE id = '$id'");
    $row = $query->fetch_array();
    echo json_encode($row);
  }

  // เพิ่มประกาศ และ อัพเดตประกาศ
  function insertAndUpdateAnnounce($id, $head, $description)
  {
    if (!empty($id)) {
      $sql = "UPDATE tb_announce SET head = '$head' , description = '$description' WHERE id = '$id' AND Teacher_id = '$_SESSION[Teacher_id]'";
    } else {
      $sql = "INSERT INTO tb_announce(head,description,Teacher_id) VALUES('$head','$description','$_SESSION[Teacher_id]')";
      echo 'insert';
    }
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

  // บันทึกข้อมูลของเทอม
  function confirmReport($pass, $username)
  {
    $sql = "SELECT * FROM tb_teacher WHERE username = '$username' AND password = '$pass'";
    $query = $this->conn->query($sql);
    if ($query != false && $query->num_rows > 0) {
      echo 'yes';
    } else {
      echo 'no';
    }
  }

  // ลบประวัติการเช็คชื่อ
  function delHistory($id, $year, $term)
  {
    echo $id;
    $this->conn->query("DELETE FROM tb_year_term_history WHERE id = '$id'");
    $query_check_history = $this->conn->query("SELECT * FROM tb_check_history WHERE term = '$term' AND year = '$year'");
    $count = $query_check_history->num_rows;
    for ($i = 0; $i < $count; $i++) {
      $this->conn->query("DELETE FROM tb_check_history WHERE term = '$term' AND year = '$year'");
    }
  }

  // ค้นหาวันที่เช็คชื่อ
  function findReport($date)
  {
    $result = $this->conn->query("SELECT * FROM tb_check_student WHERE check_date = '$date' AND Teacher_id = '$_SESSION[Teacher_id]'");
    $oup = '';
    $i = 1;
    if ($result->num_rows > 0) {
      foreach ($result as $row) {
        echo $row['status'];
        $student = $this->conn->query("SELECT * FROM tb_student WHERE id = '$row[Student_id]' AND Teacher_id = '$_SESSION[Teacher_id]'");
        $data = $student->fetch_array();
        $oup .= '<tr>
        <td>' . $i++ . '</td>
        <td>' . $data['Student_id'] . '</td>
        <td>' . $data['Student_name'] . '</td>
        <td>
          <div class="form-check"><label class="form-check-label color-check">';
        if($row['status'] == 1){
          $oup .= '<input class="checkbox checkin" type="checkbox" checked data-id="'.$row['Student_id'].'" >';
        }else{
          $oup .= '<input class="checkbox checkin"  type="checkbox" data-id="'.$row['Student_id'].'" >';
        }
        $oup .= '</label>
        </div></td></tr>';
      }
    } else {
      $oup .= '<tr><td colspan="4">ไม่มีข้อมูล</td></tr>';
    }
    echo $oup;
  }


  function UpdateCheckin($id,$date){
    $sql = "UPDATE tb_check_student SET status = 1 WHERE Student_id = '$id' AND Teacher_id = '$_SESSION[Teacher_id]' AND check_date = '$date'";
    return $sql;
  }

  function cancelUpdateCheck($id,$date){
    $sql = "UPDATE tb_check_student SET status = 0 WHERE Student_id = '$id' AND Teacher_id = '$_SESSION[Teacher_id]' AND check_date = '$date'";
    return $sql;
  }


  function updateProfile($fullname,$phone,$id,$line){
    $sql = "UPDATE tb_teacher SET Teacher_name = '$fullname' , phone = '$phone' , line_token = '$line' WHERE id = '$id'";
    $query = $this->conn->query($sql);
    if($query){
      echo 'success';
    }else{
      echo 'error';
    }
    echo $sql;
  }

}

?>