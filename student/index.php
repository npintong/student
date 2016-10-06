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

if(isset($_POST['choose_semester'])){
	$semester = $_POST['choose_semester'];
}else{
	$semester = '0';
}

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
        <li class="active"><a href="index.php"><span class="glyphicon glyphicon-home"> หน้าหลัก</span></a></li>
        <li><a href="register_check.php"><span class="glyphicon glyphicon-equalizer"> ตรวจสอบแก้ไขการลงทะเบียน</span></a></li>
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
			<h2 style="text-align: center;">ยินดีต้อนรับ <?php echo $ses_fullname ."  (".$ses_class.")"; ?></h2>
			<h4 style="text-align: center; color: green;">รหัสประจำตัวนักเรียน : <?php echo $ses_username; ?></h4>
		</div>
  </div>

<form class="form-inline" method="POST" action="index.php" name="frmmain">
  <div class="form-group">
	<?php
		if(isset($_POST['choose_data'])){
			$choose_data = $_POST['choose_data'];
		}else{
			$choose_data = '0';
		}
	?>
    <label>ภาคการศึกษาที่</label>
    <select name="choose_semester" id="choose_semester" class="form-control" style="width: 200px;">
		<option value="0"> --- เลือกภาคการศึกษา --- </option>

		<?php
		
			// Get Semester
			$sql = "SELECT DISTINCT  Semester FROM subject ORDER BY Semester  ASC;";
			$rs_semester = $db->query($sql)->fetchAll();
			// Loop for Semester
			foreach($rs_semester as $rows){
				echo "<option value=\"".$rows['Semester']."\">".$rows['Semester']."</option>";
			}

		?>

	</select>
  </div>
  <button type="submit" class="btn btn-default" name="submit" id="btn_submit" disabled><span class="glyphicon glyphicon-zoom-in"></span> ค้นหา</button>
</form>
</div>
<div class="container">
	<table class="table" id="mytable">
	    <thead>
	      <tr>
	        <th>เลือกรหัสวิชา</th>
	        <th>ชื่อวิชา</th>
	        <th>ภาคเรียนที่</th>
			<th>ครูที่ปรึกาาคนที่ 1</th>
			<th style="text-align: center;">จำนวนที่รับสมัคร</th>
			<th style="text-align: center;">สมัครแล้ว</th>
	      </tr>
	    </thead>
	    <tbody>
				<?php

				// Subject & Amount of register query
				$sql="
					SELECT sub.num_sub_id, sub.SubjectID, sub.SubjectName,
					sub.SubjectUnit, sub.Semester, sub.Teacher1, sub.Teacher2,
					sub.Teacher3, sub.TeacherID, tch.TeacherName, tch.TeacherLName,
					IFNULL(COUNT(reg.StuID),0) reg_count
					FROM subject sub  INNER JOIN teacher tch ON tch.TeacherID = sub.TeacherID
					LEFT JOIN register reg ON sub.SubjectID = reg.SubjectID
					WHERE sub.Semester ='".$semester."'
					GROUP BY sub.num_sub_id, sub.SubjectID, sub.SubjectName,
					sub.SubjectUnit, sub.Semester, sub.Teacher1, sub.Teacher2,
					sub.Teacher3, sub.TeacherID, tch.TeacherName, tch.TeacherLName
					ORDER BY sub.SubjectID ASC;

				";
				$rs_subject = $db->query($sql)->fetchAll();
				// debug
				// print_r($rs_subject);
				
				if($semester == '0'){
					
					echo "<tr style=\"background-color: #e8edf4;\">";
					echo "	<td colspan=\"6\" style=\"text-align: center; color: #cc1e04;\"><strong>ไม่พบรายการ</strong></td>";
					echo "</tr>";
					
				}else{
					
				foreach($rs_subject as $rows){

					$subject_code = $rows['SubjectID'];
					$subject_name = $rows['SubjectName'];
					$semester_name = $rows['Semester'];
					$teacher = $rows['TeacherName']." ".$rows['TeacherLName'];
					$recieve_amount = $rows['SubjectUnit'];
					$register_now = $rows['reg_count'];

					echo "<tr>\n";
					echo "	<td><input type=\"radio\" name=\"subject_id\" id=\"subject_id\" value=\"".$subject_code."|".$ses_username."|".$semester_name."|".$recieve_amount."\" data-toggle=\"modal\" data-target=\"#myModal\"> <label><span class=\"badge badge-info\">".$subject_code."</span></label></td>\n";
					echo "	<td id=\"t_subject_name\"><strong>".$subject_name."</strong></td>\n";
					echo "	<td id=\"t_semaster_name\">".$semester_name."</td>\n";
					echo "	<td id=\"t_teacher_name\">".$teacher."</td>\n";
					echo "	<td id=\"t_recieve_amount\" style=\"text-align: center;\"><span class=\"badge badge-success\">".$recieve_amount."</span></td>\n";
					echo "	<td id=\"t_register_count\" style=\"text-align: center;\"><span class=\"badge badge-danger\">".$register_now."</span></td>\n";
					echo "</tr>\n";
				}
				}
				
				?>

	    </tbody>
	  </table>

