<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Удаление новости';
$menu = 'Удаление новости';
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(1);
if(!$Filter->validInt($_GET['id'])) $_GET['id'] = $Filter->clearInt($_GET['id']);
$query = $db->query("SELECT * FROM `news` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	error('Новости не существует.');
}
$news = $query->fetch_assoc();
if(isset($_POST['yes'])){
	$db->query("DELETE FROM `news` WHERE `id`='".$_GET['id']."'");
	$db->query("DELETE FROM `news_comm` WHERE `id_news`='".$_GET['id']."'");
	header('location:/admin/news');
}elseif(isset($_POST['no'])){
	header('location:/admin/news');
}
?>
<div class="list1">
	Вы действительно хотите удалить новость:
	<div class="cit">
		<?=$Filter->output($news['content'])?><br>
		Добавил: <?=nick($news['id_us'])?> (<?=datef($news['time'])?>)<br>
	</div>
	<form action="" method="POST">
		<input type="submit" name="yes" value="Да">
		<input type="submit" name="no" value="Нет">
	</form>
</div>
<div class="navg"><a href="/admin/news">Обратно</a></div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>