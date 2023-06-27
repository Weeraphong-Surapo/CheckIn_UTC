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
                        }, 900);


                    },
                    error: function(xhr, text) {
                        alert(text)
                    }
                })
            }
        })
    }

    function onScanSuccess(decodedResult) {
        window.location.href = decodedResult;
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", {
            fps: 10,
            qrbox: 260
        });
    html5QrcodeScanner.render(onScanSuccess);

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
</script>
<?php 
if (isset($_GET['date'])) {
    if (isset($_GET['date']) && $_GET['date'] == $date) {
        $sql = "UPDATE tb_student SET status = 1 WHERE Student_id = '{$_GET['Student_id']}'";
        $query = $DB->conn->query($sql);
        echo '<script>alertsuccess("success", "เช็คชื่อเรียบร้อย", "")</script>';
    } else {
        echo '<script>alertsuccess("error", "QRcode ไม่ถูกต้อง", "")</script>';
    }
}
?>