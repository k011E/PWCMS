<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Удаление раздела';
$menu = $title;
$where = 'gazeta';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if($user['admin']<3 AND $user['journalist']!=2){
	header('location:/gazeta');
}
$_GET['id'] = abs(intval($_GET['id']));
if($db->query("SELECT `id` FROM `gazeta_sections` WHERE `id`=".$_GET['id']."")->num_rows==0){
	error('Раздела не существует!');
}
$db->query("DELETE FROM `gazeta_sections` WHERE `id`=".$_GET['id']."");
$query = $db->query("SELECT * FROM `gazeta_articles` WHERE `id_r`=".$_GET['id']."");
while ($a = $query->fetch_assoc()) {
	$db->query("DELETE FROM `gazeta_articles` WHERE `id`=".$a['id']."");
	$db->query("DELETE FROM `gazeta_comm` WHERE `id_article`=".$a['id']."");
	unlink($_SERVER["DOCUMENT_ROOT"].'/files/gazeta/'.$a['id'].'.jpg');

}
header('location:/gazeta');
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>