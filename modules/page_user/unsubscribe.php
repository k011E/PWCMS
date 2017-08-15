<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
include_once($_SERVER["DOCUMENT_ROOT"].'/system/includes_system.php');
$_GET['id'] = abs(intval($_GET['id']));
mode('user');
if($db->query("SELECT `id` FROM `users` WHERE `id`=".$_GET['id']."")->num_rows==0){
	header('location:/');
}
if($db->query("SELECT `id` FROM `subscribes` WHERE `subscriber`=".$user['id']." AND `to`=".$_GET['id']."")->num_rows==0){
	header('location:/us'.$_GET['id']);
}
if($user['id']==$_GET['id']){
	header('location:/us'.$_GET['id']);
}
$db->query("DELETE FROM `subscribes` WHERE `subscriber`=".$user['id']." AND `to`=".$_GET['id']."");
$db->query("INSERT INTO `notifications` SET id_us`=".$_GET['id'].", `text`='us{".$user['id']."} отписался от Ваших новостей!', `time`=".time().", `section`=2");
header('location:/us'.$_GET['id']);
?>