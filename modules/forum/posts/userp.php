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
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT * FROM `users` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	header('location:/');
}
$us = $query->fetch_assoc();
$title = 'Сообщения '.$Filter->output($us['nick']);
$where = 'page_user';
$menu = '<a href="/" style="color: white">Главная</a> | <a href="/forum" style="color: white">Форум</a> | Сообщения '.nick($us['id']);
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="menu2">
	Всего <?=$db->query("SELECT `id` FROM `forum_p` WHERE `id_us`=".$us['id']."")->num_rows?> постов
</div>
<?
$Pagination = new Pagination("SELECT * FROM `forum_p` WHERE `id_us`=".$us['id']."",$_GET['page']);
$query = $db->query("SELECT * FROM `forum_p` WHERE `id_us`=".$us['id']." ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end."");
while ($post = $query->fetch_assoc()) {
	$thema = $db->query("SELECT * FROM `forum_t` WHERE `id`=".$post['id_thema']."")->fetch_assoc();
	?>
	<div class="lst">
		<?=imgT($post['id_thema'])?> Тема: <a href="/forum/thema<?=$thema['id']?>"><?=$Filter->output($thema['name'])?></a><br>
		<?=nick($post['id_us'])?> (<?=datef($post['time'])?>)<br>
		<?if($post['cit']!=0){
			$cit = $db->query("SELECT * FROM `forum_p` WHERE `id`=".$post['cit']."")->fetch_assoc();
			$citu = $db->query("SELECT `nick` FROM `users` WHERE `id`=".$cit['id_us']."")->fetch_assoc();
			?>
			Цитата:
			<div class="cit">
				<b><font color="red"><?=$Filter->output($citu['nick'])?></font></b>: <?=$Filter->output($cit['msg'])?>
			</div>
		<?}?>
		<?=$Filter->outputText($post['msg'])?>
	</div>
	<?
}
$Pagination->out('/posts'.$_GET['id']);
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>