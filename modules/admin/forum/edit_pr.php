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
$title = 'Редактирование подраздела "'.$Filter->output($pr['name']).'"';
$menu = $title;
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(3);
if(isset($_POST['ok'])){
	$_POST['name'] = $Filter->input($_POST['name']);
	$_POST['rules'] = $Filter->input($_POST['rules']);
	if(empty($_POST['name'])){
		errorNoExit('Введите название подраздела');
	}elseif(empty($_POST['rules'])){
		errorNoExit('Введите правила подраздела');
	}else{
		$db->query("UPDATE `forum_pr` SET `name`='".$_POST['name']."', `rules`='".$_POST['rules']."' WHERE `id`='".$_GET['id']."'");
		$pr = $db->query("SELECT * FROM `forum_pr` WHERE `id`='".$_GET['id']."'")->fetch_assoc();
		successNoExit('Продраздел успешно отредактирован');
	}
}
?>
<div class="list1">
	<form action="" method="POST">
		Название:<br>
		<input type="text" name="name" value="<?=$Filter->output($pr['name'])?>"><br>
		Правила:<br>
		<textarea name="rules"><?=$Filter->output($pr['rules'])?></textarea><br>
		<input type="submit" name="ok" value="Сохранить">
	</form>
</div>
<div class="navg">
	<a href="/admin/forum/pr/<?=$_GET['id']?>">Обратно</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>