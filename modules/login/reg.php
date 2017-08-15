<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Регистрация';
$menu = $title;
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
?>
<div class="menu">Регистрация</div>
<?
mode('guest');
if(isset($_POST['reg'])){
	$_POST['nick'] = $Filter->clearString($_POST['nick']);
	$_POST['name'] = $Filter->clearString($_POST['name']);
	$_POST['sex'] = $Filter->clearString($_POST['sex']);
	$_POST['email'] = $Filter->clearEmail($_POST['email']);
	if(empty($_POST['nick'])){
		errorNoExit('Введите ник');
	}elseif(mb_strlen($_POST['nick'])>15){
		errorNoExit('Максимальная длинна ника - 15 символов');
	}elseif(empty($_POST['password'])){
		errorNoExit('Введите пароль');
	}elseif(empty($_POST['cofirmPassword'])){
		errorNoExit('Введите подтверждение пароля');
	}elseif($_POST['password']!=$_POST['cofirmPassword']){
		errorNoExit('Пароли не совпадают');
	}elseif(!$Filter->validEmail($_POST['email'])){
		errorNoExit('E-Mail введён ен верно');
	}elseif($db->query("SELECT `id` FROM `users` WHERE `nick`='".$_POST['nick']."'")->num_rows!=0){
		errorNoExit('Пользователь с данным ником уже зарегистрирован');
	}elseif($db->query("SELECT `id` FROM `users` WHERE `email`='".$_POST['email']."'")->num_rows!=0){
		errorNoExit('Пользователь с данным E-Mail уже зарегистрирован');
	}else{
		$tocken = md5(rand(0, 10)+time()+rand(0, 100));
		$db->query("INSERT INTO `users` SET `nick`='".$_POST['nick']."', `password`='".crypt($_POST['password'], '$1$rasmusle$')."', `name`='".$_POST['name']."', `sex`='".$_POST['sex']."', `email`='".$_POST['email']."', `time_reg`='".time()."', `tocken`='".$tocken."'");
		$id = $db->insert_id;
		setcookie("tocken", $tocken, time()+60*60*24*31*12, "/");
		$db->query("INSERT INTO `users_settings` SET `id_us`='".$id."', `max_p`='10', `homet`='5', `homef`='3', `homec`='3', `top_home`='1', `comm_home`='1', `files_forum`='0', `ads`='1', `smiles`='1', `view_mail`='1', `ajax`='1', `files_mail`='1', `normal_notifications`='0', `up_panel`='1', `feed_ank`='1'");
		if($db->mysql_errno){
			echo $db->mysql_error;
		}
		success('Вы успешно зарегистрированы. <a href="/">На главную</a>');
	}
}
?>
<div class="autxing">
	<div class="lst">
		Приветствуем Вас на странице регистрации! Так как на сайте активно работает система пенализаций советуем Вам ознакомиться с правилами ресурса, дабы в дальнейшем не возникали возражения и конфликты. <a href="/rules">Открыть правила</a>
	</div>
	<form action="" method="POST">
		*Ваш логин:<br>
		<input type="text" name="nick" maxlength="15"><br>
		*Пароль:<br>
		<input type="password" name="password"><br>
		*Повторите пароль:<br>
		<input type="password" name="cofirmPassword"><br>
		Ваше имя:<br>
		<input type="text" name="name"><br>
		Ваш пол:<br>
		<input type="radio" name="sex" value="Муж" checked="checked"> Муж
		<input type="radio" name="sex" value="Жен"> Жен<br>
		E-Mail:<br>
		<input type="email" name="email"><br>
		<input type="submit" name="reg" value="Зарегистрироваться">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>