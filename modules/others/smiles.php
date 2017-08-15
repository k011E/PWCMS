<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Смайлы';
include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/extensions.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/functions.php');
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT * FROM `smiles_r` WHERE `id`='".$_GET['id']."'");
if($query->num_rows == 0){
	header('location:/all/smiles_r.php');
}
$r = $query->fetch_assoc();
$menu = '<a href="/all/smiles_r.php" style="color: white;">Категории</a> | '.$Filter->output($r['name']);
$where = 'kab';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$query = $db->query("SELECT * FROM `smiles` WHERE `r`='".$r['id']."'");
while ($smile = $query->fetch_assoc()) {
	?>
	<div class="lst">
		<?=$Filter->output($smile['name'])?> - <img src="/files/smiles/<?=$Filter->output($smile['file'])?>">
	</div>
	<?
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>