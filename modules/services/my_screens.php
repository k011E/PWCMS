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
$title = 'Мои скриншоты';
$menu = $title.' ('.$db->query("SELECT `id` FROM `screens` WHERE `id_us`=".$user['id']."")->num_rows.')';
$where = 'kab';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
$Pagination = new Pagination("SELECT * FROM `screens` WHERE `id_us`=".$user['id']."", $_GET['page']);
$query = $db->query("SELECT * FROM `screens` WHERE `id_us`=".$user['id']." ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end."");
while ($screen = $query->fetch_assoc()) {
	?>
	<div class="lst">
		<a href="/files/screens/<?=$screen['file']?>">
			<img src="/files/screens/<?=$screen['file']?>" alt="*" width="60" higth="60">
		</a>
		(<?=datef($screen['time'])?>) <a href="/services/screen/my/<?=$screen['id']?>/delete">удал.</a>
	</div>
	<?
}
if($db->query("SELECT `id` FROM `screens` WHERE `id_us`=".$user['id']."")->num_rows==0){
	?>
	<div class="lst">
		Скриншотов нет...
	</div>
	<?
}
$Pagination->out('/services/screen/my');
?>
<div class="list1"><a href="/services/screen">Вернуться</a></div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>