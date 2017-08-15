<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Управление новостями';
$menu = 'Админ-панель | Управление новостями';
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(1);
?>
<div class="lst"><a href="/admin/news/new">Добавить</a></div>
<?
$Pagination = new Pagination("SELECT * FROM `news`", $_GET['page']);
$query = $db->query("SELECT * FROM `news` ORDER BY `id` DESC LIMIT $Pagination->start, $Pagination->end");
while ($news = $query->fetch_assoc()) {
	?>
	<div class="list1">
		<?=$news['content']?> [<a href="/admin/news/edit/<?=$news['id']?>">ред</a>] [<a href="/admin/news/delete/<?=$news['id']?>">x</a>]
	</div>
	<?
}
if($db->query("SELECT `id` FROM `news`")->num_rows==0){
	?>
	<div class="list1">Новостей пока нет</div>
	<?
}else{
	$Pagination->out('/admin/news');
}
?>
<div class="navg"><a href="/admin">Обратно</a></div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>