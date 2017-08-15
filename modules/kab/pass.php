<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Смена пароля';
$menu = $title;
$where = 'kab';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if(isset($_POST['save'])){
	if(empty($_POST['old'])){
		errorNoExit('Введите старый пароль');
	}elseif(empty($_POST['pass'])){
		errorNoExit('Введите новый пароль');
	}elseif(empty($_POST['pass2'])){
		errorNoExit('Введите подтверждение нового пароля');
	}elseif($_POST['pass'] != $_POST['pass2']){
		errorNoExit('Новый пароль и его подтверждение не совпадают');
	}elseif($user['password'] != crypt($_POST['old'], '$1$rasmusle$')){
		errorNoExit('Старый пароль введён не верно');
	}else{
		$db->query("UPDATE `users` SET `password`='".crypt($_POST['pass'], '$1$rasmusle$')."' WHERE `id`='".$user['id']."'");
		successNoExit('Пароль успешно изменён');
	}
}
?>
<form action="" method="POST">
	<div class="list1">
		Старый пароль:<br>
		<input type="password" name="old"><br>
		Новый пароль:<br>
		<input type="password" name="pass"><br>
		Повторите новый пароль:<br>
		<input type="password" name="pass2">
	</div>
	<div class="lst">
		<input type="submit" name="save" value="Сохранить">
	</div>
</form>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>