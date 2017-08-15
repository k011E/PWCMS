<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
///8 марта, сижу пью пивасик=), пишу cms///
include_once($_SERVER["DOCUMENT_ROOT"].'/system/includes_system.php');
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT `id`, `nick` FROM `users` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	header('location:/');
}
$us = $query->fetch_assoc();
$title = $Filter->output($us['nick']).'подписан на';
$menu = nick($us['id']).' подписан на ('.$db->query("SELECT `id` FROM `subscribes` WHERE `to`=".$us['id']."")->num_rows.')';
$where = 'page_user';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="list1">
	<a href="/us<?=$us['id']?>/subscribes">Подписчики</a>
	|
	<?=$Filter->output($us['nick'])?> подписан на...
</div>
<?
$Pagination = new Pagination("SELECT * FROM `subscribes` WHERE `subscriber`=".$us['id']."", $_GET['page']);
$query = $db->query("SELECT * FROM `subscribes` WHERE `subscriber`=".$us['id']." ORDER BY `id` DESC LIMIT $Pagination->start, $Pagination->end");
while ($sub = $query->fetch_assoc()) {
	?>
	<div class="lst">
		<?=nick($sub['to'])?>
	</div>
	<?
}
$Pagination->out('/us'.$us['id'].'/subscriber');
if($query->num_rows==0){
	?>
	<div class="list1">
		<?=nick($us['id'])?> ни на кого не подписан!
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