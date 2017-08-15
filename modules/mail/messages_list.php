<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Список сообщений';
$where = 'mail';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="list1">
	<a href="/mail/messages_list">Обновить</a> | <a href="/mail/messages_list/noread">Непрочитанные</a>
</div>
<?
if(isset($_GET['noread'])){
	$Pagination = new Pagination("SELECT * FROM `mail_messages` WHERE `id_us`=".$user['id']." OR `id_by`=".$user['id']." AND `read`=0", $_GET['page']);
	$query = $db->query("SELECT * FROM `mail_messages` WHERE `id_us`=".$user['id']." OR `id_by`=".$user['id']." AND `read`=0 ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end);
}else{
	$Pagination = new Pagination("SELECT * FROM `mail_messages` WHERE `id_us`=".$user['id']." OR `id_by`=".$user['id']."", $_GET['page']);
	$query = $db->query("SELECT * FROM `mail_messages` WHERE `id_us`=".$user['id']." OR `id_by`=".$user['id']." ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end);
}
while ($message = $query->fetch_assoc()) {
	?>
	<div class="lst">
		<?=nick($message['id_by'])?> > <?=nick($message['id_us'])?> <?if($message['read']==0){?>[<font color="red"><b>Непрочитанное</b></font>]<?}?> [<?=datef($message['time'])?>] [<?if($message['id_by']==$user['id']){?><a href="/mail/msg/<?=$message['id_us']?>">написать ещё</a><?}else{?><a href="/mail/msg/<?=$message['id_by']?>">ответить</a><?}?>]<br>
		<?=$Filter->outputText($message['text'])?>
	</div>
	<?
}
if(isset($_GET['noread'])){
	$Pagination->out('/mail/messages_list/noread');
}else{
	$Pagination->out('/mail/messages_list');
}
if($query->num_rows==0){
	errorNoExit('У Вас нет сообщений');
}
?>
<div class="navg">
	<a href="/mail">Диалоги</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>