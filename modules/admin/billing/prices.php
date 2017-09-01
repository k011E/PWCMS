<?php
$title = 'Управление биллингом';
$menu = '<a href="/admin" style="color: white;">Админ-панель</a> | <a href="/admin/billing" style="color: white;">Управление биллингом</a> | Настройка цен';
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
admin(4);
if(isset($_POST['ok'])){
	$_POST['attachment'] = abs(intval($_POST['attachment']));
	$_POST['gradient'] = abs(intval($_POST['gradient']));
	$_POST['flashing'] = abs(intval($_POST['flashing']));
	$_POST['status'] = abs(intval($_POST['status']));
	$_POST['icon'] = abs(intval($_POST['icon']));
	$_POST['change_nick'] = abs(intval($_POST['change_nick']));
	$_POST['ads_home'] = abs(intval($_POST['ads_home']));
	$_POST['ads_all'] = abs(intval($_POST['ads_all']));
	$_POST['ads_all_down'] = abs(intval($_POST['ads_all_down']));
	$_POST['ads_color'] = abs(intval($_POST['ads_color']));
	$_POST['ads_fat'] = abs(intval($_POST['ads_fat']));
	$_POST['ads_emphasis'] = abs(intval($_POST['ads_emphasis']));
	$db->query("UPDATE `billing_config_prices` SET `attachment`=".$_POST['attachment'].", `gradient`=".$_POST['gradient'].", `flashing`=".$_POST['flashing'].", `status`=".$_POST['status'].", `icon`=".$_POST['icon'].", `change_nick`=".$_POST['change_nick'].", `ads_home`=".$_POST['ads_home'].", `ads_all`=".$_POST['ads_all'].", `ads_all_down`=".$_POST['ads_all_down'].", `ads_color`=".$_POST['ads_color'].", `ads_fat`=".$_POST['ads_fat'].", `ads_emphasis`=".$_POST['ads_emphasis']."");
}
$config_billing = $db->query("SELECT * FROM `billing_config_prices` WHERE `id`=1")->fetch_assoc();
?>
<div class="lst">
	В данном разделе Вы можете настроить цены услуг в биллинге
</div>
<div class="list1">
	<form action="" method="POST">
		Прикрепление тем(р/сут):<br>
		<input type="number" name="attachment" value="<?=$config_billing['attachment']?>"><br>
		Градиент ника:<br>
		<input type="number" name="gradient" value="<?=$config_billing['gradient']?>"><br>
		Мигание ника:<br>
		<input type="number" name="flashing" value="<?=$config_billing['flashing']?>"><br>
		Личный статус:<br>
		<input type="number" name="status" value="<?=$config_billing['status']?>"><br>
		Иконка возле ника:<br>
		<input type="number" name="icon" value="<?=$config_billing['icon']?>"><br>
		Экспресс смена ника:<br>
		<input type="number" name="change_nick" value="<?=$config_billing['change_nick']?>"><br>
		Реклама на главной странице (руб/сутки):<br>
		<input type="number" name="ads_home" value="<?=$config_billing['ads_home']?>"><br>
		Все страницы (верх)(руб/сутки):<br>
		<input type="number" name="ads_all" value="<?=$config_billing['ads_all']?>"><br>
		Все страницы (низ)(руб/сутки):<br>
		<input type="number" name="ads_all_down" value="<?=$config_billing['ads_all_down']?>"><br>
		Цвет рекламной ссылки (руб/сутки):<br>
		<input type="number" name="ads_color" value="<?=$config_billing['ads_color']?>"><br>
		Жирность рекламной ссылки (руб/сутки)<br>
		<input type="number" name="ads_fat" value="<?=$config_billing['ads_fat']?>"><br>
		Подчёркнутость рекламной ссылки (руб/сутки)<br>
		<input type="number" name="ads_emphasis" value="<?=$config_billing['ads_emphasis']?>"><br>
		<input type="submit" name="ok" value="Сохранить">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>