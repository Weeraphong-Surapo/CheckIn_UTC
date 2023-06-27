<!DOCTYPE html>
<!--
	App by FreeHTML5.co
	Twitter: http://twitter.com/fh5co
	URL: http://freehtml5.co
-->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ยินดีต้อนรับเข้าระบบ เช็คอินเข้าแถวQrcode</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Bootstrap  -->
	<link rel="stylesheet" href="assets/css_main/bootstrap.css">
	<!-- Owl Carousel  -->
	<link rel="stylesheet" href="assets/css_main/owl.carousel.css">
	<link rel="stylesheet" href="assets/css_main/owl.theme.default.min.css">
	<!-- Animate.css -->
	<link rel="stylesheet" href="view/assets/css_main/animate.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

	<!-- Theme style  -->
	<link rel="stylesheet" href="assets/css_main/style.css">
</head>
<body>


<div id="page-wrap">


	<!-- ==========================================================================================================
													   HERO
		 ========================================================================================================== -->

	<div id="fh5co-hero-wrapper">
		<nav class="container navbar navbar-expand-lg main-navbar-nav navbar-light">
			<a class="navbar-brand" href="">ยินดีต้อนรับ</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav nav-items-center ml-auto mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="#">หน้าหลัก <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#" onclick="$('#fh5co-features').goTo();return false;">วิธีการใช้งาน</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#" onclick="$('#fh5co-download').goTo();return false;">เกี่ยวกับระบบ</a>
					</li>
					<!-- <li class="nav-item">
						<a class="nav-link" href="#"  onclick="$('#fh5co-download').goTo();return false;">ทำไมต้องใช้ระบบเรา</a>
					</li> -->
					<li class="nav-item">
						<a class="nav-link" href="main">เข้าสู่ระบบ</a>
					</li>
				</ul>
				<div class="social-icons-header">
					<a href="https://www.facebook.com/werupong.surapo/" target="_blank"><i class="fab fa-facebook-f"></i></a>
					<a href="https://www.instagram.com/invites/contact/?i=1hk9kd8gzj5et&utm_content=85x89hn5.co" target="_blank"><i class="fab fa-instagram"></i></a>
					<a href="https://line.me/ti/p/hm19S5OThq" target="_blank"><i class="fab fa-line"></i></a>
				</div>
			</div>
		</nav>

		<div class="container fh5co-hero-inner">
			<h1 class="animated fadeIn wow" data-wow-delay="0.4s">ระบบเช็คชื่อเข้าแถวQR CODE</h1>
			<!-- <p class="animated fadeIn wow" data-wow-delay="0.67s">เป็นโปรเจ็คจบหลักสูตรการศึกษา ปวส <br>สาขางาน คอมพิวเตอร์ ซอฟต์แวร์<br>พัฒนา Full Stack By.Weeraphong</p> -->
			<p class="animated fadeIn wow" data-wow-delay="0.67s">เป็นโปรเจ็คจบหลักสูตรการศึกษา ปวส <br>สาขางาน คอมพิวเตอร์ ซอฟต์แวร์</p>
			<button class="btn btn-md download-btn-first wow fadeInLeft animated" data-wow-delay="0.85s" onclick="$('#start').goTo();return false;">เริ่มต้นใช้งาน</button>
			<button class="btn btn-md features-btn-first animated fadeInLeft wow" onclick="gotoline()">เข้าไลน์ OA</button>
			<img class="fh5co-hero-smartphone animated fadeInRight wow" data-wow-delay="1s" src="assets/images/show.png" alt="Smartphone">
		</div>


	</div> <!-- first section wrapper -->


	<!-- ==========================================================================================================
													 ADVANTAGES
		 ========================================================================================================== -->

	<div class="fh5co-advantages-outer" id="start">
		<div class="container">
			<h1 class="second-title"><span class="span-perfect">เหตุผลที่ควรใช้ระบบเรา?</span> <span class="span-features">คุณสมบัติ</span></h1>
			<small></small>

			<div class="row fh5co-advantages-grid-columns wow animated fadeIn" data-wow-delay="0.36s">

				<div class="col-sm-4">
					<img class="grid-image" src="assets/images/icon-1.png" alt="Icon-1">
					<h1 class="grid-title">สะดวกสะบาย</h1>
					<p class="grid-desc">โดยนักศึกษาสามารถเชื่คชื่อใด้ผ่านมือถือตนเอง และสามารถดูสรุปผลการเข้าแถวตนใด้ด้วยตัวเอง</p>
				</div>

				<div class="col-sm-4">
					<img class="grid-image" src="assets/images/icon-2.png" alt="Icon-2">
					<h1 class="grid-title">มีการติดตามนักศึกษา</h1>
					<p class="grid-desc">เมื่อนักศึกษาไม่มาเช็คชื่อเข้าแถวบ่อยเกินไป จะมีอีเมล์ส่งแจ้งเตือนนักศึกษา</p>
				</div>

				<div class="col-sm-4">
					<img class="grid-image" src="assets/images/icon-3.png" alt="Icon-3">
					<h1 class="grid-title">มีความถูกต้องแม่นยำ</h1>
					<p class="grid-desc">มีการบันทึกข้อมูลของนักศึกษาที่ถูกต้อง และปลอดภัย</p>
				</div>


			</div>
		</div>
	</div>


	<!-- ==========================================================================================================
													  SLIDER
		 ========================================================================================================== -->

	<div class="fh5co-slider-outer wow fadeIn" data-wow-delay="0.36s">
		<h1>ระบบภายในต่างๆ</h1>
		<small>รวดเร็วทันใจ</small>
		<div class="container fh5co-slider-inner">

			<div class="owl-carousel owl-theme">
				<div class="item" style="justify-content: center; display: flex;"><img src="assets/images/show8.png" alt=""></div>
				<div class="item" style="justify-content: center; display: flex;"><img src="assets/images/show1.png" alt=""></div>
				<div class="item" style="justify-content: center; display: flex;"><img src="assets/images/show2.png" alt=""></div>
				<div class="item" style="justify-content: center; display: flex;"><img src="assets/images/show3.png" alt=""></div>
				<div class="item" style="justify-content: center; display: flex;"><img src="assets/images/show4.png" alt=""></div>
				<div class="item" style="justify-content: center; display: flex;"><img src="assets/images/show5.png" alt=""></div>
				<div class="item" style="justify-content: center; display: flex;"><img src="assets/images/show6.png" alt=""></div>
				<div class="item" style="justify-content: center; display: flex;"><img src="assets/images/show7.png" alt=""></div>
			</div>

		</div>
	</div>


	<!-- ==========================================================================================================
													  FEATURES
		 ========================================================================================================== -->

	<div class="curved-bg-div wow animated fadeIn" data-wow-delay="0.15s"></div>
	<div id="fh5co-features" class="fh5co-features-outer">
		<div class="container">

			<div class="row fh5co-features-grid-columns">

				<div class="col-sm-6 in-order-1 wow animated fadeInLeft" data-wow-delay="0.22s">
					<div class="col-sm-image-container">
						<img class="img-float-left" src="assets/images/show.png" alt="smartphone-1">
						<!-- <span class="span-new">NEW</span>
						<span class="span-free">Free</span> -->
					</div>
				</div>

				<div class="col-sm-6 in-order-1 sm-6-content wow animated fadeInRight" data-wow-delay="0.22s">
					<h1>เข้าใช้งานระบบ</h1>
					<p>กรอกรหัสประจำตัวของนักเรียน นักศึกษาเพื่อรับ OTP ที่จะส่งไปทางอีเมลล์วิทยาลัยของนักเรียนนักศึกษา</p>
					<span class="circle circle-first">1</span>
				</div>

				<div class="col-sm-6 in-order-4 sm-6-content wow animated fadeInLeft" data-wow-delay="0.22s">
					<h1>กรอกหมายเลข OTP เพื่อยืนยันตัวตน</h1>
					<p>กรอกหมายเลข OTP ที่ใด้รับในอีเมล์ของนักเรียนนักศึกษา</p>
					<span class="circle circle-first">2</span>
				</div>

				<div class="col-sm-6 in-order-2 wow animated fadeInRight" data-wow-delay="0.22s">
					<img class="img-float-right" src="assets/images/otp.png" alt="smartphone-2">
				</div>

				<div class="col-sm-6 in-order-4 wow animated fadeInLeft" data-wow-delay="0.22s">
					<div class="col-sm-image-container">
						<img class="img-float-left" src="assets/images/check.png" alt="smartphone-3">
						<span class="span-data">ข้อมูล</span>
						<span class="span-percent">100%</span>
					</div>
				</div>
				<div class="col-sm-6 in-order-3 sm-6-content wow animated fadeInRight" data-wow-delay="0.22s">
					<h1>เช็คอิน</h1>
					<p>กดที่คำว่า "เช็คชื่อ" เพื่อแสดงคิวอาร์โค้ดให้อาจารย์ที่ดูแลสแกนเช็คชื่อ ต้องอยู่ในสถานที่หน้าเสาธงวิทยาลัยเทคนิคอุบลราชธานี ระยะเวลาที่สามารถกดเปิดคิวอาร์โค้ดใด้ 06.00 น. - 08.00 น.</p>
					<span class="circle circle-first">3</span>
				</div>




			</div> <!-- row -->


		</div>
	</div>


	<!-- ==========================================================================================================
													  REVIEWS
		 ========================================================================================================== -->

	<div id="fh5co-reviews" class="fh5co-reviews-outer">
		<h1>ระบบรับรองการแสดงมือถือไหม?</h1>
		<small>ระบบของเรารองรับทั้ง 2 แพลตฟอร์ม มือถือและคอมพิวเตอร์</small>
		<div class="container fh5co-reviews-inner">
			<div class="row justify-content-center">
				<div class="col-sm-5 wow fadeIn animated" data-wow-delay="0.25s">
					<center>
						<img class="" src="assets/images/show.png" width="100" height="200" alt="Quote 1">
						<p class="testimonial-desc">การแสดงผลแบบมือถือ</p>
						<!-- <small class="testimonial-author">John Doe</small> -->
					</center>
					<img class="float-right" src="assets/images/quotes-2.jpg" alt="Quote 2">
				</div>
				<div class="col-sm-5 testimonial-2 wow fadeIn animated" data-wow-delay="0.67s">
					<center>
						<img class="" src="assets/images/comShow.png" alt="Quote 1">
						<p class="testimonial-desc">การแสดงผลแบบคอมพิวเตอร์</p>
						<!-- <small class="testimonial-author">Someone</small> -->
					</center>
					<img class="float-right" src="assets/images/quotes-2.jpg" alt="Quote 2">
				</div>
			</div>

		</div>
	</div>
	

	<!-- ==========================================================================================================
                                                 BOTTOM
    ========================================================================================================== -->

	<div id="fh5co-download" class="fh5co-bottom-outer">
		<div class="overlay">
			<div class="container fh5co-bottom-inner">
				<div class="row">
					<div class="col-sm-6">
						<h1>เกี่ยวกับระบบของเรา</h1>
						<p>ในปัจจุบันเทคโนโลยีสมัยใหม่ ก้าวหน้าอย่างรวดเร็ว ผลักดันให้เกิดการเปลี่ยนแปลงภายใต้บริบท เราจึงพัฒนาระบบเช็คชื่อเข้าแถวQrcode ขึ้นมา โดยจะเข้ามาช่วยอำนวยความสะดวกในเช็คชื่อของนักศึกษา และอาจารย์ในการเก็บข้อมูลการเข้าแถวของนักศึกษา โดยง่ายดาย</p>
						<!-- <a class="wow fadeIn animated" data-wow-delay="0.25s" href="#"><img class="app-store-btn" src="assets/images/iphone.png" width="100px" height="200" alt="App Store Icon"></a> -->
						<!-- <a class="wow fadeIn animated" data-wow-delay="0.67s" href="#"><img class="google-play-btn" src="com2.png" alt="Google Play Icon"></a> -->
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- ==========================================================================================================
                                               SECTION 7 - SUB FOOTER
    ========================================================================================================== -->

	<footer class="footer-outer">
		<div class="container footer-inner">

			<div class="footer-three-grid wow fadeIn animated" data-wow-delay="0.66s">
				<div class="column-1-3">
					<h1>CheckinUTC</h1>
				</div>
				<div class="column-2-3">
					<nav class="footer-nav">
						<ul>
							<a href="#" onclick="$('#fh5co-hero-wrapper').goTo();return false;"><li>หน้าหลัก</li></a>
							<a href="#" onclick="$('#fh5co-features').goTo();return false;"><li>วิธีการใช้งาน</li></a>
							<a href="#" onclick="$('#fh5co-reviews').goTo();return false;"><li>เกี่ยวกับระบบ</li></a>
							<a href="main.php"><li class="active">เข้าสู่ระบบ</li></a>
						</ul>
					</nav>
				</div>
				<div class="column-3-3">
					<div class="social-icons-footer">
					<a href="https://www.facebook.com/werupong.surapo/" target="_blank"><i class="fab fa-facebook-f"></i></a>
					<a href="https://www.instagram.com/invites/contact/?i=1hk9kd8gzj5et&utm_content=85x89hn5.co" target="_blank"><i class="fab fa-instagram"></i></a>
					<a href="https://line.me/ti/p/hm19S5OThq" target="_blank"><i class="fab fa-line"></i></a>
					</div>
				</div>
			</div>

			<span class="border-bottom-footer"></span>

			<p class="copyright">&copy; 2022 ระบบเช็คชื่อเข้าแถว Qrcode <a href="" target="_blank">ติดต่อคนสร้าง</a>.</p>

		</div>
	</footer>




</div> <!-- main page wrapper -->
	
	<script src="assets/js_main/jquery.min.js"></script>
	<script src="assets/js_main/bootstrap.js"></script>
	<script src="assets/js_main/owl.carousel.js"></script>
	<script src="assets/js_main/wow.min.js"></script>
	<script src="assets/js_main/main.js"></script>
</body>
<script>
	function gotoline(){
		window.open('https://liff.line.me/1645278921-kWRPP32q/?accountId=031lbztd')
	}
</script>
</html>
