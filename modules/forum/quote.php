<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$_GET['id_thema'] = abs(intval($_GET['id_thema']));
include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/extensions.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/functions.php');
$query = $db->query("SELECT * FROM `forum_t` WHERE `id`=".$_GET['id_thema']."");
if($query->num_rows==0){
	header('location:/forum');
}
$thema = $query->fetch_assoc();
$r = $db->query("SELECT * FROM `forum_r` WHERE `id`=".$thema['id_r']."")->fetch_assoc();
$pr = $db->query("SELECT * FROM `forum_pr` WHERE `id`=".$thema['id_pr']."")->fetch_assoc();
$title = $Filter->output($thema['name']);
$menu = '<a href="/forum" style="color: white;">Форум</a> | <a href="/forum/razd'.$r['id'].'" style="color: white;">'.$Filter->output($r['name']).'</a> | <a href="/forum/'.$r['id'].'/'.$pr['id'].'" style="color: white;">'.$Filter->output($pr['name']).'</a> | '.$Filter->output($thema['name']).'';
$where = 'forum';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$query = $db->query("SELECT * FROM `forum_p` WHERE `id`=".$_GET['id_post']."");
if($query->num_rows==0){
	error('Поста не существует!');
}
$p = $query->fetch_assoc();
$us = $db->query("SELECT `id`, `nick` FROM `users` WHERE `id`=".$p['id_us']."")->fetch_assoc();
$all_posts = $db->query("SELECT * FROM `forum_p` WHERE `id_thema`=".$thema['id']."")->num_rows;
$page = intval($all_posts/10)+1;
if($us['id']==$user['id']){
	error('Цитировать самого себя запрещено!');
}
?>
<div class="list1">
	<form action="" method="POST">
		Цитата:
		<div class="cit"><b><font color="red"><?=$Filter->output($us['nick'])?></font></b>: <?=$Filter->output($p['msg'])?></div>
		Сообщение:<br>
		<textarea name="content"></textarea><br>
		<input type="submit" name="add" value="Написать">
		<input type="submit" onclick="history.go(-1)" value="Назад">
	</form>
</div>
<?
if(isset($_POST['add'])){
	$_POST['content'] = $Filter->input($_POST['content']);
	if(empty($_POST['content'])){
		error('Введите текст сообщения!');
	}elseif($db->query("SELECT `id` FROM `forum_p` WHERE `msg`='".$_POST['content']."' AND `id_us`=".$user['id']." AND `id_thema`=".$thema['id']."")->num_rows!=0){
		error('Вы уже писали подобное в теме.');
	}
	$db->query("INSERT INTO `forum_p` SET `id_r`=".$thema['id_r'].", `id_pr`=".$thema['id_pr'].", `msg`='".$_POST['content']."', `id_us`=".$user['id'].", `time`=".time().", `id_thema`=".$thema['id'].", `cit`=".$p['id']."");
	$db->query("UPDATE `forum_t` SET `last`=".time()." WHERE `id`=".$thema['id']."");
	$db->query("INSERT INTO `notifications` SET `id_us`='".$us['id']."', `text`='us{".$user['id']."} процитировал".($user['sex']=='Муж'?NULL:'а')." ваш пост:[br]".$Filter->output(mb_substr($p['msg'], 0, 100, 'UTF-8'))." в теме ".lstPage($thema['id'], 2)."', `time`='".time()."', `section`='1'");
		if($thema['id_author']!=$user['id']){
		$db->query("INSERT INTO `notifications` SET `id_us`=".$thema['id_author'].", `text`='us{".$user['id']."} ответил".($user['sex']=='Муж'?NULL:'а')." в теме ".lstPage($thema['id'], 2)."', `time`=".time().", `section`=1");
	}
	header('location:/forum/thema'.$thema['id'].'/page'.$page);
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>