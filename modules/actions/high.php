<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Оповещения';
$menu = $title;
$where = 'actions';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
$query = $db->query("SELECT * FROM `notifications_sections`");
while ($section = $query->fetch_assoc()) {
	$Notifications->section($section['id']);
}
if($user['admin']>=4){
	?>
	<div class="lst"><a href="/notifications/new_section">Добавить раздел</a></div>
	<?
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>