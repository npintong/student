<?php
require_once("setPDF.php"); // ไฟล์สำหรับกำหนดรายละเอียด pdf 

// เพิ่มหน้าใน PDF 
$pdf->AddPage();

// กำหนด HTML code หรือรับค่าจากตัวแปรที่ส่งมา
//	กรณีกำหนดโดยตรง
//	ตัวอย่าง กรณีรับจากตัวแปร
// $htmlcontent =$_POST['HTMLcode'];
$html = "
<h4 style=\"text-align: center;\"><img src=\"../images/logo.gif\" width=\"60px\"></h4>
<h1><strong>FORM INFORM INTERNET PROBLEM</strong></h1>
<hr/>
<table border=\"0\" cellpadding=\"0\">
	<tr>
		<td>Subject Code</td>
		<td>Subject Name</td>
	</tr>
	<tr>
		<td>A1101</td>
		<td>Computer graphic</td>
	</tr>	
		<tr>
		<td>A1101</td>
		<td>Computer graphic</td>
	</tr>
<table>

";


// สร้างเนื้อหาจาก  HTML code
$pdf->writeHTML($html, true, 0, true, 0);

// เลื่อน pointer ไปหน้าสุดท้าย
$pdf->lastPage();

// ปิดและสร้างเอกสาร PDF
$pdf->Output('test.pdf', 'I');
?> 