<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Удаление скриншота';
$menu = $title;
$where = 'kab';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT * FROM `screens` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	error('Скриншота не существует!');
}
$screen = $query->fetch_assoc();
if($screen['id_us']!=$user['id']){
	error('Вы не можете удалять чужие скриншоты!');
}
unlink($_SERVER["DOCUMENT_ROOT"].'/files/screens/'.$screen['file']);
$db->query("DELETE FROM `screens` WHERE `id`=".$screen['id']."");
header('location:/services/screen/my');
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>