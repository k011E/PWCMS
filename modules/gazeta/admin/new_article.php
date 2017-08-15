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
$title = 'Добавление статьи';
$menu = '<a href="/gazeta/section/'.$section['id'].'" style="color: white;">'.$Filter->output($section['name']).'</a> | Добавление статьи';
$where = 'gazeta';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if($user['journalist']==0){
	header('location:/gazeta');
}
if(isset($_POST['add'])){
	$_POST['name'] = $Filter->input($_POST['name']);
	$_POST['text'] = $Filter->input($_POST['text']);
	if(empty($_POST['name'])){
		errorNoExit('Введите название!');
	}elseif(empty($_POST['text'])){
		errorNoExit("Введите текст статьи!");
	}elseif(mb_strlen($_POST['name'])>255){
		errorNoExit("Длинна названия не должна быть более 255 символов!");
	}elseif(mb_strlen($_POST['text'])>16000){
		errorNoExit("Длинна статьи не должна быть более 16000 символов!");
	}else{
		$db->query("INSERT INTO `gazeta_articles` SET `id_r`=".$_GET['id'].", `name`='".$_POST['name']."', `text`='".$_POST['text']."', `id_author`=".$user['id'].", `time`=".time()."");
		successNoExit('Статья успешно добавлена');
	}
}
?>
<div class="lst">
	<form action="" method="POST">
		Название:<br>
		<input type="text" name="name"><br>
		Статья:<br>
		<textarea name="text"></textarea><br>
		<input type="submit" name="add" value="Добавить">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>