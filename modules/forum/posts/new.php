<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Новые посты';
$where = 'forum';
$menu = '<a href="/" style="color: white;">Главная</a> | <a href="/forum" style="color: white;">Форум</a> | Новые посты';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="menu2">
	Всего <?=$db->query("SELECT `id` FROM `forum_p`")->num_rows?> постов
</div>
<?
$Pagination = new Pagination("SELECT * FROM `forum_p`", $_GET['page']);
$query = $db->query("SELECT * FROM `forum_p` ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end."");
while ($post = $query->fetch_assoc()) {
	$r = $db->query("SELECT * FROM `forum_r` WHERE `id`=".$post['id_r']."")->fetch_assoc();
	$pr = $db->query("SELECT * FROM `forum_pr` WHERE `id`=".$post['id_pr']."")->fetch_assoc();
	$t = $db->query("SELECT `id`, `name` FROM `forum_t` WHERE `id`=".$post['id_thema']."")->fetch_assoc();
	$tl = $db->query("SELECT `id` FROM `forum_p` WHERE `id_thema`=".$t['id']."")->num_rows;
	$t1 = $tl/10;
	$t2 = abs(intval($tl/10));
	if($t1>$t2){
		$pg = $t2+1;
	}else{
		$pg = $t1;
	}
	?>
	<div class="list1">
		Раздел: <a href="/forum/razd<?=$r['id']?>"><?=$Filter->output($r['name'])?></a><br>
		Подраздел: <a href="/forum/<?=$r['id']?>/<?=$pr['id']?>"><?=$Filter->output($pr['name'])?></a><br>
		<?=imgT($t['id'])?> <a href="/forum/thema<?=$t['id']?>"><?=$Filter->output($t['name'])?></a> (<?=$db->query("SELECT `id` FROM `forum_p` WHERE `id_thema`=".$t['id']."")->num_rows?>) <a href="/forum/thema<?=$t['id']?>/page<?=$pg?>">></a><br>
		Написал: <?=nick($post['id_us'])?> (<?=datef($post['time'])?>)<br>
		<?=$Filter->outputText($post['msg'])?>
	</div>
	<?
}
$Pagination->out('/forum/posts/new');
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>