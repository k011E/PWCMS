<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Создание раздела смайлов';
$menu = $title;
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(3);
if(isset($_POST['name'])){
	$_POST['name'] = $Filter->input($_POST['name']);
	if(empty($_POST['name'])){
		errorNoExit('Введите название');
	}else{
		$db->query("INSERT INTO `smiles_r` SET `name`='".$_POST['name']."'");
		successNoExit('Раздел успешно создан');
	}
}
?>
<div class="list1">
	<form action="" method="POST">
		Название:<br>
		<input type="text" name="name"><br>
		<input type="submit" name="create" value="Создать">
	</form>
</div>
<div class="navg"><a href="/admin/smiles">Обратно</a></div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>