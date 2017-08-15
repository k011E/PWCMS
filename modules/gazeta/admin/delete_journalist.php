<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Снять с журналиста';
$menu = $title;
$where = 'gazeta';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if($user['admin']<3 AND $user['journalist']!=2){
	header('location:/gazeta');
}
if(isset($_GET['id'])){
	$_GET['id'] = abs(intval($_GET['id']));
	if($db->query("SELECT `id` FROM `users` WHERE `id`=".$_GET['id']."")->num_rows==0){
		error('Пользователя не существует!');
	}
	$db->query("UPDATE `users` SET `journalist`=0 WHERE `id`=".$_GET['id']."");
	successNoExit('Пользователь '.nick($_GET['id']).' снят с должности журналиста.');
}
?>
<div class="lst">
	<form action="" method="GET">
		ID пользователя: <input type="text" name="id"><input type="submit" value="Снять">
	</form>
</div>
<div class="navg">
	<a href="/gazeta/admin">Обратно</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>