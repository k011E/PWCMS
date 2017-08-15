<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Журналисты газеты';
$menu = $title;
$where = 'gazeta';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$query = $db->query("SELECT `id` FROM `users` WHERE `journalist`>0");
while ($us = $query->fetch_assoc()) {
	?>
	<div class="list1">
		<?=nick($us['id'])?>
	</div>
	<?
}
?>
<div class="navg">
	<a href="/gazeta">Обратно</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>