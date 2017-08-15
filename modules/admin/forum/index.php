<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Управление форумом';
$menu = $title;
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(3);
?>
<div class="lst"><a href="/admin/forum/new_r">Создать раздел</a></div>
<?
$query = $db->query("SELECT * FROM `forum_r`");
while ($r = $query->fetch_assoc()) {
	?>
	<div class="list1">
		<a href="/admin/forum/r/<?=$r['id']?>"><?=$Filter->output($r['name'])?></a>
	</div>
	<?
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>