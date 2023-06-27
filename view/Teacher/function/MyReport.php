<link rel="stylesheet" href="../../assets/css/nav.css">
<!-- <div class='laynum'><img src='lynum2.png'></div> -->
<?php
require_once('../../../Controller/TeacherController.php');
$DB = new DB;
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

$room = $_GET['room'];
$find_room = "SELECT * FROM tb_room WHERE Room_ID = '$room'";
$query_room = $DB->conn->query($find_room);
$r_room = $query_room->fetch_array();

$sql = "SELECT * FROM tb_student WHERE Room_ID = '$room' AND Teacher_id = '$_SESSION[Teacher_id]' ORDER BY id ASC";
$result = $DB->conn->query($sql);

$sql_department = "SELECT * FROM tb_department WHERE id = '$_SESSION[department]'";
$department = $DB->conn->query($sql_department);
$result_department = $department->fetch_array();

$sql_lavel = "SELECT * FROM tb_lavel WHERE id = '$_SESSION[lavel]'";
$lavel = $DB->conn->query($sql_lavel);
$result_lavel = $lavel->fetch_array();


$year = $DB->conn->query("SELECT * FROM tb_school_year");
$result_year = $year->fetch_array();
$year_r = $result_year['school_year'];

$term = $DB->conn->query("SELECT * FROM tb_term");
$result_term = $term->fetch_array();
$result_t = $result_term['term'];

$teacher = $DB->conn->query("SELECT * FROM tb_teacher WHERE id = '$_SESSION[Teacher_id]'");
$row_teacher = $teacher->fetch_array();

$depart = $DB->conn->query("SELECT * FROM tb_department WHERE id = '$row_teacher[Department]'");
$row_depart = $depart->fetch_array();
$name_depart = $row_depart['Department'];

$lavel = $DB->conn->query("SELECT * FROM tb_lavel WHERE id = '$row_teacher[lavel]'");
$row_lavel = $lavel->fetch_array();
$name_lavel = $row_lavel['lavel'];

$query_open_scan = $DB->conn->query("SELECT * FROM `tb_opn_scan`");
$row_open_scan = $query_open_scan->fetch_array();
$open = $row_open_scan['open'];
$close = $row_open_scan['close'];

$mont_open = explode("-", $open);
$y_open = $mont_open[0]+543;
$r_mont_open = $mont_open[1];
$d_open = $mont_open[2];
$show_mont_open = "";


$mont_close = explode("-", $close);
$y_close = $mont_close[0]+543;
$r_mont_close = $mont_close[1];
$d_close = $mont_close[2];
$show_mont_close = "";



switch ($r_mont_open) {
    case "01":
        $show_mont_open = "มกราคม";
        break;
    case "02":
        $show_mont_open = "กุมภาพันธ์";
        break;
    case "03":
        $show_mont_open = "มีนาคม";
        break;
    case "04":
        $show_mont_open = "เมษายน";
        break;
    case "05":
        $show_mont_open = "พฤษภาคม";
        break;
    case "06":
        $show_mont_open = "มิถุนายน";
        break;
    case "07":
        $show_mont_open = "กรกฎาคม";
        break;
    case "08":
        $show_mont_open = "สิงหาคม";
        break;
    case "09":
        $show_mont_open = "กันยายน";
        break;
    case "10":
        $show_mont_open = "ตุลาคม";
        break;
    case "11":
        $show_mont_open = "พฤศจิกายน";
        break;
    case "12":
        $show_mont_open = "ธันวาคม";
        break;
}

switch ($r_mont_close) {
    case "01":
        $show_mont_close = "มกราคม";
        break;
    case "02":
        $show_mont_close = "กุมภาพันธ์";
        break;
    case "03":
        $show_mont_close = "มีนาคม";
        break;
    case "04":
        $show_mont_close = "เมษายน";
        break;
    case "05":
        $show_mont_close = "พฤษภาคม";
        break;
    case "06":
        $show_mont_close = "มิถุนายน";
        break;
    case "07":
        $show_mont_close = "กรกฎาคม";
        break;
    case "08":
        $show_mont_close = "สิงหาคม";
        break;
    case "09":
        $show_mont_close = "กันยายน";
        break;
    case "10":
        $show_mont_close = "ตุลาคม";
        break;
    case "11":
        $show_mont_close = "พฤศจิกายน";
        break;
    case "12":
        $show_mont_close = "ธันวาคม";
        break;
}





$time = date("H:i") . ' น.';
$day = date("d");
$mont = date("m");
$year = date("Y") + 543;
$date_date = getdate();

$month = "";
switch ($mont) {
    case "01":
        $month = "มกราคม";
        break;
    case "02":
        $month = "กุมภาพันธ์";
        break;
    case "03":
        $month = "มีนาคม";
        break;
    case "04":
        $month = "เมษายน";
        break;
    case "05":
        $month = "พฤษภาคม";
        break;
    case "06":
        $month = "มิถุนายน";
        break;
    case "07":
        $month = "กรกฎาคม";
        break;
    case "08":
        $month = "สิงหาคม";
        break;
    case "09":
        $month = "กันยายน";
        break;
    case "10":
        $month = "ตุลาคม";
        break;
    case "11":
        $month = "พฤศจิกายน";
        break;
    case "12":
        $month = "ธันวาคม";
        break;
}

