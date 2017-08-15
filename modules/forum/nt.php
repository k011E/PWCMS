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
$_GET['idr'] = abs(intval($_GET['idr']));
$_GET['idpr'] = abs(intval($_GET['idpr']));
$query = $db->query("SELECT * FROM `forum_r` WHERE `id`='".$_GET['idr']."'");
if($query->num_rows==0){
	header('location:/forum');
}
$r = $query->fetch_assoc();
$query = $db->query("SELECT * FROM `forum_pr` WHERE `id`='".$_GET['idpr']."'");
if($query->num_rows==0){
	header('location:/forum');
}
$pr = $query->fetch_assoc();
$title = 'Подраздел '.$Filter->output($pr['name']);
$menu  = '<a href="/forum" style="text-decoration:none; color:white;">Форум</a> | <a href="/forum/razd'.$r['id'].'" style="text-decoration:none; color:white;">'.$Filter->output($r['name']).'</a> | '.$Filter->output($pr['name']);
$where = 'forum';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="menu2">
	<img src="/design/images/nt.png" alt="*" align="middle">
	<a href="/forum/<?=$r['id']?>/<?=$pr['id']?>/nt" style="text-decoration:none; color:white;">Новая тема</a>
</div>
<?
if(isset($_POST['add'])){
	$_POST['name'] = $Filter->input($_POST['name']);
	$_POST['content'] = $Filter->input($_POST['content']);
	if(mb_strlen($_POST['name'])<2 OR mb_strlen($_POST['name'])>80){
		errorNoExit('Недопустимая длина названия темы');
	}elseif (mb_strlen($_POST['content'])<3) {
		errorNoExit('Слишком короткая длина текста');
	}elseif($db->query("SELECT `id` FROM `forum_t` WHERE `name`='".$_POST['name']."' AND `id_pr`='".$pr['id']."' AND `id_author`='".$user['id']."'")->num_rows!=0){
		errorNoExit('Вы уже создавали подобную тему в этом подразделе');
	}elseif($db->query("SELECT `id` FROM `forum_t` WHERE `time`>".(time()-300)." AND `id_author`='".$user['id']."'")->num_rows!=0){
		errorNoExit('Антифлуд! Вы сможете создать новую тему через несколько минут');
	}else{
		$db->query("INSERT INTO `forum_t` SET `id_r`='".$r['id']."', `id_pr`='".$pr['id']."', `id_author`='".$user['id']."', `name`='".$_POST['name']."', `type`=2, `last`=".time().", `time`=".time()."");
		$last = $db->insert_id;
		if($_POST['subscribe']==1){
			$db->query("INSERT INTO `forum_podp` SET `id_us`='".$user['id']."', `id_thema`='".$last."'");
		}
		$db->query("INSERT INTO `forum_p` SET `id_r`='".$r['id']."', `id_pr`='".$pr['id']."', `msg`='".$_POST['content']."', `type`=0, `id_us`='".$user['id']."', `time`=".time().", `id_thema`=".$last."");
		header('location:/forum/thema'.$last);
	}
}
?>
<div class="list1">
	<form action="" method="POST">
		Тема:<br>
		<input type="text" name="name"><br>
		Текст:<br>
		<textarea name="content"></textarea><br>
		<input type="radio" name="subscribe" value="1"> Оповещать о оставленных сообщениях<br>
		Ознакомьтесь с <a href="/forum/rulls<?=$pr['id']?>">правилами</a> п.д!<br>
		<input type="submit" name="add" value="Добавить">
	</form>
</div>

<div class="menu2">
	<img src="/design/images/alll.png" alt="*" align="middle">
	Правила: <a href="/all/rulls" style="text-decoration:none; color:white;">сайта</a>/<a href="/forum/rulls<?=$pr['id']?>" style="text-decoration:none; color:white;">подраздела</a>
	|
	<img src="/design/images/emoc.png" alt="*" align="middle">
	<a href="/all/smiles_r.php" style="text-decoration:none; color:white;">Смайлы</a>
	|
	<img src="/design/images/cod.png" alt="*" align="middle">
	<a href="/all/bb.php" style="text-decoration: none; color: white;">ББ коды</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>