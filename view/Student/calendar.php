<?php
if(!isset($_SESSION))
{
session_start();
}
if(!isset($_SESSION['login']) && !isset($_SESSION['Student_id'])){
  header("Location: ../Student/login.php");
}
// เรียกใช้งาน DB และ Controller
require_once('../../Controller/StudentController.php');
$DB = new DB_STUDENT;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ปฏิทิน</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="fullcalendar/lib/main.min.css">
    <link rel="stylesheet" href="fullcalendar/lib/locales-all.js">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="fullcalendar/lib/main.min.js"></script>
    <script src="fullcalendar/lib/locales/th.js"></script>
    <link rel="stylesheet" href="../../view/assets/css/qrcode.css">
    <link
      href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css"
      rel="stylesheet"
    />
    <script>


    </script>
    <style>
        :root {
            --bs-success-rgb: 71, 222, 152 !important;
        }

        html,
        body {
            height: 100%;
            width: 100%;
        }

        .btn-info.text-light:hover,
        .btn-info.text-light:focus {
            background: #000;
        }

        table,
        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border-color: #ededed !important;
            border-style: solid;
            border-width: 1px !important;
        }
        body{
            z-index: 100;
            
        }
 
    </style>
</head>

<body style="background-color: #c6e3f8 !important;">
    <?php require_once('function/nav.php'); ?>
    <div class="container py-4 bg-light" id="page-container" >
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <table class="table">
                    <tr>
                        <td class="bg-primary"></td>
                        <td>กิจกรรม / วันหยุด</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-12 col-12 col-lg-12">
            <div id="calendar"></div>
        </div>
    </div>
    </div>
       <!-- Event Details Modal -->
       <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">รายรายละเอียด วันหยุด</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-0">
                    <div class="container-fluid">
                        <dl>
                            <dt class="text-muted">หัวข้อเรื่อง</dt>
                            <dd id="title" class="fw-bold fs-4"></dd>
                            <dt class="text-muted">รายละเอียด</dt>
                            <dd id="description" class=""></dd>
                            <dt class="text-muted">เริ่มวันที่</dt>
                            <dd id="start" class=""></dd>
                            <dt class="text-muted">สิ้นสุดวันที่</dt>
                            <dd id="end" class=""></dd>
                        </dl>
                    </div>
                </div>
                <div class="modal-footer rounded-0">
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->
    <?php

    $schedules = $DB->conn->query("SELECT * FROM `tb_schedule_list`");
    $sched_res = [];
    foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $row) {
        $row['sdate'] = date_format(date_create($row['start_datetime']),"d/m/Y H:i");
        $row['edate'] = date_format(date_create($row['end_datetime']),"d/m/Y H:i");
        $sched_res[$row['id']] = $row;
    }
    ?>
    
    <?php
    if (isset($DB->conn)) $DB->conn->close();
    ?>
</body>
<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./js/script.js"></script>
<script src="../assets/js/nav.js"></script>
<script>
        
</script>


</html>
<script>
        function logout() {
                Swal.fire({
                        title: 'ต้องการออกจากระบบ?',
                        text: "",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                        if (result.isConfirmed) {
                                $.ajax({
                                        url: 'function/action.php',
                                        type: 'post',
                                        data: {
                                                logout: 1
                                        },
                                        success: function(res) {
                                                Swal.fire(
                                                        'ออกจากระบบสำเร็จ!',
                                                        '',
                                                        'success'
                                                )
                                                setTimeout(() => {
                                                        location.reload()
                                                }, 700)
                                        }
                                })

                        }
                })

        }
</script>