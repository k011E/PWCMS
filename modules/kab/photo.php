<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Добавить аватарку';
$menu = 'Добавление аватарки';
$where = 'kab';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if(isset($_GET['del'])){
	unlink($_SERVER["DOCUMENT_ROOT"].'/files/avs/'.$user['id'].'.jpg');
	header('location:/photo.php');
}
?>
<?if(!file_exists($_SERVER["DOCUMENT_ROOT"].'/files/avs/'.$user['id'].'.jpg')){?>
	<div class="list1">
		<form action="" method="POST" enctype="multipart/form-data">
			Фотография:<br>
			<?
			$Upload = new Upload('avs', $user['id'], 'jpg', 5, 'jpg,jpeg,png,bmp,gif', 'Аватар успешно изменён', 'photo.php');
			?>
		</form>
		<b>* До 5 мб.</b>
	</div>
<?}else{?>
	<div class="lst">
		<img src="/files/avs/<?=$user['id']?>.jpg" style="max-width: 208px; max-height: 208px;" alt="*"><br>
		<a href="?del">Удалить аву</a>
	</div>
<?}?>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>