<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Новые темы';
$menu = '<a href="/" style="color: white;">Главная</a> | <a href="/forum" style="color: white;">Форум</a> | Новые темы';
$where = 'forum';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$t = time()-86400;
?>
<div class="menu2">
	Всего <b><?=$db->query("SELECT `id` FROM `forum_t` WHERE `time`>".$t."")->num_rows?></b> тем
</div>
<?
$Pagination = new Pagination("SELECT * FROM `forum_t` WHERE `time`>".$t." ORDER BY `id`", $_GET['page']);
$query = $db->query("SELECT * FROM `forum_t` WHERE `time`>".$t." ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end."");
while ($topic = $query->fetch_assoc()) {
	$r = $db->query("SELECT * FROM `forum_r` WHERE `id`=".$topic['id_r']."")->fetch_assoc();
	$pr = $db->query("SELECT * FROM `forum_pr` WHERE `id`=".$topic['id_pr']."")->fetch_assoc();
	$tl = $db->query("SELECT `id` FROM `forum_p` WHERE `id_thema`=".$topic['id']."")->num_rows;
	$t1 = $tl/10;
	$t2 = abs(intval($tl/10));
	if($t1>$t2){
		$pg = $t2+1;
	}else{
		$pg = $t1;
	}
	$u = $db->query("SELECT `id`, `nick` FROM `users` WHERE `id`=".$topic['id_author']."")->fetch_assoc();
	$lp = $db->query("SELECT `id_us`, `time` FROM `forum_p` WHERE `id_thema`=".$topic['id']." ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
	$u2 = $db->query("SELECT `id`, `nick` FROM `users` WHERE `id`=".$lp['id_us']."")->fetch_assoc();	
	?>
	<div class="list1">
		Раздел: <a href="/forum/razd<?=$r['id']?>"><?=$Filter->output($r['name'])?></a><br>
		Подраздел: <a href="/forum/<?=$r['id']?>/<?=$pr['id']?>"><?=$Filter->output($pr['name'])?></a><br>
		<?=imgT($topic['id'])?> <a href="/forum/thema<?=$topic['id']?>"><?=$Filter->output($topic['name'])?></a> (<?=$db->query("SELECT `id` FROM `forum_p` WHERE `id_thema`=".$topic['id']."")->num_rows?>) <a href="/forum/thema<?=$topic['id']?>/page<?=$pg?>">></a><br>
		<a href="/us<?=$u['id']?>"><?=$Filter->output($u['nick'])?></a>/<a href="/us<?=$u2['id']?>"><?=$Filter->output($u2['nick'])?></a> (<?=datef($lp['time'])?>)
	</div>
	<?
}
$Pagination->out('/forum/thems/new/');
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>