<?php
/******************************************
Create by Amnuay Pintong(Otik Network Co.,Ltd.)
DateTime : 02-10-2016 17.33 am.
*******************************************/

// ตัวแปรติดต่อฐานข้อมูล
$db_host = "localhost";
$db_usrname = "root";
$db_passwd ="";
$db_name = "mystudent";

// สร้างตัวแปรเก็บการเชื่อมต่อฐานข้อมูล
$conn = mysql_connect($db_host,$db_usrname,$db_passwd);

// ตรวจสอบว่าสามารถเชื่อมต่อฐานข้อมูลได้หรือไ่ม่ ถ้าไม่ได้ให้แสดง error ขึ้นมาที่หน้าจอ
if(!$conn){
  die("Can not connect to database server.");
}

?>
