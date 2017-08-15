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
$query = $db->query("SELECT * FROM `forum_r` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0){
	header('location:/forum');
}
$r = $query->fetch_assoc();
$title = 'Раздел '.$Filter->output($r['name']);
$menu = '<a href="/forum" style="text-decoration:none; color:white;">Форум</a> | '.$Filter->output($r['name']);
$where = 'forum';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
$query = $db->query("SELECT * FROM `forum_pr` WHERE `r`='".$_GET['id']."'");
while ($pr = $query->fetch_assoc()) {
	?>
	<div class="menu2">
		<img src="/design/images/categ.png" alt="*" align="middle">
		<a href="/forum/<?=$r['id']?>/<?=$pr['id']?>/" style="text-decoration:none; color:white;"><?=$Filter->output($pr['name'])?></a>
	</div>
	<?
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>