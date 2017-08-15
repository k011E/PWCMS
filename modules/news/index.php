<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Новости';
$where = 'news';
include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
$menu = 'Новости проекта ('.$db->query("SELECT `id` FROM `news`")->num_rows.')';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$Pagination = new Pagination("SELECT * FROM `news`", $_GET['page']);
$query = $db->query("SELECT * FROM `news` ORDER BY `id` DESC LIMIT $Pagination->start, $Pagination->end");
while ($news = $query->fetch_assoc()) {
	?>
	<div class="list1">
		Текст: <?=$Filter->outputText($news['content'])?><br>
		Добавлена: <?=nick($news['id_us'])?> (<?=datef($news['time'])?>)<br>
		<a href="/komm<?=$news['id']?>">Комментарии</a> (<?=$db->query("SELECT `id` FROM `news_comm` WHERE `id_news`='".$news['id']."'")->num_rows?>)
	</div>
	<?
}
if($db->query("SELECT `id` FROM `news`")->num_rows==0){
	?>
	<div class="list1">Новостей пока нет</div>
	<?
}else{
	$Pagination->out('/news');
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>