<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/extensions.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/functions.php');
$_GET['id'] = abs(intval($_GET['id']));
$p = $db->query("SELECT `id_thema` FROM `forum_p` WHERE `id`=".$_GET['id']."")->fetch_assoc();
$Forum = new Forum($p['id_thema']);
$title = $Forum->nameThema($p['id_thema']);
$where = 'forum';
$menu = 'Рейтинг поста';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="lst">
	<?
	$query = $db->query("SELECT * FROM `forum_rating_post` WHERE `id_post`=".$_GET['id']." AND `type`=2");
	while ($post = $query->fetch_assoc()) {
		echo $Forum->viewVotePost($post['id']);
	}
	?>
</div>
<div class="menu">
	<a href="/forum/thema<?=$p['id_thema']?>/page<?=lstPage($p['id_thema'], 1)?>">Вернуться</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>