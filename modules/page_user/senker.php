<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
include_once($_SERVER["DOCUMENT_ROOT"].'/system/includes_system.php');
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT `id`, `nick` FROM `users` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	header('location:/');
}
$us = $query->fetch_assoc();
$title = 'Поблагодарил '.$us['nick'];
$menu = nick($us['id']).' поблагодарил '.$db->query("SELECT `id` FROM `senks` WHERE `id_sender`=".$us['id']."")->num_rows.' раз';
$where = 'senks';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="list1">
	<a href="/senks<?=$us['id']?>">Поблагодарили</a> | Поблагодарил
</div>
<?
$Pagination = new Pagination("SELECT * FROM `senks` WHERE `id_sender`=".$us['id']."", $_GET['page']);
$query = $db->query("SELECT * FROM `senks` WHERE `id_sender`=".$us['id']." ORDER BY `id` DESC LIMIT $Pagination->start, $Pagination->end");
while ($senk = $query->fetch_assoc()) {
	?>
	<div class="lst">
		Кого: <?=nick($senk['id_us'])?> (<?=datef($senk['time'])?>)<br>
		За что: <b><?=$Filter->outputText($senk['text'])?></b> [<a href="/del_sekn<?=$senk['id']?>">x</a>]
	</div>
	<?
}
if($query->num_rows==0){
	?>
	<div class="list1">
		Нет благодарностей!
	</div>
	<?
}
$Pagination->out('/senker'.$us['id']);
?>
<div class="list1">
	<a href="/us<?=$us['id']?>">В анкету <?=$Filter->output($us['nick'])?></a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>