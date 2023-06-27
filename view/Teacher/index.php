<?php
// เรียกใช้งาน DB และ Controller
require_once('../../Controller/TeacherController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB;
$student = $DB->conn->query("SELECT * FROM tb_student WHERE Teacher_id = '$_SESSION[Teacher_id]'");
$count_student = $student->num_rows;
$result = $DB->conn->query("SELECT * FROM tb_student WHERE Teacher_id = '$_SESSION[Teacher_id]'");
$count_check_minus = $DB->conn->query("SELECT * FROM tb_student WHERE Teacher_id = '$_SESSION[Teacher_id]' AND status = 1");
$count_minus = $count_check_minus->num_rows;
$count_not_pass = 0;
$count_pass = 0;
while ($row = $result->fetch_array()) :
    $checkin = $DB->conn->query("SELECT * FROM tb_check_student WHERE Teacher_id = '$_SESSION[Teacher_id]' AND Student_id = '$row[id]' AND status = 1");
    $count_checkin = $checkin->num_rows;
    $data_student = $DB->conn->query("SELECT * FROM tb_check_student WHERE Teacher_id = '$_SESSION[Teacher_id]' AND Student_id = '$row[id]'");
    $row_student = $data_student->fetch_array();
    if ($data_student->num_rows > 0) {
        if ($row_student['count_check'] != 0) {
            $percent = ($count_checkin * 100) / $row_student['count_check'];
            if ($percent < 60) {
                $count_not_pass += 1;
            } else {
                $count_pass += 1;
            }
        }
    }
endwhile;



$array = array();
array_push($array, $count_student);
array_push($array, $count_pass);
array_push($array, $count_not_pass);
?>

<div class="container">
    <div class="mb-2 "><i class='bx bx-home-heart ' style="font-size: 20px;"></i><span> สรุปภาพรวม</span></div>
    <div class="row">
        <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="card shadow-sm p-2">
                <div class="card-body">
                    <span>จำนวนนักเรียน</span>
                    <h2 style="color: #4099ff;"><?= $count_student; ?> คน</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="card shadow-sm p-2">
                <div class="card-body">
                    <span>นักเรียนที่ผ่านเกณฑ์ 60 % ขึ้นไป</span>
                    <h2 style="color: #2ed8b6;"><?= $count_pass; ?> คน</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="card shadow-sm p-2">
                <div class="card-body">
                    <span>นักเรียนที่เข้าต่ำกว่าเกณฑ์</span>
                    <h2 style="color: #ffb64d;"><?= $count_not_pass; ?> คน</h2>
                </div>
            </div>
        </div>
    </div>


    <?php

    $depart = $DB->conn->query("SELECT * FROM tb_department WHERE id = '$_SESSION[department]'");
    $row_depart = $depart->fetch_array();
    $lavel = $DB->conn->query("SELECT * FROM tb_lavel WHERE id = '$_SESSION[lavel]'");
    $row_lavel = $lavel->fetch_array();
    $months = array(
        1 => "มกราคม",
        2 => "กุมภาพันธ์",
        3 => "มีนาคม",
        4 => "เมษายน",
        5 => "พฤษภาคม",
        6 => "มิถุนายน",
        7 => "กรกฎาคม",
        8 => "สิงหาคม",
        9 => "กันยายน",
        10 => "ตุลาคม",
        11 => "พฤศจิกายน",
        12 => "ธันวาคม"
    );
    date_default_timezone_set('Asia/bangkok');
    $date = date('d-m-y');
    foreach ($months as $k => $v) {
        if (date('m') == $k) {
            $month =  $v;
        }
    }
    $i = 1;
    $sql = "SELECT * FROM tb_student WHERE Teacher_id = '$_SESSION[Teacher_id]' ORDER BY Student_id ASC";
    $check_time = "SELECT * FROM tb_check_student WHERE Teacher_id = '$_SESSION[Teacher_id]'";
    $time = $DB->conn->query($check_time);
    $time_check = $time->fetch_array();
    if ($time->num_rows > 0) {
        $count_check = $time_check['count_check'];
    }
    $day_result = '';
    if ($time->num_rows >= 1) {
        $date_check = $time_check['check_time'];
        $day = date($date_check);
        $day_result .= date('d-m-y', strtotime($day));
    }
    $query = $DB->conn->query($sql);
    $query_year = $DB->conn->query("SELECT * FROM tb_school_year");
    $row_year = $query_year->fetch_array();
    $query_term = $DB->conn->query("SELECT * FROM tb_term");
    $row_term = $query_term->fetch_array();

    $query_open_scan = $DB->conn->query("SELECT * FROM `tb_opn_scan`");
    $row_open_scan = $query_open_scan->fetch_array();
    $open = $row_open_scan['open'];
    $close = $row_open_scan['close'];
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
    <div class="card p-3">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6 col-md-6">
                    <h4 class="text-info">ยินดีต้อนรับ คุณ <?= $_SESSION['Teacher_name']; ?></h4>
                </div>
                <div class="col-12 col-lg-6 col-md-6">
                    <h5 class="show-date">วันที่ <?= date('d') . " เดือน " . $month . " ปี " . date('Y') ?></h5>
                </div>
            </div>
            <hr>
            <h5 style="color:rgb(255, 74, 184);">ห้องที่ดูแล : <?php echo $row_lavel['lavel'] . ' / ' . $row_depart['Department']; ?></h5>
            <h4 class="text-primary">ประจำปีการศึกษา <?php echo $row_year['school_year']; ?> ภาคเรียนที่ <?php echo $row_term['term']; ?></h4>
            <h4 class="text-success">ระหว่างวันที่ <?php echo $d_open . " " . $show_mont_open . " " . $y_open . " - " . $d_close . " " . $show_mont_close . " " . $y_close; ?></h4>
            <?php
            if ($day_result != $date || $count_check == 0) {
                echo '<div class="alert alert-danger">วันนี้คุณยังไม่ใด้เช็คชื่อนักเรียบนนะ!! <a href="c_student.php">ไปเช็คชื่อนักเรียน</a></div>';
                echo '';
            } else {
                echo '<div class="alert alert-success">วันนี้คุณเช็คชื่อนักเรียนแล้ว</div>';
            }
            ?>
        </div>
    </div>

    <div class="card p-3 mb-3 mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-7">
                    <?php require('calendar.php'); ?>
                </div>
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="chartBox">
                        <h2 class="text-center alert alert-primary">กราฟรายงาน</h2>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- <div class="chartCard"> -->

    <!-- </div> -->





</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php require_once('function/footer.php'); ?>
<script src="../assets/js/student.js"></script>
<script>
    // setup 
    const data = {
        labels: ['นักเรียน', 'ผ่านเกณฑ์', 'ต่ำกว่าเกณฑ์'],
        datasets: [{
            label: 'จำนวน',
            data: [<?= implode(',', $array) ?>],
            backgroundColor: [
                'rgba(153, 102, 255, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 26, 104, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(0, 0, 0, 0.2)'
            ],
            borderColor: [
                'rgba(153, 102, 255, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 26, 104, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(0, 0, 0, 1)'
            ],
            borderWidth: 1
        }]
    };

    // config 
    const config = {
        type: 'pie',
        data,
        options: {

        },
        //   plugin:[ChartDataLables]
    };

    // render init block
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>
<section class="overlay"></section>