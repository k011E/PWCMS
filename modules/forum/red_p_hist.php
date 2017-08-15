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
$query = $db->query("SELECT * FROM `forum_p` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	header('location:/forum');
}
$p = $query->fetch_assoc();
$t = $db->query("SELECT * FROM `forum_t` WHERE `id`=".$p['id_thema']."")->fetch_assoc();
$title = 'Пост';
$where = 'forum';
$menu = '<a href="/forum/thema'.$t['id'].'/" style="color: white;">'.$Filter->output($t['name']).'</a> | Изменили пост '.$db->query("SELECT `id` FROM `forum_edit_p` WHERE `id_post`=".$p['id']."")->num_rows.' раз';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
if($db->query("SELECT `id` FROM `forum_edit_p` WHERE `id_post`=".$p['id']."")->num_rows==0){
	?>
	<div class="lst">
		Данное сообщение не изменяли!
	</div>
	<?
}else{
	?>
	<div class="lst">
		<?=nick($p['id_us'])?>: <?=$Filter->output($p['msg'])?> <small>(<?=datef($p['time'])?>)</small>
	</div>
	<div class="ram">
		<div class="raz">
			История изменений сообщения:
		</div>
	</div>
	<?
	$query = $db->query("SELECT * FROM `forum_edit_p` WHERE `id_post`=".$p['id']." ORDER BY `id` DESC");
	while ($edit = $query->fetch_assoc()) {
		?>
		<div class="lst">
			<?=nick($edit['id_us'])?> <small>(<?=datef($edit['time'])?>)</small>
		</div>
		<?
	}
}
?>
<div class="list1">
	<a href="/forum/thema<?=$t['id']?>">Вернуться в тему</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>