<script>
var map; // กำหนดตัวแปร map ไว้ด้านนอกฟังก์ชัน เพื่อให้สามารถเรียกใช้งาน จากส่วนอื่นได้
var GGM; // กำหนดตัวแปร GGM ไว้เก็บ google.maps Object จะได้เรียกใช้งานได้ง่ายขึ้น
function initialize() { // ฟังก์ชันแสดงแผนที่
  GGM = new Object(google.maps); // เก็บตัวแปร google.maps Object ไว้ในตัวแปร GGM
  // กำหนดจุดเริ่มต้นของแผนที่
  var my_Latlng = new GGM.LatLng(15.241, 104.8456);
  var my_mapTypeId = GGM.MapTypeId.ROADMAP; // กำหนดรูปแบบแผนที่ที่แสดง
  // กำหนด DOM object ที่จะเอาแผนที่ไปแสดง ที่นี้คือ div id=map_canvas
  var my_DivObj = $("#map_canvas")[0];
  // กำหนด Option ของแผนที่
  var myOptions = {
    zoom: 13, // กำหนดขนาดการ zoom
    center: my_Latlng, // กำหนดจุดกึ่งกลาง
    mapTypeId: my_mapTypeId // กำหนดรูปแบบแผนที่
  };
  map = new GGM.Map(my_DivObj, myOptions); // สร้างแผนที่และเก็บตัวแปรไว้ในชื่อ map



  // เรียกใช้คุณสมบัติ ระบุตำแหน่ง ของ html 5 ถ้ามี
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new GGM.LatLng(position.coords.latitude, position.coords.longitude);
      var infowindow = new GGM.InfoWindow({
        map: map,
        position: pos,
        content: 'คุณอยู่ที่นี่.'
      });

      var my_Point = infowindow.getPosition(); // หาตำแหน่งของตัว marker เมื่อกดลากแล้วปล่อย
      map.panTo(my_Point); // ให้แผนที่แสดงไปที่ตัว marker 
      // my_Point.lat() >= 15.241 && my_Point.lat() <= 15.242 && my_Point.lng() 
      // >= 104.8454 && my_Point.lng() <= 104.8456
      let a = <?= $area_a; ?>;
      let b = <?= $area_b; ?>;
      let c = <?= $area_c; ?>;
      let d = <?= $area_d; ?>;
      if ((my_Point.lat() >= a && my_Point.lat() <= b) && (my_Point.lng() >= c && my_Point.lng() <= d)) {
        // if($check){
        $('#closecheckin').css('display', 'none')
        $('#checkin').css('display', 'block')
        $('#result').remove()
        $('.Refresh').css('display', 'none')
      } else {
        $('#closecheckin').css('display', 'block')
        $('#checkin').css('display', 'none')
        $('#result').text('ไม่อยู่ในพื้นที่')
        $('.Refresh').css('display', 'block')
      }
      // $("#lat_value").val(my_Point.lat());  // เอาค่า latitude ตัว marker แสดงใน textbox id=lat_value
      // $("#lon_value").val(my_Point.lng()); // เอาค่า longitude ตัว marker แสดงใน textbox id=lon_value 
      // $("#zoom_value").val(map.getZoom()); // เอาขนาด zoom ของแผนที่แสดงใน textbox id=zoom_value              
      map.setCenter(pos);
    }, function() {
      // คำสั่งทำงาน ถ้า ระบบระบุตำแหน่ง geolocation ผิดพลาด หรือไม่ทำงาน
    });
  } else {
    // คำสั่งทำงาน ถ้า บราวเซอร์ ไม่สนับสนุน ระบุตำแหน่ง
  }

  // กำหนด event ให้กับตัวแผนที่ เมื่อมีการเปลี่ยนแปลงการ zoom
  GGM.event.addListener(map, 'zoom_changed', function() {
    $("#zoom_value").val(map.getZoom()); // เอาขนาด zoom ของแผนที่แสดงใน textbox id=zoom_value  
  });

}
$(function() {
  // โหลด สคริป google map api เมื่อเว็บโหลดเรียบร้อยแล้ว
  // ค่าตัวแปร ที่ส่งไปในไฟล์ google map api
  // v=3.2&sensor=false&language=th&callback=initialize
  //  v เวอร์ชัน่ 3.2
  //  sensor กำหนดให้สามารถแสดงตำแหน่งทำเปิดแผนที่อยู่ได้ เหมาะสำหรับมือถือ ปกติใช้ false
  //  language ภาษา th ,en เป็นต้น
  //  callback ให้เรียกใช้ฟังก์ชันแสดง แผนที่ initialize
  $("<script/>", {
    "type": "text/javascript",
    src: "//maps.google.com/maps/api/js?v=3.2&sensor=false&language=th&callback=initialize"
  }).appendTo("body");
});



function generateQRCode() {
  let date = '<?php echo $date; ?>';
  let check = '?date=' + date + '&Student_id=';
  let number = document.getElementById("number").value;
  if (number) {
    let qrcodeContainer = document.getElementById("qrcode");
    qrcodeContainer.innerHTML = "";
    new QRCode(qrcodeContainer, check + number);

    document.getElementById("qrcode-container").style.display = "block";
  } else {
    alert("Please enter a valid URL");
  }
}
</script>