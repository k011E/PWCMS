<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Восстановление поста';
$where = 'forum';
$menu = $title;
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
admin(3);
$_GET['id'] = abs(intval($_GET['id']));
$_GET['page'] = abs(intval($_GET['page']));
$query = $db->query("SELECT * FROM `forum_p` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	error('Поста не существует');
}
$p = $query->fetch_assoc();
$t = $db->query("SELECT * FROM `forum_t` WHERE `id`=".$p['id_thema']."")->fetch_assoc();
$ups = $db->query("SELECT `admin` FROM `users` WHERE `id`=".$p['id_us']."")->fetch_assoc();
if($user['admin']>=3 AND $t['type']!=1 AND $p['type']==1){
	$db->query("UPDATE `forum_p` SET `type`=0, `del_us`=0, `rec_us`=".$user['id']." WHERE `id`=".$_GET['id']."");
	header('location:/forum/thema'.$p['id_thema'].'/page'.$_GET['page']);
}else{
	error('Произошла ошибка.');
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>