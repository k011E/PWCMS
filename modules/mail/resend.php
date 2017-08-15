<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Пересылка сообщений';
$menu = $title;
$where = 'mail';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
$_GET['id_us'] = abs(intval($_GET['id_us']));
$_GET['id_contact'] = abs(intval($_GET['id_contact']));
if(isset($_POST['resendd'])){
	$_POST['from'] = abs(intval($_POST['from']));
	if($db->query("SELECT `id` FROM `users` WHERE `id`=".$_POST['from']."")->num_rows==0){
		error('Пользователя не существует');
	}elseif($user['id'] == $_POST['from']){
		error('Самому себе пересылать сообщения запрещено');
	}elseif($db->query("SELECT `id` FROM `mail_contacts` WHERE `id_by`=".$user['id']." AND `id_us`=".$_POST['from']."")->num_rows==0){
		error('Диалога не существует');
	}elseif($db->query("SELECT `id` FROM `mail_ignor` WHERE `id_who`=".$_POST['from']." AND `id_whom`=".$user['id']."")->num_rows!=0){
		error('Вы находитесь в игнор-листе у данного пользователя');
	}elseif(empty($_POST['resend'])){
		error('Выберите сообщения для пересылки');
	}
	$id_cont = $db->query("SELECT `id` FROM `mail_contacts` WHERE `id_by`=".$user['id']." AND `id_us`=".$_POST['from']."")->fetch_assoc();
	$select_messages = $_POST['resend'];
	$text = '(';
	foreach ($select_messages as $value) {
		$text .= $value. ',';
	}
		$textq = substr($text, 0, -1) . ')';	
		$textq = str_replace('(', NULL, $textq);
		$textq = str_replace(')', NULL, $textq);
		$textq = explode(',', $textq);
		$textqq = '[cit]Переписка между us{'.$user['id'].'} и us{'.$_GET['id_contact'].'}. (снизу вверх)[/cit]';
		for($i = 0; $i < $UserSettings->getMaxP(); $i++){
			if(!empty($textq[$i])){
				$textq2 = 'post' . $i;
				$inf[$textq2] = $db->query("SELECT * FROM `mail_messages` WHERE `id`=".$textq[$i]."")->fetch_assoc();
				$textqq .= 'us{'.$inf[$textq2]['id_by'].'} ('.datef($inf[$textq2]['time']).'): [cit]'.$inf[$textq2]['text'].'[/cit]';
			}
		}
	$db->query("INSERT INTO `mail_messages` SET `time`=".time().", `id_us`=".$_POST['from'].", `id_by`=".$user['id'].", `text`='".$Filter->input($textqq)."', `id_contact`=".$id_cont['id']."");
	$db->query("UPDATE `mail_contacts` SET `last`=".time()." WHERE `id_by`=".$user['id']." AND `id_us`=".$_POST['from']."");
	$db->query("UPDATE `mail_contacts` SET `last`=".time()." WHERE `id_by`=".$_POST['from']." AND `id_us`=".$user['id']."");
	header('location:/mail/msg/'.$_POST['from']);
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>