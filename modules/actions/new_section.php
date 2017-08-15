<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Новый раздел оповещений';
$where = 'notifications';
$menu = $title;
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
admin(4);
if (isset($_POST['create'])) {
	$_POST['name'] = $Filter->input($_POST['name']);
	$types = explode(',', 'png,jpg,bmp,gif,fpeg');
		$upfiletype = substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], ".") + 1);
		if(!file_exists($_FILES['file']['tmp_name'])){
			error('Выберите файл');
		}elseif($_FILES['file']['size'] > (1048576 * 5)){
			error('Максимальный размер загружаемого файла: 5 мб.');
		}elseif(!in_array($upfiletype, $types)){
			error('Файл данного формата загружать запрещено.');
		}
		$name = passgen(5).'_'.$Filter->input($_FILES['file']['name']);
		copy($_FILES['file']['tmp_name'], $_SERVER["DOCUMENT_ROOT"].'/files/notifications/'.$name);
		//$db->query("INSERT INTO `notifications_sections` SET `name`=".$_POST['name'].", `img`=".$name."");
		$db->query("INSERT INTO `notifications_sections` SET `name`='".$_POST['name']."', `img`='".$name."'");

		?>
		<div class="list1">
			Раздел успешно создан
		</div>
		<?
}
?>
<div class="lst">
	<form action="" method="POST" enctype="multipart/form-data">
		Имя:<br>
		<input type="text" name="name"><br>
		<input type="file" name="file"><br>
		<input type="submit" name="create">
	</form>
</div>
<div class="list1"><a href="/notificationsh">Вернуться</a></div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>