</div>

<!-- Modal dialog registration -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-user"></span> ยินดีต้อนรับ : <?php echo $ses_fullname." (ชั้น ".$ses_class.")"; ?></h4>
          
        </div>
        <div class="modal-body" style="padding: 40px;">
			<form method="POST" action="index.php" name="frmmreg_modal">
			  <div class="form-group">
				<label>ยืนยันรหัสวิชา</label>
				<input type="text" class="form-control" name ="m_subject_id" id="m_subject_id" value="####" readonly="true">
				<input type="hidden" name="student_name" value="ด.ช.อำนวย ปิ่นทอง" id="student_name">
				<input type="hidden" name="recieve_amount" value="0" id="recieve_amount">
			  </div>
			  <div class="form-group">
				<label>ยืนยันรหัสนักเรียน</label>
				<input type="text" class="form-control" name="m_student_id" id="m_student_id" value="####" readonly="true">
			  </div>
				<div class="form-group">
				<label>ภาคการศึกษา</label>
				<input type="text" class="form-control" name="m_semaster" id="m_semaster" value="####" readonly="true">
			  </div>
			  <button type="submit" name="reg_submit" class="btn btn-success" id="reg_confirm"><span class="glyphicon glyphicon-floppy-saved"></span> ลงทะเบียน</button>
			</form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span> ปิดหน้าต่าง</button>
        </div>
      </div>
    </div>
  </div>
  

<!-- Show result after click register confirm -->
<div class="container">
	<?php
	// check post button
	if(isset($_POST['reg_submit'])){

		$student = $_POST['m_student_id']; // Variable for Student Code
		$subject = $_POST['m_subject_id']; // Variable for Subject Code
		$semaster = $_POST['m_semaster']; // Variable for Semaster
		$recieve_amount = $_POST['recieve_amount']; // Variable for Recieve Amount
		$datereg=date("d/m/Y"); // Variable for Date Register
		$timereg=date("H:i:s"); // Variable for Time Register

		
		$sql = "CALL register('".$student."','".$subject."','".$semaster."','".$datereg."','".$timereg."',$recieve_amount);";
		//echo $sql;
		
		$result = $db->query($sql)->fetchAll();
		$rs_code = $result[0][0]; // check insert status
		
		switch ($rs_code) {
			case 200: // insert complete.
				echo "<h2 style=\"text-align: center; color: green;\"><strong>ลงทะเบียนเรียบร้อยแล้ว ขอให้สนุกกับการเรียนน่ะจ๊ะ นักเรียนจ๋า..</strong></h2>";
				break;
			case 204: // Number of registration is over.
				echo "<h2 style=\"text-align: center; color: red;\"><strong>ไม่สามารถลงทะเบียนได้ เนื่องจาก วิชานี้มีผู้สมัครเต็มจำนวนแล้ว</strong></h2>";
				break;
			case 100: // not define.
				echo "<h2 style=\"text-align: center; color: red; border-bottom: 1px dashed #999;\"><strong>รหัสนักเรียน นี้ได้ลงทะเบียนแล้วครับ กรุณาตรวจสอบอีกครั้ง</strong></h2>";
				break;
			default: // if error show this error.
				echo "<h2 style=\"text-align: center; color: red; border-bottom: 1px dashed #999;\"><strong>ไม่สามารถทำรายการได้ ลองใหม่อีกครั้ง หากยังไม่ได้ กรุณาติตต่อผู้ดูแลระบบ</strong></h2>";	
		}		
		
		
	}else{
		// if not post show this details.
		echo "<h5 style=\"text-align: center; color: gray;\"><strong>ผลการลงทะเบียน</strong></h5>";
	}

	?>
</div>

<!-- Page footer -->
<footer class="container-fluid text-center">
  <p style="font-weight: bold;">Developed by Otik Network Co.,Ltd.</p>
	<p style="font-weight: normal; color: #a4a6a8;">Contact us : 02-5384378 (Auto) , 095-5499819</p>
</footer>


<!-- Script Jquery -->
<script>
	// start JQuery Script
	$(document).ready(function(){

		$("#choose_semester").change(function(){
				var data = $("#choose_semester").val();
				if(data != 0){
					$("#btn_submit").attr('disabled',false);
				}else{
					console.log("Zero data");
					$("#btn_submit").attr('disabled',true);
				}
		});

	
		$('#myModal').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget); // get value from radio button
				var recipient = button.data('whatever'); // get value from radio button
				var items = $(event.relatedTarget).val(); // get value from radio button
				var arr_subject = items.split("|"); // get value from radio button

				console.log(arr_subject); // debug

				$("#m_subject_id").val(arr_subject[0]);
				$("#m_student_id").val(arr_subject[1]);
				$("#m_semaster").val(arr_subject[2]);
				$("#recieve_amount").val(arr_subject[3]);

				var student_name = $("#student_name").val();
				var modal = $(this);
				//modal.find('.modal-title').html('<span class="glyphicon glyphicon-user"></span> xxx : ' + student_name);
				//modal.find('.modal-body input').val(items)
		});
	});
</script>
</body>
</html>
