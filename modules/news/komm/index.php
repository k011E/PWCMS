<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Комментарии к новости';
$where = 'news';
include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
$_GET['id'] = abs(intval($_GET['id']));
$menu = 'Комментарии к новости ('.$db->query("SELECT `id` FROM `news_comm` WHERE `id_news`='".$_GET['id']."'")->num_rows.')';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$query = $db->query("SELECT * FROM `news` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0){
	error('Новости не существует.');
}
$news = $query->fetch_assoc();
?>
<div class="list1">
	Текст новости: <?=$Filter->output($news['content'])?><br>
	<?=nick($news['id_us'])?> (<?=datef($news['time'])?>)
</div>
<?
if(isset($_POST['add'])){
	$_POST['content'] = $Filter->clearString($_POST['content']);
	if(empty($_POST['content'])){
		errorNoExit('Введите комментарий');
	}else{
		$db->query("INSERT INTO `news_comm` SET `id_us`='".$user['id']."', `id_news`='".$_GET['id']."', `time`='".time()."', `content`='".$_POST['content']."'");
		header('location:/komm'.$_GET['id']);
	}
}
?>
<div class="list1">
	Комментарий:<br>
	<form action="" method="POST">
		<textarea name="content"></textarea><br>
		<input type="submit" name="add" value="Добавить">
	</form>
</div>
<?
$Pagination = new Pagination("SELECT * FROM `news_comm` WHERE `id_news`='".$_GET['id']."'", $_GET['page']);
$query = $db->query("SELECT * FROM `news_comm` WHERE `id_news`=".$_GET['id']." ORDER BY `id` DESC LIMIT $Pagination->start, $Pagination->end");
while ($comm = $query->fetch_assoc()) {
	?>
	<div class="list1">
		<?=nick($comm['id_us'])?> (<?=datef($comm['time'])?>) <?if($user['admin']>=1){?>[<a href="/komm<?=$_GET['id']?>/edit/<?=$comm['id']?>">ред</a>] [<a href="/komm<?=$_GET['id']?>/delete/<?=$comm['id']?>">x</a>]<?}?><br>
		<?=$Filter->outputText($comm['content'])?>
	</div>
	<?
}
if($db->query("SELECT `id` FROM `news_comm` WHERE `id_news`='".$_GET['id']."'")->num_rows==0){
	?>
	<div class="list1">Комментариев пока нет</div>
	<?
}else{
	$Pagination->out('/komm'.$_GET['id']);
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>