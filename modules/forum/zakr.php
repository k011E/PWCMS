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
admin(3);
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT * FROM `forum_t` WHERE `id`='".$_GET['id']."'");
if($query->num_rows){
	header('location:/forum');
}
$topic = $query->fetch_assoc();
if($topic['type']==0){
	error('Тема уже закреплена');
}elseif($topic['type']==3){
	error('Тема закрыта');
}elseif($topic['type']==1){
	error('Тема удалена');
}
$db->query("UPDATE `forum_t` SET `type`=0, `last`='".time()."' WHERE `id`='".$topic['id']."'");
$db->query("INSERT INTO `forum_p` SET `id_r`='".$topic['id_r']."', `id_pr`='".$topic['pr']."', `msg`='[b]Тема была закреплена :-)[/b]', `type`=0, `id_us`='".$user['id']."', `time`='".time()."', `id_thema`='".$topic['id']."'");
header('location:/forum/thema'.$topic['id']);
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>