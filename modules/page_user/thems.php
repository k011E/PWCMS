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
$query = $db->query("SELECT `id`, `nick` FROM `users` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	header('location:/forum');
}
$us = $query->fetch_assoc();
$title = 'Темы '.$Filter->output($us['nick']);
$where = 'page_user';
$menu = '<a href="/" style="text-decoration:none; color:white;">Главная</a> | <a href="/forum" style="text-decoration:none; color:white;">Форум</a> | Темы '.nick($us['id']);
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$Forum = new Forum(0);
?>
<div class="menu2">
	Всего <?=$Forum->themsUsCount($_GET['id'])?> тем 
</div>
<?
$Pagination = new Pagination("SELECT * FROM `forum_t` WHERE `id_author`=".$_GET['id']."", $_GET['page']);
$query = $db->query("SELECT * FROM `forum_t` WHERE `id_author`=".$_GET['id']." ORDER BY `id` DESC LIMIT $Pagination->start, $Pagination->end");
while ($them = $query->fetch_assoc()) {
	?>
	<div class="lst">
		Раздел: <?=$Forum->ROut($Forum->RThemaId($them['id']))?><br>
		Подраздел: <?=$Forum->PrOut($Forum->PrThemaId($them['id']))?><br>
		<?=imgT($them['id'])?> Тема: <a href="/forum/thema<?=$them['id']?>"><?=$Forum->nameThema($them['id'])?></a> (<?=countPosts($them['id'])?>) <?=lstPage($them['id'])?><br>
		<?=authorTopic($them['id'])?> / <?=authorLastPost($them['id'])?> (<?=dateLastPost($them['id'])?>)
	</div>
	<?
}
if($query->num_rows==0){
	error("Пользователь тем на форуме не создавал");
}
$Pagination->out('/thems'.$_GET['id']);
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>