<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Скрин страницы';
$menu = $title;
$where = 'kab';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
if(isset($_POST['create'])){
	$_POST['url'] = $Filter->input($_POST['url']);
	$_POST['height'] = $Filter->input($_POST['height']);
	$_POST['width'] = $Filter->input($_POST['width']);
	$screen = mt_rand(11111, 99999);
	$random = mt_rand(1111, 9999);
	if(empty($_POST['url'])){
		error('Вы не заполнили форму URL!');
	}elseif(empty($_POST['height'])){
		error('Вы не указали высоту скриншота!');
	}elseif(empty($_POST['width'])){
		error('Вы не указали ширину скриншота!');
	}elseif(!$Filter->validURL($_POST['url'])){
		error('URL адрес указан не верно!');
	}
	$file = $screen.'-'.$random.'.png';	
	$api = 'http://mini.s-shot.ru/'.$_POST['height'].'x'.$_POST['width'].'/JPEG/'.$_POST['height'].'/Z100/?'.$_POST['url'];
	copy($api, $_SERVER["DOCUMENT_ROOT"].'/files/screens/'.$file);
	$db->query("INSERT INTO `screens` SET `id_us`=".$user['id'].", `time`=".time().", `file`='".$file."'");
	?>
	<div class="list1">
		<center>Ваш скриншот готов!</center>
	</div>
	<div class="list1">
		<center>
			<a href="/files/screens/<?=$file?>">
				<img src="/files/screens/<?=$file?>" width="100" height="120" alt="Изображение">
			</a>
		</center>
	</div>
	<div class="list1">
		<center>
			Скопировать:<br>
			<input type="text" size="15" value="http://<?=$_SERVER['HTTP_HOST']?>/files/screens<?=$file?>" name="copy">
		</center>
	</div>
	<?
}
?>
<form action="" method="POST">
	<div class="list1">
		Введите URL сайта, который вы хотите сфотографировать!<br>
		<input type="text" name="url" value="http://" size="15">
	</div>
	<div class="list1">
		Выберите нужный вам размер скриншота!<br>
		<input type="text" name="height" size="3" value="640">
		x
		<input type="text" name="width" size="3" value="480">
	</div>
	<div class="list1">
		<input type="submit" name="create" value="Создать">
	</div>
</form>
<div class="list1">
	<a href="/services/screen/my">Мои скриншоты</a> (<?=$db->query("SELECT `id` FROM `screens` WHERE `id_us`=".$user['id']."")->num_rows?>)
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>