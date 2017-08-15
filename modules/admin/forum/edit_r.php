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
$query = $db->query("SELECT * FROM `forum_r` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0){
	header('location:/');
}
$r = $query->fetch_assoc();
$title = 'Редактирование раздела "'.$Filter->output($r['name']).'"';
$menu = $title;
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(3);
if(isset($_POST['edit'])){
	$_POST['name'] = $Filter->input($_POST['name']);
	if(empty($_POST['name'])){
		errorNoExit('Введите название');
	}else{
		$db->query("UPDATE `forum_r` SET `name`='".$_POST['name']."' WHERE `id`='".$_GET['id']."'");
		$r = $db->query("SELECT * FROM `forum_r` WHERE `id`='".$_GET['id']."'")->fetch_assoc();
		successNoExit('Раздел успешно отредактирован');
	}
}
?>
<div class="list1">
	<form action="" method="POST">
		Название:<br>
		<input type="text" name="name" value="<?=$Filter->output($r['name'])?>"><br>
		<input type="submit" name="edit" value="Сохранить">
	</form>
</div>
<div class="navg"><a href="/admin/forum/r/<?=$_GET['id']?>">Обратно</a></div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>