<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
include_once($_SERVER["DOCUMENT_ROOT"].'/system/includes_system.php');
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT * FROM `gazeta_sections` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	header('location:/gazeta');
}
$section = $query->fetch_assoc();
$title = 'Газета';
$menu = $Filter->output($section['name']);
$where = 'gazeta';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if($user['journalist']>=1){
	?>
	<div class="list1">
		<a href="/gazeta/admin/new_article/<?=$section['id']?>">Добавить статью</a>
	</div>
	<?
}
$Pagination = new Pagination("SELECT * FROM `gazeta_articles` WHERE `id_r`=".$_GET['id']."", $_GET['page']);
$query = $db->query("SELECT * FROM `gazeta_articles` WHERE `id_r`=".$_GET['id']." ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end."");
while ($article = $query->fetch_assoc()) {
	?>
	<div class="lst"><img src="/design/images/newspaper.png"> <a href="/gazeta/article/<?=$article['id']?>"><?=$Filter->output($article['name'])?></a> (<small><?=datef($article['time'])?></small>)</div>
	<?
}
$Pagination->out('gazeta/section');
if($query->num_rows==0){
	?>
	<div class="lst">
		В данной категории нет статей!
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