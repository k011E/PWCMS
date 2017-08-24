<?php
$title = $menu = 'Моя панель';
$where = 'billing';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$billing_settings = $db->query("SELECT `flashing` FROM `billing_config_prices` WHERE `id`=1")->fetch_assoc();
if(isset($_POST['ok'])){
	if($user['money'] < $billing_settings['flashing']){
		errorNoExit('У Вас недостаточно средств!');
	}else{
		$db->query("UPDATE `users` SET `money`=`money`-".$billing_settings['flashing'].", `flashing`=1 WHERE `id`=".$user['id']."");
		header('location:/billing/services/flashing?success');
	}
}
if(isset($_GET['flashing'])){
	successNoExit('Вы успешно установили мигание ника!');
}
if(isset($_GET['del'])){
	$db->query("UPDATE `users` SET `flashing`=0 WHERE `id`=".$user['id']."");
	header('location:/billing/services/flashing?successdel');
}
if(isset($_GET['successdel'])){
	successNoExit('Вы успешно удалили мигание ника!');
}
if(isset($_GET['success'])){
	successNoExit('Вы успешно установили мигание ника!');
}
?>
<div class="list1">
	<form action="" method="POST">
		<b>Цена за смену настроек мигания ника: <font color="red"><?=$billing_settings['flashing']?>р</font></b><br>
		Пример: <span class="blink" style="display: inline;"><?=$Filter->output($user['nick'])?></span><br>
		<?if($user['flashing'] == 0){?>
			<input type="submit" name="ok" value="Активировать">
		<?}?>
	</form>
</div>
<?
if($user['flashing'] == 1){
	?>
	<div class="lst">
		 У Вас уже установлено мигание ника. Вы можете <a href="/billing/services/flashing?del">удалить</a> мигание ника.
	</div>
	<?
}
?>
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