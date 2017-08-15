<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Вложения';
$menu = 'Вложения в диалоге';
$where = 'mail';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$_GET['id'] = abs(intval($_GET['id']));
if($db->query("SELECT `id` FROM `users` WHERE `id`=".$_GET['id']."")->num_rows==0){
	error('Пользователя не сущетсвует');
}
$Pagination = new Pagination("SELECT * FROM `mail_messages` WHERE (`id_by`=".$user['id']." AND `id_us`=".$_GET['id']." AND `file` IS NOT NULL) OR (`id_by`=".$_GET['id']." AND `id_us`=".$user['id']." AND `file` IS NOT NULL)", $_GET['page']);
$query = $db->query("SELECT * FROM `mail_messages` WHERE (`id_by`=".$user['id']." AND `id_us`=".$_GET['id']." AND `file` IS NOT NULL) OR (`id_by`=".$_GET['id']." AND `id_us`=".$user['id']." AND `file` IS NOT NULL) ORDER BY `id` DESC LIMIT $Pagination->start, $Pagination->end");
while ($file = $query->fetch_assoc()) {
	?>
	<div class="lst">
		Файл: <a href="/files/mail/<?=$Filter->output($file['file'])?>"><?=$Filter->output($file['file'])?></a><br>
		Время отправки: <?=datef($file['time'])?><br>
		Отправитель: <?=nick($file['id_by'])?>
	</div>
	<?
}
if($query->num_rows == 0){
	errorNoExit('Вложений в этом диалоге не было');
}
$Pagination->out('/mail/files/user/'.$_GET['id']);
?>
<div class="navg">
	<a href="/mail/msg/<?=$_GET['id']?>">В диалог</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>