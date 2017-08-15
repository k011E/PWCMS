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
$db->query("DELETE FROM `repass` WHERE `time`<".(time()-86400)."");
if(isset($_POST['send'])){
	$_POST['nick'] = $Filter->clearString($_POST['nick']);
	$query = $db->query("SELECT * FROM `users` WHERE `nick`='".$_POST['nick']."'");
	if($query->num_rows==0){
		errorNoExit('Пользователя с данным ником не существует.');
	}else{
		$u = $query->fetch_assoc();
		if($db->query("SELECT `id` FROM `repass` WHERE `id_us`='".$u['id']."' AND `activation`=0")->num_rows!=0){
			error('Ваша прошлая заявка на восстановление пароля не была активирована. Дождитесь окончания её срока действия.');
		}
		$tocken = md5(rand(0, 10)+time()+rand(0, 100));
		$db->query("INSERT INTO `repass` SET `id_us`='".$u['id']."', `time`='".time()."', `tocken`='".$tocken."'");
		mail($u['email'], 'Восстановление пароля', 'Для продолжения процедуры восстановления пароля, перейдите по ссылке - http://'.$_SERVER['HTTP_HOST'].'/reamind/tocken/'.$tocken);
		success('На E-Mail указанный в анкете была отправлена инстукция для восстановления пароля. Заявка действует одни сутки.');
	}
}
?>
<div class="list1">
	<form action="" method="POST">
		Ваш ник:<br>
		<input type="text" name="nick"><br>
		<input type="submit" name="send">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>