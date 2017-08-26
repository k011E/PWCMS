<?php
$title = $menu = 'Моя панель';
$where = 'billing';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$setting_billing = $db->query("SELECT `attachment` FROM `billing_config_prices` WHERE `id`=1")->fetch_assoc();
if(isset($_POST['ok'])){
	$_POST['id_thema'] = abs(intval($_POST['id_thema']));
	$_POST['time'] = abs(intval($_POST['time']));
	if(empty($_POST['id_thema'])){
		error('Ввидите ID темы!');
	}elseif(empty($_POST['time'])){
		error('Ввдите время закрепления темы!');
	}elseif($db->query("SELECT `id` FROM `forum_t` WHERE `id`=".$_POST['id_thema']."")->num_rows==0){
		error('Темы не существует!');
	}elseif(($_POST['time'] * $setting_billing['attachment']) > $user['money']){
		error('У Вас недостаточно средств!');
	}else{
		$timeplus = time() + ($_POST['time']*24*60*60);
		$db->query("UPDATE `users` SET `money`=`money`-".$setting_billing['attachment']." WHERE `id`=".$user['id']."");
		$db->query("UPDATE `forum_t` SET `type`=4 WHERE `id`=".$_POST['id_thema']."");
		$db->query("INSERT INTO `billing_attachment_themes` SET `id_thema`=".$_POST['id_thema'].", `id_us`=".$user['id'].", `time_start`=".time().", `time_end`=".$timeplus."");
		header('location:/billing/services/attachment?success');
	}
}
if(isset($_GET['success'])){
	successNoExit('Вы успешно закрепили тему');
}
?>
<div class="list1">
	<b>Цена прикрепления темы: <font color="red"><?=$setting_billing['attachment']?>р/24ч</font></b><br>
	<form action="" method="POST">
		ID темы:<br>
		<input type="number" name="id_thema"><br>
		Время:<br>
		<input type="number" name="time"> суток<br>
		<small>Цена = время * <?=$setting_billing['attachment']?></small><br>
		<input type="submit" name="ok" value="Прикрепить">
	</form>
</div>
<div class="menu">
	Мои закреплённые темы
</div>
<?
if($db->query("SELECT `id` FROM `billing_attachment_themes` WHERE `id_us`=".$user['id']."")->num_rows==0){
	errorNoExit('Закреплённых тем у Вас нет!');
}else{
	$query = $db->query("SELECT * FROM `billing_attachment_themes` WHERE `id_us`=".$user['id']."");
	while ($thema = $query->fetch_assoc()) {
		$Forum = new Forum(0);
		?>
		<div class="lst">
			<?=imgT($thema['id_thema'])?> <a href="/forum/thema<?=$thema['id_thema']?>/"><?=$Forum->nameThema($thema['id_thema'])?></a> (<?=countPosts($thema['id_thema'])?>) <?=lstPage($thema['id_thema'])?>
		</div>
		<?
	}
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