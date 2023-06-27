<?php
// เรียกใช้งาน DB และ Controller
require_once('../../Controller/AdminController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB_Admin;
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

<div class="container">
    <div class="card p-3 shadow-sm">
        <div class="card-body">
            <h2>วันที่เปิด และ ปิด ภาคเรียน</h2>
            <hr>
            <p class="text-danger">จะมีผลตอนอาจารย์พิมพ์ PDF รายงานผล *</p>
            <p class="text-danger">คำเตือน!!! การคลิกใส่ปฏิทินจะเป็นเปลี่ยนวันที่โดยอัตโนมัติ *</p>
            <div class="row">
                <div class="col-12 col-lg-6 col-md-12">
                    <h5 class="text-center">วันที่เปิด <?php echo $d_open . " " . $show_mont_open . " " . $y_open; ?></h5>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>วันที่เปิด</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> <?php echo $d_open . " " . $show_mont_open . " " . $y_open; ?></td>
                                <td width="15%">
                                    <input type="date" name="date_open" id="date_open" class="form-control">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 col-lg-6 col-md-12">
                    <h5 class="text-center">วันที่ปิด <?php echo $d_close . " " . $show_mont_close . " " . $y_close; ?></h5>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>วันที่เปิด</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> <?php echo $d_close . " " . $show_mont_close . " " . $y_close; ?></td>
                                <td width="15%">
                                    <input type="date" name="date_close" id="date_close" class="form-control">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once('function/footer.php'); ?>
<!-- <script src="../assets/js/time.js"></script> -->