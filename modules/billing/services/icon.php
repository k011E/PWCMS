<?php
$title = $menu = 'Моя панель';
$where = 'billing';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$billing_setting = $db->query("SELECT `icon` FROM `billing_config_prices` WHERE `id`=1")->fetch_assoc();
if(isset($_POST['upload'])){
	$db->query("UPDATE `users` SET `money`=`money`-".$billing_setting['icon']." WHERE `id`=".$user['id']."");
	$db->query("UPDATE `users` SET `icon`='".$user['id'].".png' WHERE `id`=".$user['id']."");
}
if(isset($_POST['success'])){
	successNoExit('Вы установили иконку возле ника!');
}
if(isset($_GET['del'])){
	unlink($_SERVER["DOCUMENT_ROOT"].'/files/icon/'.$user['id'].'.png');
	$db->query("UPDATE `users` SET `icon`='' WHERE `id`=".$user['id']."");
	header('location:/billing/services/icon');
}
?>
<div class="lst">
	Здесь Вы можете сменить иконку отображающуюся возле ника
</div>
<?
if(!empty($user['icon'])){
	?>
	<div class="lst">
		У Вас уже установлена иконка возле ника: <img src="/files/icon/<?=$user['id']?>.png" style="width: 16px; height: 16px;"><br>
		<a href="?del"><input type="submit" name="delete" value="Удалить"></a>
	</div>
	<?
}
?>
<div class="list1">
	<b>Цена смены иконки возле ника: <font color="red"><?=$billing_setting['icon']?>р</font><br>
	*После смены иконки, Вы сможете бесплатно её менять.</b><br>
	Иконка (размер 16x16, формат .png):<br>
	<?
	$Upload = new Upload('icon', $user['id'], 'png', 1, 'png', '' , 'billing/services/icon?success');
	?>
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