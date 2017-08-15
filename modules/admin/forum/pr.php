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
$query = $db->query("SELECT * FROM `forum_pr` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0){
	header('location:/admin/forum');
}
$pr = $query->fetch_assoc();
$title = 'Подраздел "'.$Filter->output($pr['name']).'"';
$menu = $title;
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(3);
?>
<div class="list1">
	Название подраздела: <?=$Filter->output($pr['name'])?>
</div>
<div class="list1">
	Правила подраздела:<br>
	<?=$Filter->output($pr['rules'])?>
</div>
<div class="lst"><a href="/admin/forum/pr/<?=$pr['id']?>/del">Удалить подраздел</a></div>
<div class="lst"><a href="/admin/forum/pr/<?=$pr['id']?>/edit">Редактировать подраздел</div>
<div class="navg">
	<a href="/admin/forum/r/<?=$pr['r']?>">Обратно</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>