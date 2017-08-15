<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Удаление оповещений';
$menu = $title;
$where = 'notifications';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$_GET['id'] = abs(intval($_GET['id']));
$db->query("DELETE FROM `notifications` WHERE `id_us`=".$user['id']." AND `section`=".$_GET['id']."");
header('location:/notificationsh/section/'.$_GET['id']);
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>