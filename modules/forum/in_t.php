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
$title = 'В теме '.$Forum->inThemaCount($_GET['id']);
$where = 'forum';
$menu = 'В тему "'.$Forum->nameThema($_GET['id']).'" зашло '.$Forum->inThemaCount($_GET['id']).' человек';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$Pagination = new Pagination("SELECT * FROM `forum_in_t` WHERE `id_thema`=".$_GET['id']."", $_GET['page']);
$query = $db->query("SELECT * FROM `forum_in_t` WHERE `id_thema`=".$_GET['id']." ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end."");
while ($in_t = $query->fetch_assoc()) {
	?>
	<div class="list1">
		<?=nick($in_t['id_us'])?> (<?=datef($in_t['time'])?>)
	</div>
	<?	
}
$Pagination->out('/forum/in_t/'.$_GET['id']);
?>
<div class="navg">
	<a href="/forum/thema<?=$_GET['id']?>">Вернуться</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>