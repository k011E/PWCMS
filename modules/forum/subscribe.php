<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Подписаться на тему';
$menu = $title;
$where = 'forum';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$_GET['id'] = abs(intval($_GET['id']));
if($db->query("SELECT `id` FROM `forum_t` WHERE `id`='".$_GET['id']."' AND `type`=1")->num_rows!=0){
	header('location:/forum/thema'.$_GET['id']);
}
if($db->query("SELECT `id` FROM `forum_t` WHERE `id`='".$_GET['id']."'")->num_rows==0){
	error('Темы не существует');
}
if($db->query("SELECT `id` FROM `forum_podp` WHERE `id_us`='".$user['id']."' AND `id_thema`='".$_GET['id']."'")->num_rows==0){
	$db->query("INSERT INTO `forum_podp` SET `id_us`='".$user['id']."', `id_thema`='".$_GET['id']."'");
}else{
	$db->query("DELETE FROM `forum_podp` WHERE `id_us`='".$user['id']."' AND `id_thema`='".$_GET['id']."'");
}
header('location:/forum/thema'.$_GET['id']);
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>