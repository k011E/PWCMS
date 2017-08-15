<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/extensions.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/functions.php');
$title = 'Логи авторизаций';
if(!isset($_GET['id'])){
	$menu = 'Логи авторизаций '.nick($user['id']);
}else{
	admin(1);
	$_GET['id'] = abs(intval($_GET['id']));
	$menu = 'Логи авторизаций '.nick($_GET['id']);
}
$where = 'lk';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if(!isset($_GET['id'])){
	$Pagination = new Pagination("SELECT * FROM `auth_success` WHERE `id_us`='".$user['id']."'",  $_GET['page']);
	$query = $db->query("SELECT * FROM `auth_success` WHERE `id_us`='".$user['id']."' ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end."");
}else{
	admin(1);
	if($db->query("SELECT `id` FROM `users` WHERE `id`=".$_GET['id']."")->num_rows==0){
		error('Пользователя не обнаружено');
	}
	$Pagination = new Pagination("SELECT * FROM `auth_success` WHERE `id_us`='".$_GET['id']."'",  $_GET['page']);
	$query = $db->query("SELECT * FROM `auth_success` WHERE `id_us`='".$_GET['id']."' ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end."");
}
while ($log = $query->fetch_assoc()) {
	?>
	<div class="lst">
		IP: <?=$Filter->output($log['ip'])?> [<a href="/servis/whois.php?ip=<?=$Filter->output($log['ip'])?>">.!.</a>]; Софт: <?=$Filter->output($log['ua'])?>; Вход: <?=datef($log['time'])?>
	</div>
	<?
}
if($Pagination->total!=0){
	$Pagination->out('/kab/log');
}else{
	?>
	<div class="list1">Логов не обнаружено</div>
	<?
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>