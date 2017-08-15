<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/system/includes_system.php');
if($user['journalist']==0 AND $user['admin']<3){
	header('location:/gazeta');
}
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT * FROM `gazeta_articles` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	header('location:/gazeta');
}
$article = $query->fetch_assoc();
$section = $db->query("SELECT * FROM `gazeta_sections` WHERE `id`=".$article['id_r']."")->fetch_assoc();
$title = 'Редактирование статьи "'.$Filter->output($article['name']).'"';
$menu = '<a href="/gazeta" style="color: white;">Газета</a> | <a href="/gazeta/section/'.$section['id'].'" style="color: white;">'.$Filter->output($section['name']).'</a> | <a href="/gazeta/article/'.$article['id'].'" style="color: white;">'.$Filter->output($article['name']).'</a> | Редактирование';
$where = 'gazeta';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if(isset($_POST['edit'])){
	$_POST['name'] = $Filter->input($_POST['name']);
	$_POST['text'] = $Filter->input($_POST['text']);
	if(empty($_POST['name'])){
		errorNoExit('Введите название!');
	}elseif(empty($_POST['text'])){
		errorNoExit('Введите содержание!');
	}elseif(mb_strlen($_POST['name'])>255){
		errorNoExit('Длинна названия должна быть менее 255 символов!');
	}elseif(mb_strlen($_POST['text'])>16000){
		errorNoExit('Длинна содержания должна быть менее 16000 символов!');
	}else{
		$db->query("UPDATE `gazeta_articles` SET `name`='".$_POST['name']."', `text`='".$_POST['text']."'");
		$article = $db->query("SELECT * FROM `gazeta_articles` WHERE `id`=".$_GET['id']."")->fetch_assoc();
	}
}
?>
<div class="lst">
	<form action="" method="POST">
		Название:<br>
		<input type="text" name="name" value="<?=$Filter->output($article['name'])?>"><br>
		Содержание:<br>
		<textarea name="text"><?=$Filter->output($article['text'])?></textarea><br>
		<input type="submit" name="edit">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>