<link rel="stylesheet" href="../../assets/css/nav.css">
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
$id = $_GET['id'];
$outp = "";
$time = date("H:i") . ' น.';
$day = date("d");
$mont = date("m");
$years = date("Y") + 543;
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



$query_year_term = $DB->conn->query("SELECT * FROM tb_year_term_history WHERE id = '$id'");
$row_year_term = $query_year_term->fetch_array();
$year = $row_year_term['year'];
$term = $row_year_term['term'];
$lavels = $row_year_term['lavel'];
$open = $row_year_term['open_scan'];
$close = $row_year_term['close_scan'];

$query = $DB->conn->query("SELECT * FROM tb_check_history WHERE year = '$year' AND term = '$term' AND Teacher_id = '$_SESSION[Teacher_id]'");

$teacher = $DB->conn->query("SELECT * FROM tb_teacher WHERE id = '$_SESSION[Teacher_id]'");
$row_teacher = $teacher->fetch_array();

$depart = $DB->conn->query("SELECT * FROM tb_department WHERE id = '$row_teacher[Department]'");
$row_depart = $depart->fetch_array();
$result_depart = $row_depart['Department'];

$lavel = $DB->conn->query("SELECT * FROM tb_lavel WHERE id = '$lavels'");
$row_lavel = $lavel->fetch_array();
$result_lavel = $row_lavel['lavel'];

$mont_open = explode("-", $open);
$y_open = $mont_open[0] + 543;
$r_mont_open = $mont_open[1];
$d_open = $mont_open[2];
$show_mont_open = "";


$mont_close = explode("-", $close);
$y_close = $mont_close[0] + 543;
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





$outp = "";
$outp .= "<style>
        table{
            width:100%;
        }
        .item{
            text-align:center;
            width:calc(100% / 3);
        }
    </style>";
$outp .= "<div style='text-align:center;'><b>วิทยาลัยเทคนิคอุบลราชธานี</b></div>";
$outp .= "<div style='text-align:center;'><b>รายงานสรุปการเข้าร่วมกิจกรรมหน้าเสาธง</b></div>";
$outp .= "<table>
    <tr class='box-item'>
    <td class='item'>ภาค/ปีการศึกษา : ภาคเรียนที่ " . $term . "/" . $year . "</td>
    <td class='item'>วันที่ : ".$d_open." ".$show_mont_open." ".$y_open." - ".$d_close." ".$show_mont_close." ".$y_close."</td>
    <td class='item'>พิมพ์วันที่ : " . $day . " " . $month . " " . $years . "</td>
    </tr>
    </table>";
$outp .= "<table>
    <tr class='box-item'>
    <td class='item'>ระดับการศึกษา : " . $result_lavel . "</td>
    <td class='item'>ห้องเรียน : " . $result_depart ."</td>
    <td class='item'>เวลา : " . date('H:i') . " น." . "</td>
    </tr>
    </table>";
$outp .= "<b class='grid-item-one'>ผลการประเมิน : 1.</b>เข้าร่วมกิจกรรมหน้าเสาธงไม่น้อยกว่า 60 %";
$outp .= "<table width='100%'>
        <tr style='background: #dfb1df;'>
          <th rowspan='2'>เลขประจำตัว</th>
          <th rowspan='2'>ชื่อ - นามสกุล</th>
          <th colspan='5'>การมาเข้าแถว</th>
        </tr>
        <tr style='background: #dfb1df;'>
          <th style='text-align:center;'>รวมเข้าแถว</th>
          <th style='text-align:center;'>มา</th>
          <th style='text-align:center;'>ขาด</th>
          <th style='text-align:center;'>คิดเป็น %</th>
          <th style='text-align:center;'>ผลการประเมิน</th>
        </tr >";
while ($data = $query->fetch_array()) {
    $query_studnet = $DB->conn->query("SELECT * FROM tb_student WHERE id = '$data[Student_id]'");
    $row = $query_studnet->fetch_array();
    if ($data['count_check_in'] != 0 || $data['count_check'] != 0) {
        $process = ($data['count_check_in'] * 100) / $data['count_check'];
        $percent = number_format($process, 2, '.', '');
    }
    $outp .= "<tr id='bodytable'><td style='text-align:center;'>{$row['Student_id']}</td>";
    $outp .= "<td >{$row['Student_name']}</td>";
    $outp .= "<td style='text-align:center;'>{$data['count_check']}</td>";
    $outp .= "<td style='text-align:center;'>{$data['count_check_in']}</td>";
    $outp .= "<td style='text-align:center;'>{$data['count_no_check']}</td>";
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
$mpdf->Output('รายงานเช็คชื่อ '.$result_depart.' '.$result_lavel.' ปีการศึกษา '.$year.' ภาคเรียน'.$term.'.pdf','D');
?>