$outp = "";
$outp .= "<style>
    body{
        position: relative;
    }
    table{
        width:100%;
    }
    .item{
        text-align:center;
        width:calc(100% / 3);
    }
    .laynum{
        width: 100%;
        height: 100vh;
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: -1;
    }
  

</style>";
$outp .= "<div style='text-align:center;'><b>วิทยาลัยเทคนิคอุบลราชธานี</b></div>";
$outp .= "<div style='text-align:center;'><b>รายงานสรุปการเข้าร่วมกิจกรรมหน้าเสาธง</b></div>";
$outp .= "<table>
<tr class='box-item'>
<td class='item'>ภาคเรียนที่ : ภาคเรียนที่ ".$result_t."/".$year_r."</td>
<td class='item'>วันที่ : ".$d_open." ".$show_mont_open." ".$y_open." - ".$d_close." ".$show_mont_close." ".$y_close."</td>
<td class='item'>พิมพ์วันที่ : " . $day . " " . $month . " " . $year . "</td>
</tr>
</table>";
$outp .= "<table>
<tr class='box-item'>
<td class='item'>ระดับการศึกษา : " . $name_lavel . "</td>
<td class='item'>ห้องเรียน : " . $name_depart .' '. $r_room['room']. "</td>
<td class='item'>เวลา : " . $time . "</td>
</tr>
</table>";
$outp .= "<b class='grid-item-one'>ผลการประเมิน : 1.</b>เข้าร่วมกิจกรรมหน้าเสาธงไม่น้อยกว่า 60 %";
$outp .= "<table width='100%' style='margin-top:10px;'>
        <tr style='background: #dfb1df;'>
          <th rowspan='2'>เลขประจำตัว</th>
          <th rowspan='2'>ชื่อ - นามสกุล</th>
          <th colspan='5'>การมาเข้าร่วมกิจกกรม</th>
        </tr>
        <tr style='background: #dfb1df;'>
          <th style='text-align:center;'>รวมเข้าแถว</th>
          <th style='text-align:center;'>มา</th>
          <th style='text-align:center;'>ขาด</th>
          <th style='text-align:center;'>คิดเป็น %</th>
          <th style='text-align:center;'>ผลการประเมิน</th>
        </tr >";
while ($row = $result->fetch_array()) {
    $query_count = $DB->conn->query("SELECT * FROM tb_check_student WHERE Room_ID = '$room' AND Teacher_id = '$_SESSION[Teacher_id]'");
    $query_count_check = $DB->conn->query("SELECT * FROM tb_check_student WHERE Room_ID = '$room' AND Student_id = '$row[id]' AND status = 1 AND Teacher_id = '$_SESSION[Teacher_id]'");
    $count_check = $query_count_check->num_rows;
    $query_count_no_check = $DB->conn->query("SELECT * FROM tb_check_student WHERE Room_ID = '$room' AND Student_id = '$row[id]' AND status = 0 AND Teacher_id = '$_SESSION[Teacher_id]'");
    $count_no_check = $query_count_no_check->num_rows;
    $check = $DB->conn->query("SELECT * FROM tb_check_student WHERE Room_ID = '$room' AND Student_id = '$row[id]' AND Teacher_id = '$_SESSION[Teacher_id]'");
    $r_count = $query_count->fetch_array();
    $count = $r_count['count_check'];
    if ($check->num_rows <= 0) {
        $count_no_check = $count;
    } else {
        $count_no_check = $count - $count_check;
    }
    if ($query_count->num_rows > 0) {
        $process = ($count_check * 100) / $count;
        $percent = number_format($process, 2, '.', '');
    }
    $outp .= "<tr id='bodytable'><td style='text-align:center;'>{$row['Student_id']}</td>";
    $outp .= "<td width='25%' class='name'>". $row['Student_name']."</td>";
    $outp .= "<td width='10%' style='text-align:center;'>". $count ."</td>";
    $outp .= "<td style='text-align:center;'>{$count_check}</td>";
    $outp .= "<td style='text-align:center;'>{$count_no_check}</td>";
    if (isset($percent)) {
        $outp .= "<td style='text-align:center;'>{$percent}%</td></tr>";
    } else {
        $outp .= "<td style='text-align:center;'>0 %</td></tr>";
    }
    if($percent < 60){
        $result_check = "ไม่ผ่าน";
        $outp .= "<td style='text-align:center; color:red;'>{$result_check}</td>";
    }else{
        $result_check = "ผ่าน";
        $outp .= "<td style='text-align:center;'>{$result_check}</td>";
    }
}
$outp .= "</table>";
$outp .= "<br><div style='text-align:right;'>ลงชื่อ.............................................</div>";
// echo $outp;
$mpdf->WriteHTML($outp);
$mpdf->Output('myfile.pdf', 'D');
?>