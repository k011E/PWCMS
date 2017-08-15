<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Удаление смайла';
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
if(isset($_POST['yes'])){
	unlink($_SERVER["DOCUMENT_ROOT"].'/files/smiles/'.$smile['file']);
	$db->query("DELETE FROM `smiles` WHERE `id`='".$_GET['id']."'");
	header('location:/admin/smiles/r/'.$smile['r']);
}elseif(isset($_POST['no'])){
	header('location:/admin/smiles/r/'.$smile['r']);
}
?>
<div class="list1">
	<form action="" method="POST">
		Вы действительно хотите удалить смайл <?=$Filter->output($smile['name'])?>(<img src="/files/smiles/<?=$Filter->output($smile['file'])?>">)<br>
		<input type="submit" name="yes" value="Да">
		<input type="submit" name="no" value="Нет">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>