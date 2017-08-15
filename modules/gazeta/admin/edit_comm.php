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
$query = $db->query("SELECT * FROM `gazeta_comm` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	header('location:/gazeta');
}
$comm = $query->fetch_assoc();
$article = $db->query("SELECT * FROM `gazeta_articles` WHERE `id`=".$comm['id_article']."")->fetch_assoc();
$section = $db->query("SELECT * FROM `gazeta_sections` WHERE `id`=".$article['id_r']."")->fetch_assoc();
$title = 'Редактирование комментария';
$menu = '<a href="/gazeta" style="color: white;">Газета</a> | <a href="/gazeta/section/'.$section['id'].'" style="color: white;">'.$Filter->output($section['name']).'</a> | <a href="/gazeta/article/'.$article['id'].'" style="color: white;">'.$Filter->output($article['name']).'</a> | <a href="/gazeta/comm/'.$article['id'].'" style="color: white;">Комментарии</a> | Редактирование';
$where = 'gazeta';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
admin(1);
if(isset($_POST['ok'])){
	$_POST['text'] = $Filter->input($_POST['text']);
	if(empty($_POST['text'])){
		error('Введите комментарий!');
	}elseif (mb_strlen($_POST['text'])>16000) {
		error('Длинна комментария не должна быть более 16000 символов!');
	}
	$db->query("UPDATE `gazeta_comm` SET `text`='".$_POST['text']."' WHERE `id`=".$comm['id']."");
	successNoExit('Изменения успешно сохранены');
	$comm = $db->query("SELECT * FROM `gazeta_comm` WHERE `id`=".$_GET['id']."")->fetch_assoc();
}
?>
<div class="lst">
	<form action="" method="POST">
		Комментарий:<br>
		<textarea name="text"><?=$Filter->output($comm['text'])?></textarea><br>
		<input type="submit" name="ok" value="Сохранить">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>