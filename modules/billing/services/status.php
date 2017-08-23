<?php
$title = $menu = 'Моя панель';
$where = 'billing';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$settings_billing = $db->query("SELECT `status` FROM `billing_config_prices` WHERE `id`=1")->fetch_assoc();
if(isset($_POST['ok'])){
	$_POST['status'] = $Filter->input($_POST['status']);
	if(empty($_POST['status'])){
		errorNoExit('Введите статус!');
	}elseif(mb_strlen($_POST['status']) > 100){
		errorNoExit('Длинна статуса не должна быть больше 100 символов!');
	}elseif($user['money'] < $settings_billing['status']){
		errorNoExit('У Вас недостаточно средств!');
	}else{
		$db->query("UPDATE `users` SET `money`=`money`-".$settings_billing['status'].", `status`='".$_POST['status']."' WHERE `id`=".$user['id']."");
		header('location:/billing/services/status?success');
	}
}
if(isset($_GET['success'])){
	successNoExit('Вы успешно установили статус!');
}
?>
<div class="list1">
	<b>Цена установки статуса: <font color="red"><?=$settings_billing['status']?>р</font><br>
	*Запрещена реклама в статусе без согласования с Администрацией.</b>
	<form action="" method="POST">
		Статус:<br>
		<input type="text" name="status"><br>
		<input type="submit" name="ok" value="Установить">
	</form>
</div>
<div class="navg">
	<a href="/billing/services/">Услуги</a>
</div>
<div class="navg">
	<img src="/design/images/home0.png">
	<a href="/billing">Моя панель</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>