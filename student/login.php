
<?php
session_start();
?>

<!DOCTYPE html">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Session system Student</title>
</head>
<body>
<?php

include_once('db_mysql_config.php');

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM student  WHERE Stu_User='".$username."'  AND  Stu_Password='".$password."' LIMIT 0,1"; 
$result = $db->query($sql)->fetchAll();
$num = count($result);

if($num <=0) {
	echo "ไม่พบชื่อผู้ใช้นี้ในฐานข้อมูล";
	echo "<meta http-equiv='refresh' content='1;URL=./login/index.php' />"; 
}else {
	
	echo "<meta http-equiv='refresh' content='2;URL=./index.php' />";
		foreach($result as $data){
			
			$_SESSION['ses_userid'] = session_id();
			$_SESSION['ses_username'] = $data['Stu_ID'];
			$_SESSION['ses_fullname'] = $data['Stu_Name']." ".$data['Stu_LName'];
			$_SESSION['ses_student_class'] = $data['Stu_Clase']."/".$data['Stu_Room'];
			
			echo "<center>";
			echo "ยินดีต้อนรับ เข้าสู่ระบบลงทะเบียน วิชาชุมนุม โรงเรียนนครขอนแก่น สพม.25";
			echo "<h2>".$data['Stu_Name']." ".$data['Stu_LName']."</2>";
			echo "</center>";
			
		}
}	
?>
</body>
</html>
