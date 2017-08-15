<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Удаление комментария';
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
if(isset($_POST['yes'])){
	$db->query("DELETE FROM `news_comm` WHERE `id`='".$_GET['idk']."'");
	header('location:/komm'.$_GET['id']);
}elseif(isset($_POST['no'])){
	header('location:/komm'.$_GET['id']);
}
?>
<div class="list1">
	<form action="" method="POST">
	Вы действительно хотите удалить данный комментарий:
		<div class="cit">
			<?=nick($comm['id_us'])?> (<?=datef($comm['time'])?>)<br>
			<?=$Filter->output($comm['content'])?><br>
		</div>
		<input type="submit" name="yes" value="Да">
		<input type="submit" name="no" value="Нет">
	</form>
</div>
<div class="navg"><a href="/komm<?=$_GET['id']?>">Обратно</a></div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>