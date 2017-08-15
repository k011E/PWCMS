<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Редактирование сообщения';
$where = 'forum';
include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/extensions.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/functions.php');
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT * FROM `forum_p` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	$title = 'Ошибочка...';
	$menu = 'Ошибочка';
	error('Поста не существует');
}
$post = $query->fetch_assoc();
$thema = $db->query("SELECT * FROM `forum_t` WHERE `id`=".$post['id_thema']."")->fetch_assoc();
$menu = $thema['name'];
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="list1">
	<form action="" method="POST">
		<textarea name="msg" class="form-control" rows="5"><?=$Filter->output($post['msg'])?></textarea><br>
		<input type="submit" name="ok" value="Сохранить">
		<input type="button" value="Назад" onclick="history.go(-1);">
	</form>
</div>
<?
if(isset($_POST['ok'])){
	$_POST['msg'] = $Filter->input($_POST['msg']);
	if(empty($_POST['msg'])){
		?>
		<div class="list1">Вы не ввели текст сообщения...</div>
		<?
	}else{
		$db->query("UPDATE `forum_p` SET `msg`='".$_POST['msg']."' WHERE `id`=".$post['id']."");
		$db->query("INSERT INTO `forum_edit_p` SET `time`=".time().", `id_us`=".$user['id'].", `id_post`=".$post['id']."");
		header('location:/forum/thema'.$thema['id'].'/page'.round($query->num_rows / 10 + 1));
	}
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>