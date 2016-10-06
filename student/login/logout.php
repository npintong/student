
<?php 
session_start();
session_destroy();

echo "<meta http-equiv='refresh' content='2;URL=index.php' />";

 ?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Log Out</title>
</head>
<body>
<?php
	echo "<center>";
	echo "ขอบคุณที่ใช้บริการ วิชาชุมนุม โรงเรียนนครขอนแก่น สพม.25";
	echo "<h2 style=\"text-align: center; color: red; border-bottom: 1px dashed #999;\"><strong>กำลังออกจากระบบ กรุณารอสักครู่...</strong></h2>";	
	echo "</center>";
?>
</body>
</html>