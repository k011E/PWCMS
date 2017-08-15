<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
// include system elements
include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/extensions.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/functions.php');
// filter send id
$_GET['id'] = abs(intval($_GET['id']));
// query in db from thema where send id
$query = $db->query("SELECT * FROM `forum_t` WHERE `id`=".$_GET['id']."");
// if thema where id=send id = 0
if($query->num_rows==0){
	header('location:/forum');
}
// create assoc array topic
$thema = $query->fetch_assoc();
// create assoc array from section->section
$pr = $db->query("SELECT * FROM `forum_pr` WHERE `id`=".$thema['id_pr']."")->fetch_assoc();
// create assoc array from section
$r = $db->query("SELECT * FROM `forum_r` WHERE `id`=".$thema['id_r']."")->fetch_assoc();
// title page = topic name
$title = $Filter->output($thema['name']);
$menu = '<a href="/forum" style="color: white">Форум</a> | <a href="/forum/razd'.$r['id'].'" style="color: white">'.$Filter->output($r['name']).'</a> | <a href="/forum/'.$r['id'].'/'.$pr['id'].'" style="color: white">'.$Filter->output($pr['name']).'</a> | '.$Filter->output($thema['name']);
$where = 'forum';
$all_posts = $db->query("SELECT * FROM `forum_p` WHERE `id_thema`=".$thema['id']."")->num_rows;
$page = intval($all_posts/10)+1;
// include header
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
?>
<div class="list1">
	<form action="/modules/forum/add_post.php?id=<?=$_GET['id']?>&otv" method="POST">
		Сообщение:<br>
		<textarea name="content"></textarea><br>
		<input type="submit" name="add" value="Написать">
		<input type="submit" value="Назад" onclick="history.go(-1)">
	</form>
</div>
<?
if(isset($_POST['add'])){
	$_POST['content'] = $Filter->input($_POST['content']);
	if(empty($_POST['content']) or mb_strlen($_POST['content'])>16000){
		error('Недопустимая длина сообщения!');
	}elseif($db->query("SELECT `id` FROM `forum_p` WHERE `msg`='".$_POST['content']."' AND `id_thema`=".$thema['id']." AND `id_us`=".$user['id']."")->num_rows!=0){
		error('Вы уже писали подобное в теме!');
	}
	$db->query("INSERT INTO `forum_p` SET `id_r`=".$r['id'].", `id_pr`=".$pr['id'].", `msg`='".$_POST['content']."', `id_us`=".$user['id'].", `time`=".time().", `id_thema`=".$thema['id']."");
	$db->query("UPDATE `forum_t` SET `last`=".time()." WHERE `id`=".$thema['id']."");
	if($thema['id_author']!=$user['id']){
		$db->query("INSERT INTO `notifications` SET `id_us`=".$thema['id_author'].", `text`='us{".$user['id']."} ответил".($user['sex']=='Муж'?NULL:'а')." в теме ".lstPage($thema['id'], 2)."', `time`=".time().", `section`=1");
	}
	header('location:/forum/thema'.$thema['id'].'/page'.$page);
}
// include footer
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>