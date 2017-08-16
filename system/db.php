<?php
$db = new mysqli("localhost", "root", "", "pw");
if($db->connect_errno){
	die("Ошибка подключения к БД: ".$db->connect_error);
}
$db->set_charset("utf8");
?>