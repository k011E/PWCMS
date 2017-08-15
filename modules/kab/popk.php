<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Подозрительные попытки входа';
$menu = $title;
$where = 'lk';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$Pagination = new Pagination("SELECT * FROM `auth_fail` WHERE `id_us`='".$user['id']."'", $_GET['id']);
$query = $db->query("SELECT * FROM `auth_fail` WHERE `id_us`='".$user['id']."' ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end."");
while ($log = $query->fetch_assoc()) {
	?>
	<div class="lst">
		IP: <?=$Filter->output($log['ip'])?> [<a href="/servis/whois.php?ip=<?=$Filter->output($log['ip'])?>">.!.</a>]; Софт: <?=$Filter->output($log['ua'])?>; Вход: <?=datef($log['time'])?>
	</div>
	<?
}
if($Pagination->total!=0){
	$Pagination->out('/kab/popk');
}else{
	?>
	<div class="list1">Всё нормусь, никто не пытался забрутить ваш акк...</div>
	<?
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>