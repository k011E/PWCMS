<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Личные данные';
$where = 'kab';
$menu = $title;
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if(isset($_POST['save'])){
	$_POST['name'] = $Filter->input($_POST['name']);
	$_POST['birth'] = $Filter->input($_POST['birth']);
	$_POST['country'] = $Filter->input($_POST['country']);
	$_POST['city'] = $Filter->input($_POST['city']);
	$_POST['info'] = $Filter->input($_POST['info']);
	$_POST['icq'] = $Filter->clearInt($_POST['icq']);
	$db->query("UPDATE `users` SET `name`='".$_POST['name']."', `birth`='".$_POST['birth']."', `country`='".$_POST['country']."', `city`='".$_POST['city']."', `info`='".$_POST['info']."', `icq`='".$_POST['icq']."' WHERE `id`='".$user['id']."'");
	$user = $db->query("SELECT * FROM `users` WHERE `id`='".$user['id']."'")->fetch_assoc();
	successNoExit('Данные успешно сохранены!');
}
?>
<form action="" method="POST">
	<div class="menu2">
		Анкета:
	</div>
	<div class="list1">
		Имя:<br>
		<input type="text" name="name" value="<?=$user['name']?>"><br>
		Дата рождения:<br>
		<input type="text" name="birth" value="<?=$user['birth']?>"><br>
		<small>Пример: 01.01.1970</small><br>
		Страна:<br>
		<input type="text" name="country" value="<?=$user['country']?>"><br>
		Город:<br>
		<input type="text" name="city" value="<?=$user['city']?>"><br>
		О себе:<br>
		<input type="text" name="info" value="<?=$user['info']?>"><br> 
	</div>
	<div class="menu2">
		Контакты:
	</div>
	<div class="list1">
		ICQ:<br>
		<input type="text" name="icq" value="<?=$user['icq']?>"><br>
	</div>
	<div class="lst">
		<input type="submit" name="save" value="Сохранить">
	</div>
</form>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>