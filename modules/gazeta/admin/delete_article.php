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
$title = 'Удаление статьи "'.$Filter->output($article['name']).'"';
$menu = '<a href="/gazeta" style="color: white;">Газета</a> | <a href="/gazeta/section/'.$section['id'].'" style="color: white;">'.$Filter->output($section['name']).'</a> | <a href="/gazeta/article/'.$article['id'].'" style="color: white;">'.$Filter->output($article['name']).'</a> | Удаление';
$where = 'gazeta';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if(isset($_POST['yes'])){
	$db->query("DELETE FROM `gazeta_articles` WHERE `id`=".$article['id']."");
	header('location:/gazeta/section/'.$section['id']);
}elseif(isset($_POST['no'])){
	header('location:/gazeta/article/'.$article['id']);
}
?>
<div class="lst">
	<form action="" method="POST">
		Вы действительно уверены в том, чтобы удалить статью <b>"<?=$Filter->output($article['name'])?>"</b><br>
		<input type="submit" name="yes" value="Да">
		<input type="submit" name="no" value="Нет">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>