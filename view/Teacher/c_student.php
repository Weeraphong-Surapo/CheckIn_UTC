<?php
// เรียกใช้งาน DB และ Controller
require_once('../../Controller/TeacherController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB;

date_default_timezone_set('Asia/bangkok');
$date = date('d-m-y');

?>
<style>
    div span a {
        display: none;
    }

    #qr-reader__status_span {
        display: none;
        /* width: auto !important; */
    }

    div#qr-reader {
        border: none !important;
    }

    div#qr-reader__dashboard_section_csr div button {
        background-color: red;
        border: none;
        padding: 10px;
        color: white;
        border-radius: 5px;
    }

    div#qr-shaded-region {
        /* border-width:70px 70px !important; */
    }

    video {
        width: 100% !important;
    }
</style>
<div class="container col-lg-12 col-12 col-md-12 ">
    <div id="qr-reader"></div>


    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">รายชื่อนักเรียน</h4>
                    <table class="table text-center p-0" id="myTable">
                        <thead>
                            <tr>
                                <th>เลข</th>
                                <th>รหัส</th>
                                <th class="name">ชื่อ</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <h1 id="test"></h1>
                        <tbody>
                            <?php
                            $i = 1;
                            $c = isset($_GET['c']) ? $_GET['c'] : '';
                            $sql = "SELECT * FROM tb_student WHERE Room_ID = '$c' AND Teacher_id = '$_SESSION[Teacher_id]' ORDER BY Student_id ASC";
                            $check_time = "SELECT * FROM tb_check_student WHERE Room_ID = '$c' AND Teacher_id = '$_SESSION[Teacher_id]' ORDER BY check_date DESC LIMIT 1";
                            $time = $DB->conn->query($check_time);
                            $time_check = $time->fetch_array();
                            $room = $time_check['Room_ID'];
                            if ($time->num_rows > 0) {
                                $count_check = $time_check['count_check'];
                            }
                            $day_result = '';
                            if ($time->num_rows >= 1) {
                                $date_check = $time_check['check_date'];
                                $day = date($date_check);
                                $day_result .= date('d-m-y', strtotime($day));
                            }
                            $query = $DB->conn->query($sql);
                            echo 'วันที่ ' . date_format(date_create(date('y-m-d')), "d/m/Y");
                            if ($day_result != $date) {
                                while ($row = $query->fetch_array()) :
                            ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $row['Student_id']; ?></td>
                                        <td class="name"><?= $row['Student_name']; ?></td>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label color-check">
                                                    <input data-id="<?= $row['Student_id']; ?>" class="checkbox checkin" type="checkbox" <?php echo $row['status'] == 1 ? 'checked' : ''; ?> data-id="<?= $row['id']; ?>">
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                endwhile;
                            } else { ?>
                                <tr class="p-3">
                                    <td colspan="4" class="fw-bold fs-6">เช็คชื่อวันที่ <?= $date; ?> แล้ว</td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                    <br>
                    <?php
                    if ($day_result != $date || $count_check == 0) {
                        if ($query->num_rows > 0) { ?>
                            <button class="add btn btn-insert" onclick="Swalconfrim(<?php echo $c; ?>)">บันทึก</button>
                    <?php } else {
                            echo '<p class="text-center fs-5 alert alert-warning">ยังไม่มีนักศึกษาในระบบ <a href="student.php">ไปเพิ่มนักศึกษาเลย!!</a></p>';
                        }
                    } else {
                        echo  '<a href="report.php" class="btn btn-primary w-100" >ดูสรุปผล</a>';
                    } ?>
                </div>
            </div>
        </div>
    </div>

</div>


<?php require_once('function/footer.php'); ?>
<script src="../assets/js/student.js"></script>
<script src="../assets/js/swal.js"></script>
<script>
    $('.checkin').click(function() {
        let id = $(this).attr('data-id')
        let attr_ = $(this).is(':checked')
        if (attr_) {
            $.ajax({
                url: 'function/action.php',
                type: 'post',
                data: {
                    id: id,
                    checkin: 1
                },
                success: function(res) {}
            })
        } else {
            $.ajax({
                url: 'function/action.php',
                type: 'post',
                data: {
                    id: id,
                    checkin: 1,
                    update: 1
                },
                success: function(res) {}
            })
        }
    })

    function Swalconfrim(c) {

        Swal.fire({
            title: 'คุณต้องการบันทึก?',
            text: '',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function/action.php',
                    type: 'post',
                    data: {
                        c: c,
                        insert: 1
                    },
                    success: function(data) {

                        alertsuccess('success', 'เช็คชื่อเรียบร้อย', '')
                        setTimeout(() => {
                            location.reload()
                        }, 800);


                    },
                    error: function(xhr, text) {
                        alert(text)
                    }
                })
            }
        })
    }

    function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === "complete" ||
            document.readyState === "interactive") {
            // call on next available tick
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    docReady(function() {
        var resultContainer = document.getElementById('qr-reader-results');
        var lastResult, countResults = 0;

        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;

                // document.getElementById('text').value = lastResult
                let option = {
                    url: 'function/action.php',
                    type: 'post',
                    dataType:'json',
                    data: {
                        lastResult: lastResult,
                        checkQrcode: 1
                    },
                    success: function(res) {
                        if (res.status != 0) {
                            console.log(res.student);
                            findStudentId(res.student)
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'เช็คชื่อสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Qrcode ไม่ถูกต้อง',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                        // console.log(res);
                    }
                }
                $.ajax(option)
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: 250
            });
        html5QrcodeScanner.render(onScanSuccess);
    });


    $(function() {
        $('div#qr-reader__dashboard_section_csr div button').text('สแกนเช็คชื่อ')
    })


    function alertsuccess(type, title, text) {
        Swal.fire(
            title,
            text,
            type
        )
    }

    function findStudentId(student_id) {
        $(".checkin").each(function() {
            if ($(this).attr('data-id') == student_id) {
                this.checked = true;
                // console.log(student_id);
            }
        });
    }



    // var cells = document.querySelectorAll("#myTable td");

    // function Search(search) {

    //     for (var i = 0; i < cells.length; ++i) {

    //         if (cells[i].textContent.toLowerCase().indexOf(search.toLowerCase()) === 0) {
    //             console.log('true');
    //             break;
    //         }
    //     }
    // }
    // Search('64301282004');
</script>