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
$query = $db->query("SELECT * FROM `users` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0){
	header('location:/');
}
$us = $query->fetch_assoc();
$title = 'Смена пароля пользователю '.$Filter->output($us['nick']);
$menu = 'Смена пароля пользователю '.nick($us['id']);
$where = 'page_user';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(2);
if($user['admin']<=$us['admin']){
	header('location:/us'.$us['id']);
}
if(isset($_POST['change'])){
	if(empty($_POST['password'])){
		errorNoExit('Введите пароль');
	}elseif(empty($_POST['confirmPassword'])){
		errorNoExit('Введите подтверждение пароля');
	}elseif($_POST['password']!=$_POST['confirmPassword']){
		errorNoExit('Пароли не совпадают');
	}else{
		$db->query("UPDATE `users` SET `password`='".crypt($_POST['password'], '$1$rasmusle$')."' WHERE `id`='".$us['id']."'");
		mail($us['email'], "Смена пароля на сайте ".$_SERVER['HTTP_HOST']."", 'Ваш пароль был изменён на: '.$_POST['password'].' пользователем '.$user['nick']);
		successNoExit('Пароль успешно изменён');
	}
}
?>
<div class="list1">
	<form action="" method="POST">
		Новый пароль:<br>
		<input type="password" name="password"><br>
		Повтор пароля:<br>
		<input type="password" name="confirmPassword"><br>
		<input type="submit" name="change" value="Сменить">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>