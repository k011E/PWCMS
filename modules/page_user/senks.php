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
$query = $db->query("SELECT `id`, `nick` FROM `users` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	header('location:/');
}
$us = $query->fetch_assoc();
$title = 'Поблагодарили '.$Filter->output($us['nick']);
$menu = nick($us['id']).' поблагодарили '.$db->query("SELECT `id` FROM `senks` WHERE `id_us`=".$us['id']."")->num_rows.' раз';
$where = 'senks';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$t = time()-604800;
?>
<div class="list1">
	Поблагодарили
	|
	<a href="/senker<?=$us['id']?>">Поблагодарил</a>
</div>
<?
if($db->query("SELECT `id` FROM `senks` WHERE `id_us`=".$us['id']." AND `id_sender`=".$user['id']." AND `time`>".$t."")->num_rows==0 AND $user['id']!=$us['id']){
	if(isset($_POST['ok'])){
		$_POST['senk'] = $Filter->input($_POST['senk']);
		if(empty($_POST['senk'])){
			error('Введите текст благодарности');
		}
		$db->query("INSERT INTO `senks` SET `id_us`=".$us['id'].", `id_sender`=".$user['id'].", `text`='".$_POST['senk']."', `time`=".time()."");
		$db->query("INSERT INTO `notifications` SET `id_us`=".$us['id'].", `text`='us{".$user['id']."} [url=/senks".$us['id']."]поблагодарил[/url] Вас!', `time`=".time().", `section`=2");
		$db->query("UPDATE `users` SET `rating`=`rating`+'0.01' WHERE `id`=".$us['id']."");
		header('location:/senks'.$us['id']);
	}
		?>
		<div class="list1">
			<form action="" method="POST">
				За что:<br>
				<textarea name="senk"></textarea>
				<br>
				<input type="submit" name="ok" value="Поблагодарить">
			</form>
		</div>
		<hr>
		<?
}

$Pagination = new Pagination("SELECT * FROM `senks` WHERE `id_us`=".$us['id']."", $_GET['page']);
$query = $db->query("SELECT * FROM `senks` WHERE `id_us`=".$us['id']." ORDER BY `id` DESC LIMIT $Pagination->start, $Pagination->end");
while ($senk = $query->fetch_assoc()) {
	?>
	<div class="lst">
		Кто: <?=nick($senk['id_sender'])?> (<?=datef($senk['time'])?>)<br>
		За что: <b><?=$Filter->outputText($senk['text'])?></b> <?if($user['admin']>=3){?>[<a href="/del_senk<?=$senk['id']?>">x</a>]<?}?>
	</div>
	<?
}
$Pagination->out('/senks'.$us['id']);
if($query->num_rows==0){
	?>
	<div class="list1">
		Нет благодарностей!
	</div>
	<?
}
?>
<div class="list1">
	<a href="/us<?=$us['id']?>">В анкету <?=$Filter->output($us['nick'])?></a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>