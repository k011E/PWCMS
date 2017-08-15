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
$title = 'Изменение фотографии статьи "'.$Filter->output($article['name']).'"';
$menu = '<a href="/gazeta" style="color: white;">Газета</a> | <a href="/gazeta/section/'.$section['id'].'" style="color: white;">'.$Filter->output($section['name']).'</a> | <a href="/gazeta/article/'.$article['id'].'" style="color: white;">'.$Filter->output($article['name']).'</a> | Изменение фотографии';
$where = 'gazeta';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if(isset($_GET['del'])){
	unlink($_SERVER["DOCUMENT_ROOT"].'/files/gazeta/'.$article['id'].'.jpg');
	header('location:/gazeta/admin/edit_photo/'.$article['id']);
}
if(!file_exists($_SERVER["DOCUMENT_ROOT"].'/files/gazeta/'.$article['id'].'.jpg')){?>
	<div class="list1">
		<form action="" method="POST" enctype="multipart/form-data">
			Фотография для статьи:<br>
			<?
			$Upload = new Upload('gazeta', $article['id'], 'jpg', 5, 'jpg,jpeg,png,bmp,gif', 'Фотография статьи успешно изменена', 'gazeta/admin/edit_photo/'.$article['id']);
			?>
		</form>
		<b>* До 5 мб.</b>
	</div>
<?}else{?>
	<div class="lst">
		<img src="/files/gazeta/<?=$article['id']?>.jpg" style="max-width: 208px; max-height: 208px;" alt="*"><br>
		<a href="?del">Удалить фотографию</a>
	</div>
<?}?>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>