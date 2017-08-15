<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Редактирование новости';
$menu = 'Редактирование новости';
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(1);
if(!$Filter->validInt($_GET['id'])) $_GET['id'] = $Filter->clearInt($_GET['id']);
$query = $db->query("SELECT * FROM `news` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	error('Новости не существует.');
}
$news = $query->fetch_assoc();
if(isset($_POST['ok'])){
	if(empty($_POST['content'])){
		errorNoExit('Введите новость.');
	}else{
		$db->query("UPDATE `news` SET `content`='".$_POST['content']."' WHERE `id`='".$_GET['id']."'");
		successNoExit('Новость сохранена.');
	}
}
?>
<div class="list1">
	<form action="" method="POST">
		Содержание:<br>
		<textarea name="content"><?=$news['content']?></textarea><br>
		<input type="submit" name="ok" value="Сохранить">
	</form>
</div>
<div class="navg"><a href="/admin/news">Обратно</a></div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>