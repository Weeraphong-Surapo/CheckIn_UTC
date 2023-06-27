<?php
if (!isset($_SESSION)) {
  session_start();
}
if (!isset($_SESSION['login']) && !isset($_SESSION['Student_id'])) {
  header("Location: ../Student/login.php");
}

date_default_timezone_set('Asia/bangkok');
$date = date('d-m-y');
$date_now = date('H:i');
require_once("../../Controller/connectDB.php");
$DB = new DB_CONNECT;
$time = $DB->conn->query("SELECT * FROM tb_time");
$r_time = $time->fetch_array();
$time_open = $r_time['time_open'];
$time_close = $r_time['time_close'];

$sql = "SELECT * FROM tb_student WHERE Student_id = '$_SESSION[Student_id]'";
$query = $DB->conn->query($sql);
$fetch = $query->fetch_array();
$area = $DB->conn->query("SELECT * FROM tb_area");
$r_area = $area->fetch_array();
$lat = $r_area['lat'];
$lng = $r_area['lng'];
$radius = $r_area['radius'];
?>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>สแกนเช็คชื่อ</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/css/qrcode.css">
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
</head>

<body onload="check()">
  <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

  <?php require_once('function/nav.php'); ?>
  <div class="form">


    <div id="map_canvas"></div>

    <!-- <h1 style="background-color: #4fe2f0;">วันที่ <?php echo $date; ?></h1> -->
    <h1 style="background-color: rgb(255, 74, 114);">รหัส <?php echo $_SESSION['Student_id']; ?></h1>
    <h1 style="background-color: #b66dff;">ชื่อ <?php echo $_SESSION['Student_name']; ?></h1>
    <h1 id="result" class="alert text-center rounded-0" style="background-color:orange;">กำลังตรวจสอบ...</h1>
    <button class="btn btn-primary mb-3 fw-5 Refresh" onclick="location.reload()" style="display: none;"><i class='bx bx-refresh' style="font-size: 20px;"></i> <span>รีเฟซ</span></button>
    <!-- <h1>QR Code Generator</h1> -->
    <form>
      <input type="hidden" id="number" name="number" value="<?php echo $fetch['Student_id']; ?>" />

      <div id="qrcode-container">
        <div id="qrcode" class="qrcode"></div>
      </div>

      <?php
       if ($date_now >= $time_open && $date_now <= $time_close) { 
        ?>
        <button type="button" id="checkin" style="display: none;" onclick="generateQRCode()"><i class='bx bxs-map' style="font-size: 20px;"></i> เช็คชื่อ</button>
      <?php } else { ?>
        <script>
          $('#result').css('display', 'none')
        </script>
        <button id="btn-close" id="closecheckin">ปิดสแกนเช็คชื่อ</button>
      <?php } ?>

    </form>
  </div>

  <?php require_once('function/footer.php'); ?>
  <script src="../assets/js/nav.js"></script>

  <!-- <div id="map" style="width:80%; height:80%"></div> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
  <script type="text/javascript">
    var demo = document.getElementById('result');

    function check() {
      navigator.geolocation.getCurrentPosition(function(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;

        
        let lat_fix = <?php echo $lat ?>;
        let lng_fix = <?php echo $lng ?>;
        let radius_fix = <?php echo $radius ?>;
        



        initialize()

        function initialize() {

          var latitude1 = lat_fix;
          var longitude1 = lng_fix;

          var latitude2 = lat;
          var longitude2 = lng;

          function getDistanceBetweenPoints(latitude1, longitude1, latitude2, longitude2, unit = 'meter') {
            let theta = longitude1 - longitude2;
            let distance = 60 * 1.1515 * (180 / Math.PI) * Math.acos(
              Math.sin(latitude1 * (Math.PI / 180)) * Math.sin(latitude2 * (Math.PI / 180)) +
              Math.cos(latitude1 * (Math.PI / 180)) * Math.cos(latitude2 * (Math.PI / 180)) * Math.cos(theta * (Math.PI / 180))
            );
            if (unit == 'miles') {
              return Math.round(distance, 2);
            } else if (unit == 'kilometers') {
              return Math.round(distance * 1.609344, 2);
            } else if (unit == 'meter') {
              return Math.round((distance * 1.609344) * 1000, 2);
            }
          }


          let check_area = getDistanceBetweenPoints(latitude1, longitude1, latitude2, longitude2);

          let meters = check_area - radius_fix;
          console.log(check_area);
          if (check_area > radius_fix) {
            result.innerHTML = 'ห่างจากจุด เช็คอิน ' + meters + ' เมตร';
            $('.Refresh').show()
          } else {
            $('.Refresh').hide()
            $('#result').hide()
            $('#checkin').show()
          }

        }
      });
    }

    function generateQRCode() {
      let date = '<?php echo $date; ?>';
      let room = '<?php echo $_SESSION['Room_ID']?>';
      let number = document.getElementById("number").value;
      let check = room + '&' + date + '&' + number; 
      if (number) {
        let qrcodeContainer = document.getElementById("qrcode");
        qrcodeContainer.innerHTML = "";
        new QRCode(qrcodeContainer, check);

        document.getElementById("qrcode-container").style.display = "block";
      } else {
        alert("Please enter a valid URL");
      }
    }
  </script>

</body>

</html>