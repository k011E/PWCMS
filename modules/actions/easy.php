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
$where = 'actions';
$menu = 'Оповещения';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if($db->query("SELECT `id` FROM `notifications` WHERE `id_us`=".$user['id']."")->num_rows==0){
	?>
	<div class="list1">Оповещений нет...</div>
	<?
}else{
	?>
	<div class="list1"><a href="/notifications/clear">Очистка</a></div>
	<?
}
$Pagination = new Pagination("SELECT * FROM `notifications` WHERE `id_us`=".$user['id']."", $_GET['page']);
$query = $db->query("SELECT * FROM `notifications` WHERE `id_us`=".$user['id']." ORDER BY `id` DESC LIMIT $Pagination->start, $Pagination->end");
while ($notification = $query->fetch_assoc()) {
	?>
	<div class="lst">
		<?=$Filter->outputText($notification['text'])?> [<?=datef($notification['time'])?>] <?if($notification['read']==0){?><font color="red"><b>[new!]</b></font><?}?>
	</div>
	<?
}
$db->query("UPDATE `notifications` SET `read`=1 WHERE `id_us`=".$user['id']." LIMIT $Pagination->start, $Pagination->end");
$Pagination->out('/notifications');
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>