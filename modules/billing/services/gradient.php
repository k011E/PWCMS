<?php
$title = $menu = 'Моя панель';
$where = 'billing';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$setting_billing = $db->query("SELECT `gradient` FROM `billing_config_prices` WHERE `id`=1")->fetch_assoc();
if(isset($_POST['ok'])){
	if(empty($_POST['color1'])){
		errorNoExit('Введите начальный цвет!');
	}elseif(empty($_POST['color2'])){
		errorNoExit('Введите конечный цвет!');
	}elseif(mb_strlen($_POST['color1']) > 6){
		errorNoExit('Длинна начального цвета не должна превышать 6 символов!');
	}elseif(mb_strlen($_POST['color2']) > 6){
		errorNoExit('Длинна конечного цвета не должна превышать 6 символов!');
	}elseif($user['money'] < $setting_billing['gradient']){
		errorNoExit('У Вас недостаточно средств!');
	}else{
		$db->query("UPDATE `users` SET `money`=`money`-".$setting_billing['gradient'].", `color1`='".$_POST['color1']."', `color2`='".$_POST['color2']."' WHERE `id`=".$user['id']."");
		header('location:/billing/services/gradient?success');
	}
}
if(isset($_GET['success'])){
	successNoExit('Градиент успешно установлен!');
}
if(isset($_GET['del_success'])){
	successNoExit('Вы успешно удалили градиент ника');
}
if(!empty($user['color1']) AND !empty($user['color2'])){
	successNoExit('У Вас уже установлен градинет ника. Сейчас Ваш ник выглядит так - '.nick($user['id']).'. Вы можете <a href="/billing/services/gradient/delete">удалить градиент ника</a>, либо заменить его.');
}
if(isset($_GET['del'])){
	if(isset($_POST['yes'])){
		$db->query("UPDATE `users` SET `color1`='', `color2`='' WHERE `id`=".$user['id']."");
		header('location:/billing/services/gradient?del_success');
	}elseif(isset($_POST['no'])){
		header('location:/billing/services/gradient/');
	}
	?>
	<div class="list1">
		<form action="" method="POST">
			Вы действительно хотите удалить градиент ника?<br>
			<input type="submit" name="yes" value="Да">
			<input type="submit" name="no" value="Нет">
		</form>
	</div>
	<?
}
?>
<div class="list1">
	<b>Цена за установку градиента ника: <font color="red"><?=$setting_billing['gradient']?>р</font></b><br>
	<form action="" method="POST">
		Начальный цвет (пример: F08080):<br>
		<input type="text" name="color1"><br>
		Конечный цвет (пример: FF0000):<br>
		<input type="text" name="color2"><br>
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