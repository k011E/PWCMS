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
$query = $db->query("SELECT * FROM `users` WHERE `id`=".$_GET['id']."");
$us = $query->fetch_assoc();
$title = 'Смена ника пользователю '.$us['nick'];
$menu = 'Смена ника '.nick($us['id']);
$where = 'page_user';
if($query->num_rows==0){
	header('location:/');
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(1);
if(isset($_POST['change'])){
	$_POST['nick'] = $Filter->input($_POST['nick']);
	if(empty($_POST['nick'])){
		errorNoExit('Введите ник');
	}else{
		$db->query("INSERT INTO `history_nick` SET `id_us`='".$_GET['id']."', `id_adm`='".$user['id']."', `time`='".time()."', `old`='".$us['nick']."', `new`='".$_POST['nick']."'");
		$db->query("UPDATE `users` SET `nick`='".$_POST['nick']."' WHERE `id`='".$_GET['id']."'");
		successNoExit('Ник успешно сменён');
	}
}
?>
<div class="lst">
	<form action="" method="POST">
		Новый ник:<br>
		<input type="text" name="nick"><br>
		<input type="submit" name="change" value="Сменить">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>