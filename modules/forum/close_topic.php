<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT * FROM `forum_t` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0){
	header('location:/forum');
}
$topic = $query->fetch_assoc();
if($topic['type']==3){
	header('location:/forum/thema'.$topic['id']);
}
if($user['id']!=$topic['id_author'] AND $user['admin']<1){
	header('location:/forum/thema'.$topic['id']);
}
if($topic['type']==1){
	header('location:/forum/thema'.$topic['id']);
}
$db->query("UPDATE `forum_t` SET `type`=3, `last`='".time()."' WHERE `id`='".$topic['id']."'");
$db->query("INSERT INTO `forum_p` SET `id_r`='".$thema['id_r']."', `id_pr`='".$thema['id_pr']."', `msg`='[b]Тема была закрыта :-)[/b]', `type`=0, `id_us`='".$user['id']."', `time`='".time()."', `id_thema`='".$topic['id']."'");
header('location:/forum/thema'.$topic['id']);
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>