<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Создание подраздела';
$menu = $title;
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(3);
$_GET['id'] = abs(intval($_GET['id']));
if($db->query("SELECT `id` FROM `forum_r` WHERE `id`='".$_GET['id']."'")->num_rows==0){
	error('Раздела не существует.');
}
if(isset($_POST['ok'])){
	$_POST['name'] = $Filter->input($_POST['name']);
	$_POST['rules'] = $Filter->input($_POST['rules']);
	if(empty($_POST['name'])){
		errorNoExit('Введите название');
	}elseif (empty($_POST['rules'])) {
		errorNoExit('Введите правила');
	}else{
		$db->query("INSERT INTO `forum_pr` SET `name`='".$_POST['name']."', `rules`='".$_POST['rules']."', `r`='".$_GET['id']."'");
		successNoExit('Подраздел успешно создан');
	}
}
?>
<div class="list1">
	<form action="" method="POST">
		Название:<br>
		<input type="text" name="name"><br>
		Правила подраздела:<br>
		<textarea name="rules"></textarea><br>
		<input type="submit" name="ok" value="Создать">
	</form>
</div>
<div class="navg">
	<a href="/admin/forum/r/<?=$_GET['id']?>">Обратно</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>