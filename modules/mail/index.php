<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Почта';
$where = 'mail';
$menu = $title;
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$Pagination = new Pagination("SELECT * FROM `mail_contacts` WHERE `id_us`=".$user['id']."", $_GET['page']);
$query = $db->query("SELECT * FROM `mail_contacts` WHERE `id_us`=".$user['id']." ORDER BY `last` DESC LIMIT ".$Pagination->start.", ".$Pagination->end);
while ($cont = $query->fetch_assoc()) {
	?>
	<div class="lst">
		<?=nick($cont['id_by'])?> [<a href="/mail/msg/<?=$cont['id_by']?>">диалог</a>] [<b><?=$db->query("SELECT `id` FROM `mail_messages` WHERE `id_us`=".$user['id']." AND `id_by`=".$cont['id_by']." AND `read`=0")->num_rows?></b>/<?=$db->query("SELECT `id` FROM `mail_messages` WHERE `id_us`=".$user['id']." AND `id_by`=".$cont['id_by']." OR `id_us`=".$cont['id_by']." AND `id_by`=".$user['id']."")->num_rows?>] [<?=datef($cont['last'])?>] [<a href="/mail/delete_cont/<?=$cont['id_by']?>">x</a>]
	</div>
	<?
}

if($query->num_rows==0){
	?>
		<div class="lst">Контактов нет...</div>
	<?
}

$Pagination->out('/mail');
?>
<div class="list1" align="center">
	<a href="/mail/messages_list"><img src="/design/images/mail.png"></a>
	<a href="/search.php"><img src="/design/images/find.png"></a>
	<a href="/kab/ignor_list"><img src="/design/images/remove.png"></a>
	<a href="/mail/favorite/list"><img src="/design/images/like.png"></a>
	<a href="/mail/files/"><img src="/design/images/files4.png"></a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>