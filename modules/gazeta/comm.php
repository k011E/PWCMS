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
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT * FROM `gazeta_articles` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	header('location:/gazeta');
}
$article = $query->fetch_assoc();
$section = $db->query("SELECT * FROM `gazeta_sections` WHERE `id`=".$article['id_r']."")->fetch_assoc();
$title = 'Комментарии '.$Filter->output($article['name']);
$menu = '<a href="/gazeta" style="color: white;">Газета</a> | <a href="/gazeta/section/'.$section['id'].'" style="color: white;">'.$Filter->output($section['name']).'</a> | <a href="/gazeta/article/'.$article['id'].'" style="color: white;">'.$Filter->output($article['name']).'</a> | Комментарии';
$where = 'gazeta';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if(isset($_POST['add'])){
	$_POST['comm'] = $Filter->input($_POST['comm']);
	if(empty($_POST['comm'])){
		error('Введите текст комментария');
	}elseif(mb_strlen($_POST['comm'])>16000){
		erorr('Длинна комментария не должна быть больше 16000 символов');
	}
	$db->query("INSERT INTO `gazeta_comm` SET `id_article`=".$article['id'].", `id_us`=".$user['id'].", `text`='".$_POST['comm']."', `time`=".time()."");
	header('location:/gazeta/comm/'.$article['id']);
}
?>
<div class="list1">
	<form action="" method="POST">
		Ваш комментарий:<br>
		<textarea name="comm"></textarea><br>
		<input type="submit" name="add" value="Добавить">
	</form>
</div>
<?
$Pagination = new Pagination("SELECT * FROM `gazeta_comm` WHERE `id_article`=".$article['id']."", $_GET['page']);
$query = $db->query("SELECT * FROM `gazeta_comm` WHERE `id_article`=".$article['id']." ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end);
while ($comm = $query->fetch_assoc()) {
	?>
	<div class="lst">
		<?=nick($comm['id_us'])?> [<small><?=datef($comm['time'])?></small>] <?if($user['admin']>=1){?>[<a href="/gazeta/admin/del_comm/<?=$comm['id']?>">x</a>] [<a href="/gazeta/admin/edit_comm/<?=$comm['id']?>">ред</a>]<?}?><br>
		<?=$Filter->outputText($comm['text'])?>
	</div>
	<?
}
$Pagination->out('gazeta/comm/'.$article['id']);
if($query->num_rows==0){
	?>
	<div class="lst">
		Комментариев пока что нет, станьте первым!
	</div>
	<?
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>