<?php
require_once("setPDF.php"); // �������Ѻ��˹���������´ pdf 

// ����˹��� PDF 
$pdf->AddPage();

// ��˹� HTML code �����Ѻ��Ҩҡ����÷������
//	�óա�˹��µç
//	������ҧ �ó��Ѻ�ҡ�����
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


// ���ҧ�����Ҩҡ  HTML code
$pdf->writeHTML($html, true, 0, true, 0);

// ����͹ pointer �˹���ش����
$pdf->lastPage();

// �Դ������ҧ�͡��� PDF
$pdf->Output('test.pdf', 'I');
?> 