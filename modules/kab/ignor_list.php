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
$title = 'Игнор-лист';
$menu = 'Ваш игнор-лист ('.$db->query("SELECT `id` FROM `mail_ignor` WHERE `who`=".$user['id']."")->num_rows.') чел.';
$where = 'kab';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
if(isset($_GET['delete'])){
	$_GET['delete'] = abs(intval($_GET['delete']));
	$db->query("DELETE FROM `mail_ignor` WHERE `who`=".$user['id']." AND `whom`=".$_GET['delete']."");
	header('location:/kab/ignor_list');
}
$Pagination = new Pagination("SELECT * FROM `mail_ignor` WHERE `who`=".$user['id']."", $_GET['page']);
$query = $db->query("SELECT * FROM `mail_ignor` WHERE `who`=".$user['id']." ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end);
while ($ign = $query->fetch_assoc()) {
	?>
	<div class="lst">
		<?=nick($ign['whom'])?> [<a href="/kab/ignor_list/delete/<?=$ign['whom']?>">x</a>]
	</div>
	<?
}
if($query->num_rows==0){
	errorNoExit('Игнор-лист пуст!');
}
$Pagination->out('/kab/ignor_list');
?>
<div class="navg">
	<a href="/kab">Личный кабинет</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>