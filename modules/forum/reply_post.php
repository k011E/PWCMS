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
$query = $db->query("SELECT `id`, `nick` FROM `users` WHERE `id`=".$_GET['id_us']."");
if($query->num_rows==0){
	error('Пользователя не существует!');
}
$us = $query->fetch_assoc();
if($user['id']==$us['id']){
	error('Самому себе отвечать запрещено!');
}
$all_posts = $db->query("SELECT * FROM `forum_p` WHERE `id_thema`=".$thema['id']."")->num_rows;
$page = intval($all_posts/10)+1;
?>
<div class="list1">
	<form action="" method="POST">
		Сообщение:<br>
		<textarea name="content">[b]<?=$Filter->output($us['nick'])?>[/b],</textarea><br>
		<input type="submit" name="add" value="Написать">
		<input type="submit" onclick="history.go(-1)" value="Назад">
	</form>
</div>
<?
if(isset($_POST['add'])){
	$_POST['content'] = $Filter->input($_POST['content']);
	if(empty($_POST['content'])){
		error('Введите сообщение!');
	}elseif($db->query("SELECT `id` FROM `forum_p` WHERE `msg`='".$_POST['content']."' AND `id_us`=".$us['id']." AND `id_thema`=".$thema['id']."")->num_rows!=0){
		error('Вы писали подобное в теме!');
	}
	$db->query("INSERT INTO `forum_p` SET `id_r`=".$r['id'].", `id_pr`=".$pr['id'].", `msg`='".$_POST['content']."', `id_us`=".$user['id'].", `time`=".time().", `id_thema`=".$thema['id']."");
	$db->query("UPDATE `forum_t` SET `last`=".time()." WHERE `id`=".$thema['id']."");
	$db->query("INSERT INTO `notifications` SET `id_us`=".$us['id'].", `text`='us{".$user['id']."} ответил".($user['sex']=='Муж'?NULL:'а')." на ваш пост в теме ".lstPage($thema['id'], 2)."', `time`=".time().", `section`=1");
	if($thema['id_author']!=$user['id']){
		$db->query("INSERT INTO `notifications` SET `id_us`=".$thema['id_author'].", `text`='us{".$user['id']."} ответил".($user['sex']=='Муж'?NULL:'а')." в теме ".lstPage($thema['id'], 2)."', `time`=".time().", `section`=1");
	}
	header('location:/forum/thema'.$thema['id'].'/page'.$page);
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>