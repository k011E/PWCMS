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
$query = $db->query("SELECT * FROM `users` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	header('location:/gazeta');
}
$us = $query->fetch_assoc();
$title = 'Статьи '.$Filter->output($us['nick']);
$menu = 'Статьи '.nick($us['id']).' ('.$db->query("SELECT `id` FROM `gazeta_articles` WHERE `id_author`=".$us['id']."")->num_rows.')';
$where = 'gazeta';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
$Pagination = new Pagination("SELECT * FROM `gazeta_articles` WHERE `id_author`=".$us['id']."", $_GET['page']);
$query = $db->query("SELECT * FROM `gazeta_articles` WHERE `id_author`=".$us['id']." ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end);
while ($article = $query->fetch_assoc()) {
	$section = $db->query("SELECT * FROM `gazeta_sections` WHERE `id`=".$article['id_r']."")->fetch_assoc();
	?>
	<div class="lst">
		Название: <a href="/gazeta/article/<?=$article['id']?>"><?=$Filter->output($article['name'])?></a> (<?=datef($article['time'])?>)<br>
		Категория: <a href="/gazeta/section/<?=$section['id']?>"><?=$Filter->output($section['name'])?></a>
	</div>
	<?
}
$Pagination->out('gazeta/articles_user');
?>
<div class="list1">
	<a href="/us<?=$us['id']?>">В анкету <?=$Filter->output($us['nick'])?></a>
</div>
<div class="list1">
	<a href="/gazeta">Газета</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>