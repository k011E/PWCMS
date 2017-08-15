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
$r = $db->query("SELECT * FROM `forum_r` WHERE `id`='".$_GET['id']."'")->fetch_assoc();
include_once($_SERVER["DOCUMENT_ROOT"].'/system/class/Filter.php');
$title = 'Раздел "'.$Filter->output($r['name']).'"';
$menu = $title;
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(3);
?>
<div class="lst">
	<a href="/admin/forum/r/<?=$r['id']?>/new_pr">Создать подраздел</a>
</div>
<?
$query = $db->query("SELECT * FROM `forum_pr` WHERE `r`='".$_GET['id']."'");
if($query->num_rows==0){
	?>
	<div class="list1">Подразделов ещё нет</div>
	<?
}else{
	?>
	<div class="list1">Подразделы:</div>
	<?
}
while ($pr = $query->fetch_assoc()) {
	?>
	<div class="list1">
		<a href="/admin/forum/pr/<?=$pr['id']?>"><?=$Filter->output($pr['name'])?></a>
	</div>
	<?
}
?>
<div class="lst">
	<a href="/admin/forum/r/<?=$r['id']?>/edit">Редактировать раздел</a>
</div>
<div class="lst">
	<a href="/admin/forum/r/<?=$r['id']?>/del">Удалить раздел</a>
</div>
<div class="navg">
	<a href="/admin/forum/">Обратно</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>