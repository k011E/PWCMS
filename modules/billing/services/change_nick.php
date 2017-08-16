<?php
$title = $menu = 'Моя панель';
$where = 'billing';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$setting_billing = $db->query("SELECT `change_nick` FROM `billing_config_prices` WHERE `id`=1")->fetch_assoc();
if(isset($_POST['ok'])){
	$_POST['nick'] = $Filter->input($_POST['nick']);
	if(empty($_POST['nick'])){
		errorNoExit('Введите ник!');
	}elseif(mb_strlen($_POST['nick']) > 15){
		errorNoExit('Максимальная длинна нового ника - 15 символов!');
	}elseif($user['money'] < $setting_billing['change_nick']){
		errorNoExit('Недостаточно средств');
	}else{
		$db->query("UPDATE `users` SET `money`=`money`-".$setting_billing['change_nick']." WHERE `id`=".$user['id']."");
		$db->query("UPDATE `users` SET `nick`='".$_POST['nick']."' WHERE `id`=".$user['id']."");
		successNoExit('Вы успешно сменили ник на '.$Filter->output($_POST['nick']));
	}
}
?>
<div class="list1">
	<b>Цена эксресс смены ника: <font color="red"><?=$setting_billing['change_nick']?>р</font><br>
	*Запрещен плагиат ников, плагиат ников админов карается баном.</b><br>
	<form action="" method="POST">
		Новый ник(max 15):<br>
		<input type="text" name="nick"><br>
		<input type="submit" name="ok" value="Изменить">
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