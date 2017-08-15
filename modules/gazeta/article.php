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
$query = $db->query("SELECT * FROM `gazeta_articles` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	header('location:/gazeta');
}
$article = $query->fetch_assoc();
$section = $db->query("SELECT * FROM `gazeta_sections` WHERE `id`=".$article['id_r']."")->fetch_assoc();
$title = $Filter->output($article['name']);
$menu = '<a href="/gazeta" style="color: white;">Газета</a> | <a href="/gazeta/section/'.$section['id'].'" style="color: white;">'.$Filter->output($section['name']).'</a> | '.$article['name'];
$where = 'gazeta';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$db->query("UPDATE `gazeta_articles` SET `views`=`views`+1 WHERE `id`=".$article['id']."");
?>
<div class="list1">
	<img src="/design/images/newspaper.png"> <b><?=$Filter->output($article['name'])?></b>
	<div class="lst">
		<?if(file_exists($_SERVER["DOCUMENT_ROOT"].'/files/gazeta/'.$article['id'].'.jpg')){?>
			<img src="/files/gazeta/<?=$article['id']?>.jpg" style="max-width: 208px; max-height: 208px;" alt="*"><br>
		<?}?>
		<?=$Filter->outputText($article['text'])?>
	</div>
</div>
<div class="lst">
	Просмотров: <?=$article['views']?>
</div>
<div class="lst">
	Дата публикации: <?=datef($article['time'])?>
</div>
<div class="lst">
	Добавил: <?=nick($article['id_author'])?><br>
	<img src="/design/images/message-news.png"> <a href="/gazeta/articles_user/<?=$article['id_author']?>"><?=$db->query("SELECT `id` FROM `gazeta_articles` WHERE `id_author`=".$article['id_author']."")->num_rows?></a>
</div>
<div class="list1">
	<a href="/gazeta/comm/<?=$article['id']?>">Комментарии</a> [<?=$db->query("SELECT `id` FROM `gazeta_comm` WHERE `id_article`=".$article['id']."")->num_rows?>]
</div>
<?
if($user['journalist']>=1 OR $user['admin']>=3){
	?>
	<div class="list1">
		<a href="/gazeta/admin/edit_article/<?=$article['id']?>"><img src="/design/images/edit_page.png"></a>
		<a href="/gazeta/admin/delete_article/<?=$article['id']?>"><img src="/design/images/delete_page.png"></a>
		<a href="/gazeta/admin/edit_photo/<?=$article['id']?>"><img src="/design/images/imp.png"></a>
	</div>
	<?
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>