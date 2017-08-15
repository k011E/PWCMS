<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Наблюдаемые темы';
$where = 'forum';
$menu = 'Мои наблюдаемые темы';
include_once($_SERVER['DOCUMENT_ROOT'].'/design/head.php');
mode('user');
$Pagination = new Pagination("SELECT * FROM `forum_podp` WHERE `id_us`=".$user['id']."", $_GET['page']);
$query = $db->query("SELECT * FROM `forum_podp` WHERE `id_us`=".$user['id']." LIMIT ".$Pagination->start.", ".$Pagination->end."");
while ($podp = $query->fetch_assoc()) {
	$t = $db->query("SELECT * FROM `forum_t` WHERE `id`=".$podp['id_thema']."")->fetch_assoc();
	$r = $db->query("SELECT * FROM `forum_r` WHERE `id`=".$t['id_r']."")->fetch_assoc();
	$pr = $db->query("SELECT * FROM `forum_pr` WHERE `id`=".$t['id_pr']."")->fetch_assoc();
	?>
	<div class="lst">
		Раздел: <a href="/forum/razd<?=$r['id']?>"><?=$Filter->output($r['name'])?></a><br>
		Подраздел: <a href="/forum/<?=$r['id']?>/<?=$pr['id']?>"><?=$Filter->output($pr['name'])?></a><br>
		<?=imgT($t['id'])?> Тема: <a href="/forum/thema<?=$t['id']?>"><?=$Filter->output($t['name'])?></a> (<?=countPosts($t['id'])?>) <?=lstPage($t['id'])?><br>
		<?=authorTopic($t['id'])?>/<?=authorLastPost($t['id'])?> (<?=dateLastPost($t['id'])?>)
	</div>
	<?
}
$Pagination->out('/kab/pth');
?>
<div class="list1"><a href="/kab">В личный кабинет</a></div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>