<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Добавить новость';
$menu = 'Админ-панель | Управление новостями | Добавить новость';
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(1);
if(isset($_POST['ok'])){
	$_POST['content'] = $Filter->clearString($_POST['content']);
	if(empty($_POST['content'])){
		error('Введите содержание');
	}
	$db->query("INSERT INTO `news` SET `content`='".$_POST['content']."', `id_us`='".$user['id']."', `time`='".time()."'");
	successNoExit('Новость успешно создана.');
}
?>
<div class="list1">
	<form action="" method="POST">
		Содержание:<br>
		<textarea name="content"></textarea><br>
		<input type="submit" name="ok" value="Добавить">
	</form>
</div>
<div class="navg"><a href="/admin/news">Обратно</a></div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>