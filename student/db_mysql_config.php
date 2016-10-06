<?php
/******************************************
Create by Amnuay Pintong(Otik Network Co.,Ltd.)
DateTime : 02-10-2016 17.33 am.
*******************************************/
// กำหนดตัวแปรคงที่ไว้ สำหรับการเชื่อมต่อฐานข้อมูล
define('DB_MYSQL_HOST', '127.0.0.1');
define('DB_MYSQL_USER', 'root');
define('DB_MYSQL_PASSWORD', '');
define('DB_MYSQL_NAME', 'mystudent');

try{
	// สร้างการเชื่อมต่อฐานข้อมูล
	$db = new PDO("mysql:host=".DB_MYSQL_HOST.";dbname=".DB_MYSQL_NAME."","".DB_MYSQL_USER."","".DB_MYSQL_PASSWORD."");
	$db->exec("set names tis620");
	
}catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
    die();
}
