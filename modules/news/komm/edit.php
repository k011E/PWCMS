<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Редактирование комментария';
$where = 'news';
$menu = $title;
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(1);
if(!$Filter->validInt($_GET['id'])) $_GET['id'] = $Filter->clearInt($_GET['id']);
if(!$Filter->validInt($_GET['idk'])) $_GET['idk'] = $Filter->clearInt($_GET['idk']);
if($db->query("SELECT * FROM `news` WHERE `id`=".$_GET['id']."")->num_rows==0){
	error('Новости не существует или она была удалена.');
}elseif($db->query("SELECT * FROM `news_comm` WHERE `id`=".$_GET['idk']."")->num_rows==0){
	error('Комментария не существует.');
}
$comm = $db->query("SELECT * FROM `news_comm` WHERE `id`='".$_GET['idk']."'")->fetch_assoc();
if($comm['id_news']!=$_GET['id'])
	error();
if(isset($_POST['ok'])){
	$_POST['content'] = $Filter->clearString($_POST['content']);
	if(empty($_POST['content'])){
		errorNoExit('Введите текст комментария');
	}else{
		$db->query("UPDATE `news_comm` SET `content`='".$_POST['content']."' WHERE `id`=".$_GET['idk']."");
		successNoExit('Комментарий сохранён');
		$comm = $db->query("SELECT * FROM `news_comm` WHERE `id`='".$_GET['idk']."'")->fetch_assoc();
	}
}
?>
<div class="list1">
	<form action="" method="POST">
		Комментарий:<br>
		<textarea name="content"><?=$Filter->output($comm['content'])?></textarea><br>
		<input type="submit" name="ok" value="Сохранить">
	</form>
</div>
<div class="navg"><a href="/komm<?=$comm['id_news']?>">Обратно</a></div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>