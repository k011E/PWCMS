<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Поиск пользователей';
$menu = $title;
$where = 'all_masters';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if(isset($_POST['ok'])){
	$_POST['info'] = $Filter->input($_POST['info']);
	$_POST['criterion'] = $Filter->input($_POST['criterion']);
	switch ($_POST['criterion']) {
		case 'id':
			$q = 'SELECT * FROM `users` WHERE `id` LIKE "%'.$_POST['info'].'%"';
			break;

		case 'nick':
			$q = "SELECT * FROM `users` WHERE `nick` LIKE '%".$_POST['info']."%'";
			break;

		case 'icq':
			$q = "SELECT * FROM `users` WHERE `icq` LIKE '%".$_POST['info']."%'";
			break;

		case 'name':
			$q = "SELECT * FROM `users` WHERE `name` LIKE '%".$_POST['info']."%'";
			break;

		case 'city':
			$q = "SELECT * FROM `users` WHERE `city` LIKE '%".$_POST['info']."%'";
			break;

		case 'country':
			$q = "SELECT * FROM `users` WHERE `country` LIKE '%".$_POST['info']."%'";
			break;

		case 'email':
			$q = "SELECT * FROM `users` WHERE `email` LIKE '%".$_POST['info']."%'";
			break;
		
		default:
			header('location:/');
			break;
	}
	$Pagination = new Pagination($q, $_GET['id']);
	$query = $db->query($q.' LIMIT '.$Pagination->start.', '.$Pagination->end.'');
	while ($search = $query->fetch_assoc()) {
		?>
		<div class="lst"><?=nick($search['id'])?></div>
		<?
	}
	$Pagination->out('/search');
	include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
	exit();
}
?>
<div class="list1">
	<form action="" method="POST">
		Критерий поиска:<br>
		<select name="criterion">
			<option value="id">ID</option>
			<option value="nick">Ник</option>
			<option value="icq">ICQ</option>
			<option value="name">Имя</option>
			<option value="city">Город</option>
			<option value="country">Страна</option>
			<option value="email">E-Mail</option>
		</select><br>
		Ищем:<br>
		<input type="text" name="info">
		<input type="submit" name="ok" value="Поиск">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>