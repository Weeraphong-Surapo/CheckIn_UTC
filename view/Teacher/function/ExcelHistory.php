<?php
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="MyXls.xls"'); #ชื่อไฟล์
require_once('../../../Controller/TeacherController.php');
$DB = new DB;
$oup = '';
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
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<HTML>

<HEAD>
    <meta http-equiv="Content-type" content="text/html;charset=tis-620" />
</HEAD>

<BODY>
    <TABLE x:str BORDER="1">
        <?php
        $array = ['รหัสประจำตัว', 'ชื่อ - นามสกุล', 'รวมการเข้าแถว', 'รวมเข้าแถว', 'มา', 'ขาด', 'คิดเป็น %','ผลการประเมิน'];
        $array_head = ['วิทยาลัยเทคนิคอุบลราชธานี', 'สรุปการเข้าร่วมกิจกรรมหน้าเสาธง', 'ภาค/ปีการศึกษา : ', 'วันที่ : ', 'ระดับการศึกษา : ', 'ห้องเรียน : '];
        ?>
        <TR>
            <TD style="text-align: center;" colspan='7'><b>
                    <?php echo $array_head[0]; ?>
                </b></TD>
        </TR>
        <TR>
            <TD style="text-align: center;" colspan='7'><b>
                    <?php echo $array_head[1]; ?>
                </b></TD>
        </TR>
        <TR>
            <TD><b>
                    <?php echo $array_head[2] . $term . "/" . $year; ?>
                </b></TD>
            <TD><b>
                    <?php echo $array_head[3] . $d_open . " " . $show_mont_open . " " . $y_open . " - " . $d_close . " " . $show_mont_close . " " . $y_close; ?>
                </b></TD>
            <TD colspan='2'><b>
                    <?php echo $array_head[4] . $result_lavel; ?>
                </b></TD>
            <TD colspan='3'><b>
                    <?php echo $array_head[5] . $result_depart; ?>
                </b></TD>
        </TR>
        <TR>
            <TD rowspan='2'><b><?php echo $array[0]; ?></b></TD>
            <TD rowspan='2'><b><?php echo $array[1]; ?></b></TD>
            <TD colspan='5' style="text-align: center;"><b><?php echo $array[2]; ?></b></TD>
        </TR>
        <TR>
            <TD><b><?php echo $array[3]; ?></b></TD>
            <TD><b><?php echo $array[4]; ?></b></TD>
            <TD><b><?php echo $array[5]; ?></b></TD>
            <TD><b><?php echo $array[6]; ?></b></TD>
            <TD><b><?php echo $array[7]; ?></b></TD>
        </TR>
        <?php
        foreach ($query as $data) {
            $query_studnet = $DB->conn->query("SELECT * FROM tb_student WHERE id = '$data[Student_id]'");
            $row = $query_studnet->fetch_array();
            if ($data['count_check'] != 0) {
                $process = ($data['count_check_in'] * 100) / $data['count_check'];
                $percent = number_format($process, 2, '.', '');
            }
        ?>
            <TR>
                <TD><?php echo $row['Student_id']; ?></TD>
                <TD><?php echo $row['Student_name']; ?></TD>
                <TD><?php echo $data['count_check']; ?></TD>
                <TD><?php echo $data['count_check_in']; ?></TD>
                <TD><?php echo $data['count_no_check']; ?></TD>
                <?php
                if (isset($percent)) { ?>
                    <TD><?php echo $percent; ?> %</TD>
                <?php } else { ?>
                    <TD>0 %</TD>
                <?php }
                if ($percent < 60) {
                    $result_check = "ไม่ผ่าน"; ?>
                    <TD><?php echo $result_check; ?></TD>
                    <?php
                } else {
                    $result_check = "ผ่าน"; ?>
                    <TD><?php echo $result_check; ?></TD>
               <?php } ?>

            </TR>
        <?php } ?>
    </TABLE>
</BODY>

</HTML>