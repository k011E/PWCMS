<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Редактирование смайла';
$menu = $title;
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(3);
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT * FROM `smiles` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0){
	error('Смайла не существует');
}
$smile = $query->fetch_assoc();
if(isset($_POST['edit'])){
	$_POST['name'] = $Filter->input($_POST['name']);
	if(empty($_POST['name'])){
		errorNoExit('Введите название');
	}else{
		$db->query("UPDATE `smiles` SET `name`='".$_POST['name']."' WHERE `id`='".$_GET['id']."'");
		$smile = $db->query("SELECT * FROM `smiles` WHERE `id`='".$_GET['id']."'")->fetch_assoc();
		successNoExit('Успешно сохранено');
	}
}
?>
<div class="list1">
	<form action="" method="POST">
		Название:<br>
		<input type="text" name="name" value="<?=$Filter->output($smile['name'])?>"><br>
		<input type="submit" name="edit" value="Сохранить">
	</form>
</div>
<div class="navg">
	<a href="/admin/smiles/r/<?=$smile['r']?>">Обратно</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>