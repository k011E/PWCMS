<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Добавить раздел';
$menu = $title;
$where = 'gazeta';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
if($user['admin']<3 AND $user['journalist']!=2){
	header('location:/gazeta');
}
if(isset($_POST['add'])){
	$_POST['name'] = $Filter->input($_POST['name']);
	if(empty($_POST['name'])){
		error('Введите название!');
	}elseif(mb_strlen($_POST['name'])>255){
		error('Длинна названия не должна быть более 255 символов!');
	}
	$db->query("INSERT INTO `gazeta_sections` SET `name`='".$_POST['name']."'");
	successNoExit("Раздел \"<b>".$Filter->output($_POST['name'])."</b>\" успешно создан");
}
?>
<div class="lst">
	<form action="" method="POST">
		Название: <input type="text" name="name"><input type="submit" name="add" value="Добавить">
	</form>
</div>
<div class="navg">
	<a href="/gazeta/admin">Обратно</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>