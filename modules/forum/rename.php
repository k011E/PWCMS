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
$query = $db->query("SELECT * FROM `forum_t` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0 OR $user['admin']<1){
	header('location:/');
}
$thema = $query->fetch_assoc();
if($thema['type']==1 AND $user['admin']<3){
	header('location:/forum/thema'.$_GET['id']);
}
$title = 'Переименование темы';
$menu = $Filter->output($thema['name']);
$where = 'forum';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if(isset($_POST['save'])){
	$_POST['name'] = $Filter->output($_POST['name']);
	if(empty($_POST['name'])){
		error('Вы не ввели новое название темы!');
	}
	$db->query("UPDATE `forum_t` SET `name`='".$_POST['name']."', `last`='".time()."' WHERE `id`='".$_GET['id']."'");
	$tex = '[b]Переименовал' . ($user['sex'] == 'Муж' ? NULL : 'а') . ' тему! :-)[/b]';
	$db->query("INSERT INTO `forum_p` SET `id_r`='".$thema['id_r']."', `id_pr`='".$thema['id_pr']."', `msg`='".$tex."', `type`=0, `id_us`='".$user['id']."', `time`='".time()."', `id_thema`='".$thema['id']."'");
	header('location:/forum/thema'.$thema['id']);
}
?>
<div class="list1">
	<form action="" method="POST">
		<input type="text" name="name" value="<?=$thema['name']?>"/><br/>
		<input type="submit" value="Сохранить" name="save">
		<input type="button" value="Назад" onClick="history.go(-1);" />
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>