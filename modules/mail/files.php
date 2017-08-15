<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Файлы почты';
$menu = $title;
$where = 'mail';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="list1">
	<a href="/mail/files">Отправленные</a>
</div>
<div class="list1">
	<a href="/mail/files/received">Полученные</a>
</div>
<?
if(isset($_GET['received'])){
	$Pagination = new Pagination("SELECT * FROM `mail_messages` WHERE `id_us`=".$user['id']." AND `file` IS NOT NULL", $_GET['page']);
	$query = $db->query("SELECT * FROM `mail_messages` WHERE `id_us`=".$user['id']." AND `file` IS NOT NULL ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end."");
}else{
	$Pagination = new Pagination("SELECT * FROM `mail_messages` WHERE `id_by`=".$user['id']." AND `file` IS NOT NULL", $_GET['page']);
	$query = $db->query("SELECT * FROM `mail_messages` WHERE `id_by`=".$user['id']." AND `file` IS NOT NULL ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end."");
}
while ($message = $query->fetch_assoc()) {
	?>
	<div class="lst">
		Сообщение: <?=$Filter->outputText($message['text'])?><br>
		Файл: <a href="/files/mail/<?=$Filter->output($message['file'])?>"><?=$Filter->output($message['file'])?></a><br>
		Кому: <?=nick($message['id_us'])?><br>
		Кто: <?=nick($message['id_by'])?><br>
		Время отправки: <?=datef($message['time'])?>
	</div>
	<?
}
if(isset($_GET['received'])){
	$Pagination->out('/mail/files/received');
}else{
	$Pagination->out('/mail/files');
}
if($query->num_rows==0){
	if(isset($_GET['received'])){
		errorNoExit('Вы не получали файлы по почте');
	}
	else{
		errorNoExit('Вы не отправляли файлов в почте');
	}
}
?>
<div class="navg">
	<a href="/mail/">Диалоги</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>