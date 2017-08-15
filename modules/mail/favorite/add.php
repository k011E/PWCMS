<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Почта';
$menu = 'Добавление в избранное';
$where = 'mail';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$_GET['id'] = abs(intval($_GET['id']));
if($db->query("SELECT `id` FROM `users` WHERE `id`=".$_GET['id']."")->num_rows==0){
	error('Пользователя не сущетствует');
}elseif ($user['id']==$_GET['id']) {
	error('Нельзя добавить самого себя в избранное');
}
$db->query("INSERT INTO `mail_favorite` SET `id_who`=".$user['id'].", `id_whom`=".$_GET['id']."");
header('location:/mail/msg/'.$_GET['id']);
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>