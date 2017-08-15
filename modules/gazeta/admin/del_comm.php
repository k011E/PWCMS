<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Удаление комментария';
$menu = $title;
$where = 'gazeta';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
admin(1);
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT * FROM `gazeta_comm` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	error('Комментария не существует');
}
$comm = $query->fetch_assoc();
$db->query("DELETE FROM `gazeta_comm` WHERE `id`=".$_GET['id']."");
header('location:/gazeta/comm/'.$comm['id_article']);
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>