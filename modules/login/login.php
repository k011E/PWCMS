<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Авторизация';
$menu = $title;
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
?>
<div class="menu">Авторизация</div>
<?
mode('guest');
if(isset($_POST['login'])){
	if($_POST['type']=='nick'){
		$_POST['nick'] = $Filter->clearString($_POST['nick']);
		if($db->query("SELECT `id` FROM `users` WHERE `nick`='".$_POST['nick']."' AND `password`='".crypt($_POST['password'], '$1$rasmusle$')."'")->num_rows!=0){
			$u = $db->query("SELECT * FROM `users` WHERE `nick`='".$_POST['nick']."' AND `password`='".crypt($_POST['password'], '$1$rasmusle$')."'")->fetch_assoc();
		}else{
			$db->query("INSERT INTO `auth_fail` SET `id_us`='".$u['id']."', `time`='".time()."', `ip`='".$_SERVER["REMOTE_ADDR"]."', `ua`='".$_SERVER["HTTP_USER_AGENT"]."'");
			error('Не верно введён логин или пароль');
		}
	}elseif($_POST['type']=='id'){
		$_POST['nick'] = $Filter->clearInt($_POST['nick']);
		if($db->query("SELECT `id` FROM `users` WHERE `id`='".$_POST['nick']."' AND `password`='".crypt($_POST['password'], '$1$rasmusle$')."'")->num_rows!=0){
			$u = $db->query("SELECT * FROM `users` WHERE `id`='".$_POST['nick']."' AND `password`='".crypt($_POST['password'], '$1$rasmusle$')."'")->fetch_assoc();
		}else{
			$db->query("INSERT INTO `auth_fail` SET `id_us`='".$u['id']."', `time`='".time()."', `ip`='".$_SERVER["REMOTE_ADDR"]."', `ua`='".$_SERVER["HTTP_USER_AGENT"]."'");
			error('Не верно введён логин или пароль');
		}
	}else{
		erorr();
	}
	if(isset($u['id'])){
		$tocken = md5(rand(0, 10)+time()+rand(0, 100));
		$db->query("UPDATE `users` SET `tocken`='".$tocken."' WHERE `id`='".$u['id']."'");
		$db->query("INSERT INTO `auth_success` SET `id_us`='".$u['id']."', `time`='".time()."', `ip`='".$_SERVER["REMOTE_ADDR"]."', `ua`='".$_SERVER["HTTP_USER_AGENT"]."'");
		setcookie("tocken", $tocken, time()+60*60*24*31*12, "/");
		header('location:/');
	}
}
?>
<div class="list1">
	<form action="" method="POST">
		Ваш 
		<select name="type">
			<option value="nick">Ник</option>
			<option value="id">ID</option>
		</select>:<br>
		<input type="text" name="nick"><br>
		Ваш пароль:<br>
		<input type="password" name="password"><br>
		<input type="submit" name="login" value="Вход">
	</form>
	<a href="/reg.php">
		<input type="submit" value="Регистрация">
	</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>