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
$title = 'Редактирование пользователя '.$Filter->output($us['nick']);
$menu = 'Редактирование пользователя '.nick($us['id']);
$where = 'page_user';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(2);
if(isset($_POST['save'])){
	$_POST['name'] = $Filter->input($_POST['name']);
	$_POST['sex'] = $Filter->input($_POST['sex']);
	$_POST['email'] = $Filter->input($_POST['email']);
	$_POST['admin'] = abs(intval($_POST['admin']));
	$_POST['rating'] = $Filter->input($_POST['rating']);
	$_POST['status'] = $Filter->input($_POST['status']);
	$_POST['birth'] = $Filter->input($_POST['birth']);
	$_POST['country'] = $Filter->input($_POST['country']);
	$_POST['city'] = $Filter->input($_POST['city']);
	$_POST['info'] = $Filter->input($_POST['info']);
	$_POST['icq'] = $Filter->input($_POST['icq']);
	$db->query("UPDATE `users` SET `name`='".$_POST['name']."', `sex`='".$_POST['sex']."', `email`='".$_POST['email']."', `rating`='".$_POST['rating']."', `status`='".$_POST['status']."', `birth`='".$_POST['birth']."', `country`='".$_POST['country']."', `city`='".$_POST['city']."', `info`='".$_POST['info']."', `icq`='".$_POST['icq']."' WHERE `id`='".$us['id']."'");
	if($user['admin']>=4){
		$db->query("UPDATE `users` SET `admin`='".$_POST['admin']."' WHERE `id`='".$us['id']."'");
	}
	$us = $db->query("SELECT * FROM `users` WHERE `id`='".$us['id']."'")->fetch_assoc();
	successNoExit('Данные сохранены');
}
?>
<div class="list1">
	<form action="" method="POST">
		Имя:<br>
		<input type="text" name="name" value="<?=$Filter->output($us['name'])?>"><br>
		Пол:<br>
		<select name="sex">
			<option value="Муж" <?if($us['sex']=='Муж'){?>selected<?}?>>Мужской</option>
			<option value="Жен" <?if($us['sex']=='Жен'){?>selected<?}?>>Женский</option>
		</select><br>
		E-Mail:<br>
		<input type="email" name="email" value="<?=$Filter->output($us['email'])?>"><br>
		<?if($user['admin']>=4){?>
		Должность:<br>
			<select name="admin">
				<option value="0" <?if($us['admin']==0){?>selected<?}?>>Пользователь</option>
				<option value="1" <?if($us['admin']==1){?>selected<?}?>>Модератор</option>
				<option value="2" <?if($us['admin']==2){?>selected<?}?>>Администратор</option>
				<option value="3" <?if($us['admin']==3){?>selected<?}?>>Старший Администратор</option>
				<option value="4" <?if($us['admin']==4){?>selected<?}?>>Создатель</option>
			</select><br>
		<?}?>
		Рейтинг:<br>
		<input type="text" name="rating" value="<?=$Filter->output($us['rating'])?>"><br>
		Статус:<br>
		<input type="text" name="status" value="<?=$Filter->output($us['status'])?>"><br>
		Дата рождения:<br>
		<input type="text" name="birth" value="<?=$Filter->output($us['birth'])?>"><br>
		Страна:<br>
		<input type="text" name="country" value="<?=$Filter->output($us['country'])?>"><br>
		Город:<br>
		<input type="text" name="city" value="<?=$Filter->output($us['city'])?>"><br>
		О себе:<br>
		<input type="text" name="info" value="<?=$Filter->output($us['info'])?>"><br>
		ICQ:<br>
		<input type="text" name="icq" value="<?=$Filter->output($us['icq'])?>"><br>
		<input type="submit" name="save" value="Сохранить">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>