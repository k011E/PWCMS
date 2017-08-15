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
$online = $db->query("SELECT `id` FROM `users` WHERE `online`>".(time()-3600)."")->num_rows;
$title = 'Онлайн '.$online;
$menu = 'Онлайн '.$online.' человек';
$where = 'online';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$Pagination = new Pagination("SELECT * FROM `users` WHERE `online`>".(time()-3600)." ORDER BY `online`", $_GET['page']);
$query = $db->query("SELECT * FROM `users` WHERE `online`>".(time()-3600)." ORDER BY `online` DESC LIMIT ".$Pagination->start.", ".$Pagination->end."");
while ($u = $query->fetch_assoc()) {
	?>
	<div class="lst"><?=nick($u['id'])?> (<?=datef($u['online'])?>) [<font color="red"><b><?echo where($u['id'])?></b></font>]</div>
	<?
}
$Pagination->out('/online');
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>