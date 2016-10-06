<?php

session_start();

if(!isset($_SESSION['ses_userid'])){
	echo " No Login";
	echo "<meta http-equiv='refresh' content='1;URL=./login/index.php' />";
	exit();
}else{
	
	$ses_userid =$_SESSION['ses_userid'];
	$ses_username = $_SESSION['ses_username'];
	$ses_fullname = $_SESSION['ses_fullname'];
	$ses_class = $_SESSION['ses_student_class'];
	
}

include_once('db_mysql_config.php');
$studen_id = '';
$subject_id = '';
$subject_name = '';
$teacher = '';
$reg_datetime = '';
$semaster = '';
$datereg=date("d/m/Y"); // Variable for Date Register
$timereg=date("H:i:s"); // Variable for Time Register

?>

<!DOCTYPE html>

<html lang="en">
<head>
	<title>ระบบลงทะเบียนวิชาชุมนุม</title>
	<meta charset="tis-620">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Reference Bootstrap CSS Framework-->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Reference Jquery Javascript Framework-->
	<script src="js/jquery.min.js"></script>
	<!-- Reference Bootstrap Javascript Framework-->
	<script src="js/bootstrap.min.js"></script>
	<!-- Reference Custom script JQuery-->
	<script src="js/student.js"></script>
	<!-- Reference Custom CSS -->
	<link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- menu header -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img src="images/logo.png" style="width: 70px; margin-top: -21px;"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php"><span class="glyphicon glyphicon-home"> หน้าหลัก</span></a></li>
        <li class="active"><a href="register_check.php"><span class="glyphicon glyphicon-equalizer"> ตรวจสอบแก้ไขการลงทะเบียน</span></a></li>
        <li><a href="reports_all.php"><span class="glyphicon glyphicon-th-list"> รายงานการลงทะเบียนทั้งหมด</span></a></li>

      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="./login/logout.php"><span class="glyphicon glyphicon-log-in"></span> ออกจากระบบ</a></li>
      </ul>
    </div>
	</div>
</nav>

<!-- detail center -->
<div class="jumbotron" style="margin-top: 32px; text-align: center; background-color: rgba(223, 224, 219,0.6);">
	<div class="panel panel-success">
    <div class="panel-body">
			<h5 style="text-align: center; color: gray;"><img src="images/logo.gif" width="100px"></h5>
			<h2 style="text-align: center;">ใบแสดงผลการลงทะเบียนกิจกรรมชุมนุม </h2>
			<h4 style="text-align: center; color: green;">ชื่อ  : <?php echo $ses_fullname ."  ชั้น ".$ses_class." รหัสประจำตัว : ".$ses_username; ?></h4>
		</div>
  </div>

</div>
<div class="container">
	<table class="table" id="mytable">
	    <thead>
	      <tr>
	        <th>รหัสนักเรียน</th>
	        <th>รหัสวิชา</th>
	        <th>ชื่อวิชา</th>
			<th>วัน / เวลา ที่สมัคร</th>
			<th style="text-align: center;">ภาคเรียน</th>
			<th style="text-align: center;">คลิกเพื่อยกเลิก</th>
	      </tr>
	    </thead>
	    <tbody>
				<?php

				// Subject & Amount of register query
				$sql="
					SELECT stu.Stu_ID,stu.Stu_Name,stu.Stu_LName,stu.Stu_Clase,stu.Stu_Room,
					reg.SubjectID,reg.Semester,reg.date_register,reg.reg_time,sbj.SubjectName,
					tch.TeacherName,tch.TeacherLName
					FROM student stu INNER JOIN register reg ON stu.Stu_ID=reg.StuID
					LEFT JOIN subject sbj ON reg.SubjectID= sbj.SubjectID
					LEFT JOIN teacher tch ON sbj.TeacherID=tch.TeacherID
					WHERE stu.Stu_ID='".$ses_username."'
					ORDER BY reg.reg_num DESC
					LIMIT 0,1;
				";
				$rs_subject = $db->query($sql)->fetchAll();
				$cnt = count($rs_subject);
				// debug
				// print_r($rs_subject);
				
				if($cnt == '0'){
					
					echo "<tr style=\"background-color: #e8edf4;\">";
					echo "	<td colspan=\"6\" style=\"text-align: center; color: #cc1e04;\"><strong>ไม่พบรายการ</strong></td>";
					echo "</tr>";
					
				}else{
					
				foreach($rs_subject as $rows){

					$studen_id = $rows['Stu_ID'];
					$subject_id = $rows['SubjectID'];
					$subject_name = $rows['SubjectName'];
					$teacher = $rows['TeacherName']." ".$rows['TeacherLName'];
					$reg_datetime = $rows['date_register']." ".$rows['reg_time'];
					$semaster = $rows['Semester'];


					echo "<tr>\n";
					echo "	<td><label><span class=\"badge badge-info\"><span class=\"glyphicon glyphicon-user\"></span> ".$studen_id."</span></label></td>\n";
					echo "	<td id=\"t_subject_name\"><strong>".$subject_id."</strong></td>\n";
					echo "	<td id=\"t_semaster_name\">".$subject_name."</td>\n";
					echo "	<td id=\"t_teacher_name\">".$reg_datetime."</td>\n";
					echo "	<td id=\"t_recieve_amount\" style=\"text-align: center;\"><span class=\"badge badge-success\"><span class=\"glyphicon glyphicon-flag\"></span> ".$semaster."</span></td>\n";
					echo "	<td id=\"t_register_count\" style=\"text-align: center;\"><a href=\"register_check.php?del=true&stuID=".$studen_id."&subject=".$subject_id."&semester=".$semaster."\" onclick=\"return confirm('คุณต้องการยกเลิกการลงทะเบียนรายการนี้ ใช่หรือไม่ ?');\"><label class=\"badge badge-danger\"><span class=\"glyphicon glyphicon-zoom-out\"></span> Cancel</label></a></td>\n";
					echo "</tr>\n";
				}
				}
				
				?>

	    </tbody>
		
	  </table>
	</div>
	
<div class="container">
	<div class="teacher-sign">
		<h5>(...................................................)</h5>
		<h5><strong><?php echo $teacher; ?></strong></h5>
		<h5><strong>ครูผู้สอน</strong></h5>
	</div>
	
</div>

<?php
	if(isset($_GET['del'])== true){
		
		$student_id = $_GET['stuID'];
		$subject = $_GET['subject'];
		$semester = $_GET['semester'];
		
		$sql = "DELETE FROM register WHERE StuID='".$student_id."' AND SubjectID='".$subject."' AND Semester='".$semester."';";
		$rs_subject = $db->query($sql);
		echo $sql;
		
		echo "<meta http-equiv=\"Refresh\" content=\"1; url=index.php\">";
				
	}
?>

<!-- Show result after click register confirm -->
<div class="container" style="height: 200px; margin-top: 10px;">
	<?php
		echo "<h5 style=\"text-align: center; color: gray;\"><a href=\"javascript:window.print();\" style=\"text-decoration: none;\"><img src=\"images/printer.png\"><br>(พิมพ์เอกสาร)</a></h5>";
	?>
</div>



<!-- Page footer -->
<footer class="container-fluid text-center">
  <p style="font-weight: bold;">โรงเรียนนครขอนแก่น สพม.25</p>
	<p style="font-weight: normal; color: #a4a6a8;">พิมพ์จาก ระบบลงทะเบียน วิชาชุมนุม วันที่พิมพ์ <?php echo $datereg." เวลา ".$timereg;?> </p>
</footer>

</body>
</html>
