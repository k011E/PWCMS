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
$query = $db->query("SELECT * FROM `smiles_r` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0){
	header('location:/admin/smiles');
}
$r = $query->fetch_assoc();
$title = 'Раздел смайлов "'.$r['name'].'"';
$menu = $title;
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(3);
?>
<div class="lst">
	<a href="/admin/smiles/r/<?=$_GET['id']?>/add_smile">Добавить смайл</a>
</div>
<?
$Pagination = new Pagination("SELECT * FROM `smiles` WHERE `r`='".$r['id']."'", $_GET['page']);
$query = $db->query("SELECT * FROM `smiles` WHERE `r`='".$r['id']."' ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end."");
while ($smile = $query->fetch_assoc()) {
	?>
	<div class="list1">
		<img src="/files/smiles/<?=$Filter->output($smile['file'])?>"> - <?=$Filter->output($smile['name'])?><br>
		[<a href="/admin/smiles/edit_smile/<?=$smile['id']?>">ред</a>]
		[<a href="/admin/smiles/del_smile/<?=$smile['id']?>">уд</a>]
	</div>
	<?
}
?>
<div class="lst">
	<a href="/admin/smiles/r/<?=$_GET['id']?>/del">Удалить раздел</a>
</div>
<div class="lst">
	<a href="/admin/smiles/r/<?=$_GET['id']?>/edit">Редактировать раздел</a>
</div>
<div class="navg">
	<a href="/admin/smiles/">Обратно</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>