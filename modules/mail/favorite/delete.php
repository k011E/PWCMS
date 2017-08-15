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
$menu = 'Удаление из избранного';
$where = 'mail';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$_GET['id'] = abs(intval($_GET['id']));
if($db->query("SELECT `id` FROM `users` WHERE `id`=".$_GET['id']."")->num_rows==0){
	error('Пользователя не существует');
}elseif($db->query("SELECT `id` FROM `mail_favorite` WHERE `id_who`=".$user['id']." AND `id_whom`=".$_GET['id']."")->num_rows==0){
	error('Данного пользователя нет в Вашем избранном');
}
$db->query("DELETE FROM `mail_favorite` WHERE `id_who`=".$user['id']." AND `id_whom`=".$_GET['id']."");
header('location:/mail/msg/'.$_GET['id']);
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>