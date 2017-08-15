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
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT * FROM `gazeta_sections` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	header('location:/gazeta');
}
$section = $query->fetch_assoc();
$title = 'Редактирование раздела "'.$Filter->output($section['name']);
$menu = '<a href="/gazeta" style="color: white;">Газета</a> | <a href="/gazeta/section/'.$section['id'].'" style="color:white;">'.$Filter->output($section['name']).'</a> | Редактирование';
$where = 'gazeta';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if($user['journalist']==0 AND $user['admin']<3){
	header('location:/gazeta');
}
if(isset($_POST['edit'])){
	$_POST['name'] = $Filter->input($_POST['name']);
	if(empty($_POST['name'])){
		error('Введите название!');
	}elseif(mb_strlen($_POST['name'])>255){
		error('Длинна названия должна быть менее 255 символов!');
	}
	$db->query("UPDATE `gazeta_sections` SET `name`='".$_POST['name']."' WHERE `id`=".$_GET['id']."");
	successNoExit('Изменения сохранены');
	$section = $db->query("SELECT * FROM `gazeta_sections` WHERE `id`=".$_GET['id']."")->fetch_assoc();
}
?>
<div class="lst">
	<form action="" method="POST">
		Название:<br>
		<input type="text" name="name" value="<?=$Filter->output($section['name'])?>"><br>
		<input type="submit" name="edit" value="Сохранить">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>