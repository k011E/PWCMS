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
if($db->query("SELECT `id` FROM `users` WHERE `id`='".$_GET['id']."'")->num_rows==0){
	header('location:/');
}
$us = $db->query("SELECT * FROM `users` WHERE `id`='".$_GET['id']."'")->fetch_assoc();
$title = 'Награды '.$Filter->output($us['nick']);
$where = 'page_user';
$menu = 'Награды '.nick($us['id']);
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
if($us['admin']>=3){
	?>
	<div class="lst"><a href="/medals/<?=$us['id']?>/new">Вручить награду</a></div>
	<?
}
$Pagination = new Pagination("SELECT * FROM `medals` WHERE `id_us`='".$us['id']."'", $_GET['id']);
$query = $db->query("SELECT * FROM `medals` WHERE `id_us`='".$us['id']."' ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end."");
while ($medal = $query->fetch_assoc()) {
	?>
	<div class="lst">
		<img src="/design/images/medals/<?=$medal['medal']?>.png" alt="*"> Вручил: <?=nick($medal['id_adm'])?> (<?=datef($medal['time'])?>)<br>
		<b>За что: <font color="red"><?=$medal['for_what']?></font></b>
		<?
		if($user['admin']>=3){
			?>
			[<a href="/medals/<?=$us['id']?>/delete/<?=$medal['id']?>">x</a>] [<a href="/medals/<?=$us['id']?>/edit/<?=$medal['id']?>">ред</a>]
			<?
		}
		?>
	</div>
	<?
}
$Pagination->out('/medals/'.$us['id']);
if($Pagination->total==0){
	?>
	<div class="list1"><?=nick($us['id'])?> не награждался</div>
	<?
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>