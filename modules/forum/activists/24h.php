<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Топ активистов за сегодня';
$where = 'forum';
$menu = 'Топ активистов за 24ч.';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$query = $db->query("SELECT id_us, count(id) AS count FROM forum_p where `time` > ".(time()-86400)." GROUP BY id_us ORDER BY count DESC LIMIT 10");
while ($us = $query->fetch_assoc()) {
	?>
	<div class="lst">
		<?=nick($us['id_us'])?> (<?=$us['count']?> сообщений за 24ч)
	</div>
	<?
}
?>
<div class="list1">
	<a href="/ratings">Назад</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>