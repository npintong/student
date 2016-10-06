<!DOCTYPE html>
<html >
  <head>
    <meta charset="tis-620">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">

  </head>

  <body>

    
<div class="container">
  <div class="info">
    
  </div>
</div>
<div class="form">
  <div class="thumbnail"><img src="../images/logo.png" style="margin-top: -18px;"></div>
  
  <form class="register-form">
    <input type="text" placeholder="ชื่อผู้ใช้"/>
    <input type="password" placeholder="รหัสผ่าน"/>
    <input type="text" placeholder="ตอบคำถาม 59-99 = ?"/>
    <button>เข้าสู่ระบบผู้ดูแล</button>
    <p class="message">เข้าใช้งานสำหรับนักเรียน <a href="#">เข้าสู่ระบบผู้ดูแล</a></p>
  </form>
  <form class="login-form" method="POST" action="../login.php" autocomplete="off">
    <input type="text" name="username" placeholder="รหัสประจำตัวนักเรียน"/>
    <input type="password" name="password" placeholder="รหัสผ่าน"/>
    <button>เข้าสู่ระบบ</button>
    <p class="message">สำหรับผู้ดูแลระบบ <a href="#">เข้าสู่ระบบ</a></p>
  </form>
</div>
<video id="video" autoplay="autoplay" loop="loop" poster="polina.jpg">
  <source src="http://andytran.me/A%20peaceful%20nature%20timelapse%20video.mp4" type="video/mp4"/>
</video>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="js/index.js"></script>

    
    
  </body>
</html>
