<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/extensions.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/functions.php');
$_GET['id'] = abs(intval($_GET['id']));
$Notifications = new Notifications;
$title = 'Оповещения';
$menu = $Notifications->getNameSection($_GET['id']).' ('.$Notifications->getSectionNotificationCount($user['id'], $_GET['id']).')';
$where = 'notifications';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="lst">
	<a href="/notificationsh">Обратно</a>
	|
	<a href="/notificationsh/section/<?=$_GET['id']?>">Обновить</a>
	|
	<a href="/notificationsh/section/<?=$_GET['id']?>/clear">Очистить раздел "<?=$Notifications->getNameSection($_GET['id'])?>"</a>
</div>
<?
$Pagination = new Pagination("SELECT * FROM `notifications` WHERE `id_us`=".$user['id']." AND `section`=".$_GET['id']."", $_GET['page']);
$query = $db->query("SELECT * FROM `notifications` WHERE `id_us`=".$user['id']." AND `section`=".$_GET['id']." ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end."");
while ($notification = $query->fetch_assoc()) {
	$Notifications->notification($notification['id']);
}
$Pagination->out('/notificationsh/section/'.$_GET['id']);
$db->query("UPDATE `notifications` SET `read`=1 WHERE `id_us`=".$user['id']." AND `section`=".$_GET['id']."");
?>
<div class="list1"><a href="/notificationsh">Вернуться</a></div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>