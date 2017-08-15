<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Клеймо';
$menu = $title;
$where = 'page_user';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(2);
$_GET['id'] = abs(intval($_GET['id']));
if($db->query("SELECT `id` FROM `users` WHERE `id`='".$_GET['id']."'")->num_rows==0){
	error('Пользователя не существует');
}
if(isset($_GET['true'])){
	$db->query("UPDATE `users` SET `scam`='1' WHERE `id`='".$_GET['id']."'");
	header('location:/us'.$_GET['id']);
}elseif(isset($_GET['false'])){
	$db->query("UPDATE `users` SET `scam`='0' WHERE `id`='".$_GET['id']."'");
	header('location:/us'.$_GET['id']);
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>