<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Рейтинг поста';
$where = 'forum';
$menu = $title;
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$_GET['id'] = abs(intval($_GET['id']));
$post = $db->query("SELECT `id_thema`, `id_us`, `msg` FROM `forum_p` WHERE `id`=".$_GET['id']."")->fetch_assoc();
$Forum = new Forum($post['id_thema']);
if($Forum->typeThema($post['id_thema'])==1 OR $Forum->typeThema($post['id_thema'])==3){
	error('Тема закрыта или удалена!');
}elseif($Forum->msgUserCount($user['id'])<50){
	error('Наберите для начала 50 постов в форуме!');
}elseif($Forum->typePost($_GET['id'])==1 OR $Forum->checkPost($_GET['id'])){
	error('Этот пост удалён');
}elseif(!$Forum->noAuthorPost($_GET['id'])){
	error('Вы не можете изменять рейтинг своего же сообщения!');
}elseif($Forum->checkVotePostUs($_GET['id'])){
	error('Вы уже голосовали за этот пост!');
}elseif($Forum->checkSuccessVotePostUs($_GET['id'])){
	error('Вы недавно изменяли рейтинг к посту этого пользователя!');
}
if(isset($_POST['yes'])){
	$db->query("INSERT INTO `forum_rating_post` SET `id_us`=".$user['id'].", `id_post`=".$_GET['id'].", `time`=".time().", `type`='2', `id_author`=".$post['id_us']."");
	$db->query("UPDATE `users` SET `rating`=`rating`-0.01 WHERE `id`=".$post['id_us']."");
	$db->query("INSERT INTO `notifications` SET `id_us`=".$post['id_us'].", `text`='us{".$user['id']."} отрицательно оценил ваш пост:[br][b]".mb_substr($post['msg'], 0, 100, 'UTF-8')."[/b] в теме [url=/forum/thema".$post['id_thema']."/page".lstPage($post['id_thema'], 1)."]".$Forum->nameThema($post['id_thema'])."[/url]', `time`=".time().", `section`=2");
	header('location:/forum/thema'.$post['id_thema'].'/page'.lstPage($post['id_thema'], 1));
}
?>
<div class="list1">
	Вы уверены в том что хотите поставить <b><font color="red">минус</font></b>
	<form action="" method="POST">
		<input name="yes" type="submit" value="Да, продолжить"> | <a href="/forum/thema<?=$post['id_thema']?>/page<?=lstPage($post['id_thema'], 1)?>">Нет, назад</a>
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>