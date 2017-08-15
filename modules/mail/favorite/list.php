<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
include_once($_SERVER["DOCUMENT_ROOT"].'/system/includes_system.php');
mode('user');
$title = 'Избранные';
$menu = 'Избранные Вами ('.$db->query("SELECT `id` FROM `mail_favorite` WHERE `id_who`=".$user['id']."")->num_rows.') чел.';
$where = 'mail';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
$Pagination = new Pagination("SELECT * FROM `mail_favorite` WHERE `id_who`=".$user['id']."", $_GET['page']);
$query = $db->query("SELECT * FROM `mail_favorite` WHERE `id_who`=".$user['id']." ORDER BY `id` DESC LIMIT $Pagination->start, $Pagination->end");
while ($human = $query->fetch_assoc()) {
	?>
	<div class="lst">
		<?=nick($human['id_whom'])?>
	</div>
	<?
}
if($query->num_rows==0){
	errorNoExit('Избранных нет!');
}
$Pagination->out('/mail/favorite/list');
?>
<div class="navg">
	<a href="/kab">Личный кабинет</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>