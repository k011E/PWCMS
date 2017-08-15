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
$query = $db->query("SELECT * FROM `forum_pr` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0){
	header('location:/forum');
}
$pr = $query->fetch_assoc();
$r = $db->query("SELECT * FROM `forum_r` WHERE `id`='".$pr['r']."'")->fetch_assoc();
$title = 'Подраздел '.$Filter->output($pr['name']);
$menu = '<a href="/forum" style="text-decoration:none; color:white;">Форум</a> | <a href="/forum/razd'.$r['id'].'" style="text-decoration:none; color:white;">'.$Filter->output($r['name']).'</a> | '.$Filter->output($pr['name']);
$where = 'forum';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');

?>
<div class="menu2">
	<img src="/design/images/nt.png" alt="*" align="middle">
	<a href="/forum/<?=$r['id']?>/<?=$pr['id']?>/nt" style="text-decoration:none; color:white;">Новая тема</a>
</div>
<?
$Pagination = new Pagination("SELECT * FROM `forum_t` ORDER BY `id`", $_GET['page']);
$query = $db->query("SELECT * FROM `forum_t` WHERE `id_pr`=".$_GET['id']." ORDER BY `id` LIMIT ".$Pagination->start.", ".$Pagination->end."");
while ($thema = $query->fetch_assoc()) {
	$tl = $db->query("SELECT `id` FROM `forum_p` WHERE `id_thema`=".$thema['id']."")->num_rows;
	$t1 = $tl/10;
	$t2 = abs(intval($tl/10));
	if($t1>$t2){
		$pg = $t2+1;
	}else{
		$pg = $t1;
	}
	$p1 = $db->query("SELECT * FROM `forum_p` WHERE `id_thema`=".$thema['id']." ORDER BY `id` DESC LIMIT 0, 1")->fetch_assoc();
	?>
	<div class="list1">
		<?=imgT($thema['id'])?> <a href="/forum/thema<?=$thema['id']?>"><?=$Filter->output($thema['name'])?></a> (<?=$db->query("SELECT `id` FROM `forum_p` WHERE `id_thema`=".$thema['id']."")->num_rows?>) <a href="/forum/thema<?=$thema['id']?>/page<?=$pg?>">></a><br>
		<?=nick($thema['id_author'])?> / <?=nick($p1['id_us'])?> (<?=datef($p1['time'])?>)
	</div>
	<?
	$Pagination->out('/forum/'.$pr['r'].'/'.$pr['id'].'/');
}
if($query->num_rows==0){
	?>
	<div class="lst">Тем в данном подразделе пока что нет</div>
	<?
}
?>
<div class="menu2">
	<img src="/design/images/alll.png" alt="*" align="middle">
	Правила: <a href="/all/rulls" style="text-decoration:none; color:white;">сайта</a>/<a href="/forum/rulls<?=$pr['id']?>" style="text-decoration:none; color:white;">подраздела</a>
	|
	<img src="/design/images/emoc.png" alt="*" align="middle">
	<a href="/all/smiles_r.php" style="text-decoration:none; color:white;">Смайлы</a>
	|
	<img src="/design/images/cod.png" alt="*" align="middle">
	<a href="/all/bb.php" style="text-decoration: none; color: white;">ББ коды</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>