<?php
///8 марта, сижу пью пивасик=), пишу cms///
include_once($_SERVER["DOCUMENT_ROOT"].'/system/includes_system.php');
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT `id`, `nick` FROM `users` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	header('location:/');
}
$us = $query->fetch_assoc();
$title = 'Подписчики '.$Filter->output($us['nick']);
$menu = 'Подписчики '.nick($us['id']).' ('.$db->query("SELECT `id` FROM `subscribes` WHERE `to`=".$us['id']."")->num_rows.')';
$where = 'page_user';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="list1">
	Подписчики
	|
	<a href="/us<?=$us['id']?>/subscriber"><?=$Filter->output($us['nick'])?> подписан на...</a>
</div>
<?
$Pagination = new Pagination("SELECT * FROM `subscribes` WHERE `to`=".$us['id']."", $_GET['page']);
$query = $db->query("SELECT * FROM `subscribes` WHERE `to`=".$us['id']." ORDER BY `id` DESC LIMIT $Pagination->start, $Pagination->end");
while ($sub = $query->fetch_assoc()) {
	?>
	<div class="lst">
		<?=nick($sub['subscriber'])?>
	</div>
	<?
}
$Pagination->out('/us'.$us['id'].'/subscribes');
if($query->num_rows==0){
	?>
	<div class="list1">
		У <?=nick($us['id'])?> нет подписчиков!
	</div>
	<?
}
?>
<div class="list1">
	<a href="/us<?=$us['id']?>">В анкету <?=$Filter->output($us['nick'])?></a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>