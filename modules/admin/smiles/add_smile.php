<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Добавить смайл';
$menu = $title;
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(3);
$_GET['id'] = abs(intval($_GET['id']));
if($db->query("SELECT * FROM `smiles_r` WHERE `id`='".$_GET['id']."'")->num_rows==0){
	header('location:/admin/smiles/');
}
?>
<div class="list1">
	<form action="" method="POST" enctype="multipart/form-data">
		Название:<br>
		<input type="text" name="name"><br>
		Смайл:<br>
		<?
		$Upload = new Upload('smiles', '', '', 5, 'jpg,jpeg,png,gif,bmp', '');
		?>
	</form>
</div>
<?
if(isset($_POST['upload'])){
	$_POST['name'] = $Filter->input($_POST['name']);
	if(empty($_POST['name'])){
		errorNoExit('Введите название смайла');
	}else{
		$db->query("INSERT INTO `smiles` SET `r`='".$_GET['id']."', `name`='".$_POST['name']."', `file`='".$Upload->getName()."'");
		successNoExit('Смайл успешно загружен');
	}
}
?>
<div class="navg">
	<a href="/admin/smiles/r/<?=$_GET['id']?>">Обратно</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>