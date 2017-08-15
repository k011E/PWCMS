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
$title = 'Переходы по страницам';
$menu = 'Переходы '.nick($user['id']);
$where = 'lk';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$Pagination = new Pagination("SELECT `id` FROM `log` WHERE `id_us`='".$user['id']."'", $_GET['page']);
$query = $db->query("SELECT * FROM `log` WHERE `id_us`='".$user['id']."' ORDER BY `time` DESC LIMIT ".$Pagination->start.", ".$Pagination->end."");
while ($log = $query->fetch_assoc()) {
	?>
	<div class="lst">
		Страница: <?=$Filter->output($log['page'])?>; Время: <?=datef($log['time'])?>
	</div>
	<?
}
$Pagination->out('/kab/myper');
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>