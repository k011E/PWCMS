<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Управление смайлами';
$menu = $title;
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(3);
?>
<div class="lst"><a href="/admin/smiles/new_r">Создать раздел</a></div>
<?
$query = $db->query("SELECT * FROM `smiles_r`");
while ($r = $query->fetch_assoc()) {
	?>
	<div class="list1">
		<a href="/admin/smiles/r/<?=$r['id']?>"><?=$Filter->output($r['name'])?></a>
	</div>
	<?
}
?>
<div class="navg"><a href="/admin/">Обратно</a></div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>