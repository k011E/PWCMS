<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Блок аккаунта';
$menu = $title;
$where = 'kab';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if(isset($_POST['block'])){
	$_POST['cause'] = $Filter->input($_POST['cause']);
	if(empty($_POST['cause'])){
		errorNoExit('Введите причину блокировки');
	}else{
		$db->query("UPDATE `users` SET `block`='".$_POST['cause']."' WHERE `id`='".$user['id']."'");
		header('location:/');
	}
}
?>
<div class="lst">
	<form action="" method="POST">
		Причина блокировки (не нарушая пунктов правил сайта):<br>
		<textarea name="cause"></textarea><br>
		<input type="submit" name="block" value="Заблокировать аккаунт">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>