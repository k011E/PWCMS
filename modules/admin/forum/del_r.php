<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$_GET['id'] = abs(intval($_GET['id']));
include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/extensions.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/functions.php');
$query = $db->query("SELECT * FROM `forum_r` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0){
	header('location:/admin/forum');
}
$r = $query->fetch_assoc();
$title = 'Удаление раздела "'.$Filter->output($r['name']).'"';
$menu = $title;
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(3);
if(isset($_POST['yes'])){
	$db->query("DELETE FROM `forum_r` WHERE `id`='".$_GET['id']."'");
	success('Раздел "'.$Filter->output($r['name']).'" успешно удалён<div class="navg"><a href="/admin/forum/">Обратно</a></div>');
}elseif(isset($_POST['no'])){
	header('location:/admin/forum/r/'.$r['id']);
}
?>
<div class="list1">
	<form action="" method="POST">
		Вы действительно хотите удалить раздел на форуме "<?=$Filter->output($r['name'])?>"<br>
		<input type="submit" name="yes" value="Да">
		<input type="submit" name="no" value="Нет">
	</form>
</div>
<div class="navg"><a href="/admin/forum/r/<?=$_GET['id']?>">Обратно</a></div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>