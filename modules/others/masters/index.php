<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Список мастеров';
$menu = 'Список мастеров';
$where = 'all_masters';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="list1">
	<a href="/search.php">Поиск мастера</a><br>
	Сортировать по:<br>
	<a href="/masters">ID</a> | <a href="/masters/new/">Новенькие</a> | <a href="/masters/rating">Авторитетные</a> | <a href="/masters/online">Онлайн</a>
</div>
<?
$Pagination = new Pagination("SELECT * FROM `users` ORDER BY `id`", $_GET['page']);
$query = $db->query("SELECT * FROM `users` ORDER BY `id` LIMIT ".$Pagination->start.", ".$Pagination->end."");
while ($u = $query->fetch_assoc()) {
	?>
	<div class="lst"><?=nick($u['id'])?> (id: <b><?=$u['id']?></b>)</div>
	<?
}
$Pagination->out('/masters');
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>