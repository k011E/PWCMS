<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Очистка оповещений';
$where = 'notifications';
$menu = $title;
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$db->query("DELETE FROM `notifications` WHERE `id_us`=".$user['id']."");
header('location:/notifications');
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>