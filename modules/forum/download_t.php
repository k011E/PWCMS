<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Скачивание темы';
$where = 'forum';
$menu = $title;
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$_GET['id'] = abs(intval($_GET['id']));
$Forum = new Forum($_GET['id']);
if(!$Forum->checkThema($_GET['id'])){
	error('Темы не существует!');
}
$thema = $db->query("SELECT * FROM `forum_t` WHERE `id`=".$_GET['id']."")->fetch_assoc();
if($Forum->typeThema($_GET['id'])==1){
	error('Тема была удалена!');
}elseif($Forum->msgCount($_GET['id'])>350){
	error('Тема слишком объёмная для скачки!');
}
$text = 'Тема: '.$Forum->nameThema($_GET['id']).', создана '.datef($thema['time']).'

';
$query = $db->query("SELECT * FROM `forum_p` WHERE `id_thema`=".$_GET['id']." AND `type`!=1");
$i = 0;
while ($post = $query->fetch_assoc()) {
	$i++;
	$nick = $db->query("SELECT `nick` FROM `users` WHERE `id`=".$post['id_us']."")->fetch_assoc();
	$text = $text.$i.'. '.$nick['nick'].($post['id_us']==$thema['id_author']?' [автор]':NULL).' ('.datef($post['time']).')
	'.$post['msg'].'

	';
}
$filename = $_SERVER["DOCUMENT_ROOT"].'/files/themes/'.$_GET['id'].'.txt';
$file = fopen($filename, 'w');
fwrite($file, $text);
fclose($file);
if(file_exists($filename)){
	header('location:/files/themes/'.$_GET['id'].'.txt');
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>