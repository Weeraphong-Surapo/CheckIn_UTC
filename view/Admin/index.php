<?php
// เรียกใช้งาน DB และ Controller
require_once('../../Controller/AdminController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB_Admin;
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
$date = date('d-m-y');
foreach ($months as $k => $v) {
    if (date('m') == $k) {
        $month =  $v;
    }
}

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

$date = date('Y-m-d');
$student = $DB->conn->query("SELECT * FROM tb_student");
$count_student = $student->num_rows;
$depart = $DB->conn->query("SELECT * FROM tb_department");
$count_depart = $depart->num_rows;
$teachers = $DB->conn->query("SELECT * FROM tb_teacher WHERE type != 1");
$count_teachers = $teachers->num_rows;
$lavels = $DB->conn->query("SELECT * FROM tb_lavel");
$count_lavels = $lavels->num_rows;

$count_check = $DB->conn->query("SELECT * FROM tb_check_student WHERE status = 1 AND check_date = '$date'");
$query_count_check = $count_check->num_rows;
$array = array(); 
array_push($array,$count_depart);
array_push($array,$count_lavels);
array_push($array,$count_teachers);
array_push($array,$count_student);
array_push($array,$query_count_check);
?>

<div class="container">
<div class="mb-2 "><i class='bx bx-home-heart ' style="font-size: 20px;"><span> สรุปภาพรวม</span></i></div>
    <div class="card p-3 mb-4">
        <div class="card-body">
              <div class="row">
              <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="card bg-card-1">
                        <div class="card-body">
                            <span>จำนวนสาขางาน</span>
                            <h2><?= $count_depart;?> สาขางาน</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="card bg-card-2">
                        <div class="card-body">
                            <span>จำนวนนักเรียนที่เข้าแถว</span>
                            <h2><?= $query_count_check;?> คน</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="card bg-card-3">
                        <div class="card-body">
                            <span>จำนวนอาจารย์ในระบบ</span>
                            <h2><?= $count_teachers?> คน</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 ">
                    <div class="card bg-card-4">
                        <div class="card-body">
                            <span>จำนวนนักเรียนในระบบ</span>
                            <h2><?= $count_student?> คน</h2>
                        </div>
                    </div>
                </div>
              </div>
        </div>
    </div>

    <div class="card p-3 mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6 col-md-6">
                    <h4 class="text-info">ยินดีต้อนรับเข้าระบบ ผู้ดูแลระบบ!!</h4>
                </div>
                <div class="col-12 col-lg-6 col-md-6">
                    <h5 class="show-date" >วันที่ <?= date('d') . " เดือน " . $month . " ปี " . date('Y')+543 ?></h5>
                </div>
            </div>
            <p>สวัสดี คุณ <?= $_SESSION['Teacher_name'];?></p>
            <h4 class="text-primary">ประจำปีการศึกษา <?php echo $row_year['school_year'];?> ภาคเรียนที่ <?php echo $row_term['term'];?></h4>
            <h4 class="text-success">ระหว่างวันที่ <?php echo $d_open." ".$show_mont_open." ".$y_open." - ".$d_close." ".$show_mont_close." ".$y_close;?></h4>
        </div>
    </div>

    <div class="card p-3 mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-7 mb-3">
                    <?php require('calendarshow.php'); ?>
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
</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php require_once('function/footer.php'); ?>
<script>
    // setup 
    const data = {
        labels: ['สาขา', 'ระดับชั้น', 'อาจารย์', 'นักเรียน','จำนวนนักเรียนเข้าแถว'],
        datasets: [{
            label: 'จำนวน',
            data: [<?= implode(',', $array)?>],
            backgroundColor: [
                'rgba(255, 26, 104, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgb(238, 130, 238)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(0, 0, 0, 0.2)'
            ],
            borderColor: [
                'rgba(255, 26, 104, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgb(238, 130, 238)',
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