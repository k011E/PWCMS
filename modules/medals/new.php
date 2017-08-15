<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/extensions.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/functions.php');
$_GET['id'] = abs(intval($_GET['id']));
if($db->query("SELECT `id` FROM `users` WHERE `id`='".$_GET['id']."'")->num_rows==0){
	header('location:/');
}
$us = $db->query("SELECT * FROM `users` WHERE `id`='".$_GET['id']."'")->fetch_assoc();
$title = 'Вручение награды '.$Filter->output($us['nick']);
$where = 'page_user';
$menu = 'Вручение награды '.nick($us['id']);
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(3);
if(isset($_POST['award'])){
	$_POST['for_what'] = $Filter->input($_POST['for_what']);
	$_POST['medal'] = $Filter->input($_POST['medal']);
	if(empty($_POST['for_what'])){
		errorNoExit('Введите причину.');
	}else{
		$db->query("INSERT INTO `medals` SET `id_us`='".$us['id']."', `id_adm`='".$user['id']."', `time`='".time()."', `for_what`='".$_POST['for_what']."', `medal`='".$_POST['medal']."'");
		header('location:/medals/'.$us['id']);
	}
}
?>
<div class="list1">
	<form action="" method="POST">
		За что:<br>
		<textarea name="for_what"></textarea><br>
		Медаль:<br>
		<input type="radio" name="medal" value="award_star_gold_2"><img src="/design/images/medals/award_star_gold_2.png" alt="*"><br>
		<input type="radio" name="medal" value="award_star_gold_3"><img src="/design/images/medals/award_star_gold_3.png" alt="*"><br>
		<input type="radio" name="medal" value="gold_medal"><img src="/design/images/medals/gold_medal.png" alt="*"><br>
		<input type="radio" name="medal" value="medal_bronze_1"><img src="/design/images/medals/medal_bronze_1.png" alt="*"><br>
		<input type="radio" name="medal" value="medal_bronze_3"><img src="/design/images/medals/medal_bronze_3.png" alt="*"><br>
		<input type="radio" name="medal" value="medal_gold_1"><img src="/design/images/medals/medal_gold_1.png" alt="*"><br>
		<input type="radio" name="medal" value="medal_gold_3"><img src="/design/images/medals/medal_gold_3.png" alt="*"><br>
		<input type="radio" name="medal" value="medal_red"><img src="/design/images/medals/medal_red.png" alt="*"><br>
		<input type="radio" name="medal" value="medal_silver_2"><img src="/design/images/medals/medal_silver_2.png" alt="*"><br>
		<input type="radio" name="medal" value="medal_silver_3"><img src="/design/images/medals/medal_silver_3.png" alt="*"><br>
		<input type="submit" name="award" value="Наградить">
	</form>
</div>
<div class="navg">
	<a href="/medals/<?=$_GET['id']?>">Обратно</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>