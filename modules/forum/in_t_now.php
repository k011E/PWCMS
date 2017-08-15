<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$_GET['id'] = abs(intval($_GET['id']));
include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/extensions.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/functions.php');
$Forum = new Forum($_GET['id']);
$title = 'В теме '.$Forum->inThemaNowCount($_GET['id']);
$where = 'forum';
$menu = 'В теме "'.$Forum->nameThema($_GET['id']).'" '.$Forum->inThemaNowCount($_GET['id']).' человек';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$time = time()-60;
$query = $db->query("SELECT * FROM `forum_in_t` WHERE `id_thema`=".$_GET['id']." AND `time`>=".$time."");
?>
<div class="list1">
	<? 
		while ($in_t = $query->fetch_assoc()) {
			echo nick($in_t['id_us']),', ';
		}
	?>
</div>
<div class="navg"><a href="/forum/thema<?=$_GET['id']?>">Вернуться</a></div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>