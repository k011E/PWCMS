<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Восстановление пароля';
$menu = $title;
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('guest');
$_GET['tocken'] = $Filter->clearString($_GET['tocken']);
$query = $db->query("SELECT * FROM `repass` WHERE `tocken`='".$_GET['tocken']."'");
if($query->num_rows==0){
	error('Заявки не существует.');
}
$repass = $query->fetch_assoc();
if($repass['activation']!=0){
	error('Заявка была уже использована.');
}elseif($repass['time']<time()-86400){
	error('Срок действия заявки истёк.');
}
if(isset($_POST['ok'])){
	if($_POST['password']!=$_POST['confirmPassword']){
		error('Пароли не совпадают');
	}elseif(empty($_POST['password'])){
		error('Введите пароль');
	}else{
		$db->query("UPDATE `users` SET `password`='".crypt($_POST['password'], '$1$rasmusle$')."', `tocken`=0 WHERE `id`='".$repass['id_us']."'");
		$db->query("UPDATE `repass` SET `activation`=1 WHERE `tocken`='".$_GET['tocken']."'");
		success('Пароль успешно изменён. <a href="/log.in.php">Авторизоваться</a>');
	}
}	
?>
<div class="list1">
	<form action="" method="POST">
		Новый пароль:<br>
		<input type="password" name="password"><br>
		Подтверждение пароля:<br>
		<input type="password" name="confirmPassword"><br>
		<input type="submit" name="ok" value="Изменить пароль">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>