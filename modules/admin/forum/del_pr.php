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
$query = $db->query("SELECT * FROM `forum_pr` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0){
	header('location:/admin/forum');
}
$pr = $query->fetch_assoc();
$title = 'Удаление подраздела "'.$Filter->output($pr['name']).'"';
$menu = $title;
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(3);
if(isset($_POST['yes'])){
	$db->query("DELETE FROM `forum_pr` WHERE `id`='".$pr['id']."'");
	header('location:/admin/forum/r/'.$pr['r']);
}elseif(isset($_POST['no'])){
	header('location:/admin/forum/pr/'.$pr['id']);
}
?>
<div class="list1">
	Вы действительно хотите удалить подраздел "<?=$Filter->output($pr['name'])?>"?<br>
	<form action="" method="POST">
		<input type="submit" name="yes" value="Да">
		<input type="submit" name="no" value="Нет">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>