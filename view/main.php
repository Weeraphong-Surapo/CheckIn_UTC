<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบเช็คชื่อเข้าแถว</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style_main.css">

</head>

<body>
    <!-- As a link -->
    <nav class="navbar bg-light sticky-top shadow-sm" id="bg-nav">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="index">ระบบเช็คชื่อเข้าแถวด้วย QR CODE</a>
        </div>
    </nav>

    <!-- ============= content ======= -->
    <div class="container mt-5">
        <marquee behavior="" direction="" id="date" class="mt-3 mb-3">ยินดีต้อนรับเข้าสู่ระบบ ขณะนี้เวลา</marquee>
        <div class="row mt-4">
            <div class="co-lg-8 col-md-8 col-12">
                <div class="row">
                    <div class="container">
                        <!-- ======= text ====== -->
                        <b style="font-size: 20px;">ระบบเช็คชื่อเข้าแถว QR CODE</b>
                        <p>ระบบเช็คชื่อเข้าแถว Qrcode ของสถานศึกษา ที่มุ่งไปให้นักเรียนนักศึกษามีความกระตือรือร้นเข้าแถว และมีความประวินัย</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <a href="Student/index">
                            <div class="card card-login">
                                <div class="card-body">
                                    <img src="assets/images/student.png" alt="" class="card-img-top img-show" style="object-fit: cover;">
                                    <p class="text-center mt-3">นักเรียนนักศึกษา</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <a href="Teacher/index">
                            <div class="card card-login card-top">
                                <div class="card-body ">
                                    <img src="assets/images/teacher.png" alt="" style="object-fit: cover;" class="card-img-top img-show">
                                    <p class="text-center mt-3">คุณครูและผู้ดูแล</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="co-lg-4 col-md-4 col-12 ">
                <div class="card card-qrcode card-logins card-top">
                    <!-- <div class="card-header text-center">คิวอาร์โค้ดไลน์</div> -->
                    <div class="card-body">
                        <img src="assets/images/qrcodeline.png" alt="Qrcode Line" id="img-qrcode">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-muted footer py-5">
        <div class="container">
            <div class="d-flex justify-content-around">
                <div>
                    <p>รองรับการแสดงผล</p>
                    <img class="me-2" src="assets/images/google.png" alt="" style="width: 25px; height:25px;">
                    <img class="me-2" src="assets/images/microsoft.png" alt="" style="width: 25px; height:25px;">
                    <img class="me-2" src="assets/images/smartphone.png" alt="" style="width: 25px; height:25px;">
                    <img class="me-2" src="assets/images/notebook.png" alt="" style="width: 25px; height:25px;">
                </div>
                <div>
                    <p>คู่มือระบบ / ช่องทางติดต่อ</p>
                    
                    <a href="assets/images/คู่มือการใช้งานระบบเช็คชื่อ.pdf" class="me-2" target="_blank" download><img class="me-2" src="assets/images/download-pdf.png" alt="" style="width: 25px; height:25px;"> </a>
                    <a href="https://web.facebook.com/werupong.surapo/" class="me-2" target="_blank"><img src="assets/images/facebook.png" alt="" style="width: 25px; height:25px;"> </a>
                    <a href="https://line.me/ti/p/hm19S5OThq" class="me-2" target="_blank"><img src="assets/images/lines.png" alt="" style="width: 25px; height:25px;"> </a>
                    <a href="https://www.youtube.com/channel/UCPx75L2jIIqtYWv9wr_v8Jg" target="_blank"><img src="assets/images/youtube.png" alt="" style="width: 25px; height:25px;"> </a>
                </div>
                <div>
                    <p>สถิติผู้เข้าชม : <span id="visits"></span> ครั้ง (เริ่มนับจากวันที่ 1 มกราคม 2566)</p>
                    <p class="mb-1">© 2022 วิทยาลัยเทคนิคอุบลราชธานี</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
<script>
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    var time = today.getHours() + ':' + today.getMinutes();
    document.getElementById('date').innerHTML = "ยินดีต้อนรับเข้าสู่ระบบ ขณะนี้เวลา " + time + " น.";

    function cb(response) {
        document.getElementById('visits').innerText = response.value;
    }
</script>
<script async src="https://api.countapi.xyz/hit/bigshop.world/visits?callback=cb"></script>

</html>