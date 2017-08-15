<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Ресайз изображения';
$menu = $title;
$where = 'kab';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if(isset($_POST['submit'])){
	$SimpleImage = new SimpleImage;
	$_POST['width'] = $Filter->input($_POST['width']);
	$_POST['height'] = $Filter->input($_POST['height']);
	$_POST['percent'] = $Filter->input($_POST['percent']);
	$types = explode(',', 'png,jpg,bmp,gif,fpeg');
	$upfiletype = substr($_FILES['image']['name'], strrpos($_FILES['image']['name'], ".") + 1);
	if(!file_exists($_FILES['image']['tmp_name'])){
		error('Выберите файл');
	}elseif(!in_array($upfiletype, $types)){
		error('Запрещенный формат файла.');
	}
	$path = htmlentities($_SERVER["DOCUMENT_ROOT"].'/files/us/'.$user['id']);
	if(!file_exists($path))
		mkdir($path, 0777);
	$path = htmlentities($_SERVER["DOCUMENT_ROOT"].'/files/us/'.$user['id'].'/resize');
	if(!file_exists($path))
		mkdir($path, 0777);
	if(empty($_POST['width']) AND empty($_POST['height']) AND empty($_POST['percent'])){
		error('Размеры хоть выбери ;)');
	}elseif(!empty($_POST['width']) AND !empty($_POST['height']) AND !empty($_POST['percent'])){
		error('Ну прям все поля заполнять не нужно...');
	}
	$SimpleImage->load($_FILES['image']['tmp_name']);
	if(!empty($_POST['width']) AND !empty($_POST['height']) AND $_POST['width']<5000 AND $_POST['height']<5000 AND empty($_POST['percent'])){
		$SimpleImage->resize($_POST['width'], $_POST['height']);
	}elseif(empty($_POST['width']) AND empty($_POST['height']) AND !empty($_POST['percent']) AND $_POST['percent']<500){
		$SimpleImage->scale($_POST['percent']);
	}
	$filen = rand(0, 10000).delS(trans($_FILES['image']['name']));
	$SimpleImage->save($path.'/'.$filen);
	?>
	<div class="lst">
		<b>Готово</b><br>
		<a href="/files/us/<?=$user['id']?>/resize/<?=$filen?>">Скачать</a>
	</div>
	<?
}
?>
<div class="lst">
	<form action="" method="POST" enctype="multipart/form-data">
		Изображение:<br>
		<input type="file" name="image"><br>
		Ширина:<br>
		<input type="text" name="width" class="form-control" rows="5" autocomplete="off"><br>
		Высота:<br>
		<input type="text" name="height" class="form-control" rows="5" autocomplete="off"><br>
		Либо<br>
		Проценты<br>
		<input type="text" name="percent" class="form-control" rows="5" autocomplete="off"><br>
		<input type="submit" name="submit" value="Обработать">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>