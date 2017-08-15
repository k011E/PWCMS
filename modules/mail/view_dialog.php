<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Почта';
$where = 'mail';
$menu = $title;
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$_GET['id'] = abs(intval($_GET['id']));
if($_GET['id'] == $user['id'] or $db->query("SELECT `id` FROM `users` WHERE `id`=".$_GET['id']."")->num_rows==0){
	header('location:/mail');
}

if(isset($_GET['file_upload'])){
	$UserSettings->setFilesMail();
	header('location:/mail/msg/'.$_GET['id']);
}

if($db->query("SELECT `id` FROM `mail_contacts` WHERE `id_us`=".$user['id']." AND `id_by`=".$_GET['id']."")->num_rows==0){
	$db->query("INSERT INTO `mail_contacts` SET `id_us`=".$user['id'].", `id_by`=".$_GET['id']."");
	?>
	<div class="list1">
		Контакт успешно добавлен...
	</div>
	<?
}

if($db->query("SELECT `id` FROM `mail_contacts` WHERE `id_us`=".$_GET['id']." AND `id_by`=".$user['id']."")->num_rows==0){
	$db->query("INSERT INTO `mail_contacts` SET `id_us`=".$_GET['id'].", `id_by`=".$user['id']."");
}
if(isset($_GET['ignor'])){
	if($db->query("SELECT `id` FROM `mail_ignor` WHERE `who`=".$user['id']." AND `whom`=".$_GET['id']."")->num_rows!=0){
		$db->query("DELETE FROM `mail_ignor` WHERE `who`=".$user['id']." AND `whom`=".$_GET['id']."");
		header('location:/mail/msg/'.$_GET['id']);
	}else{
		if($_GET['ignor']==yes){
			$db->query("INSERT INTO `mail_ignor` SET `who`=".$user['id'].", `whom`=".$_GET['id']."");
			?>
			<div class="lst">
				<?=nick($_GET['id'])?> добавлен в Ваш игнор-лист!
			</div>
			<?
		}elseif($_GET['ignor']==no){
			header('location:/mail/msg/'.$_GET['id']);
		}else{
			?>
			<div class="lst">
				 Вы уверены что хотите добавить <?=nick($_GET['id'])?> в игнор лист?<br>
				 <a href="?ignor=yes"><img src="/design/images/yes.png"></a> <a href="?ignor=no"><img src="/design/images/stop_2.png"></a>
			</div>
			<?
		}
	}
}
// Время онлайна пока что на 0, в связи с тем что система подсчёта времени проведенного пользователем на сайте работает не корректно
if($db->query("SELECT `id` FROM `forum_p` WHERE `id_us`=".$user['id']."")->num_rows<10 OR $user['time_online']<0){
	?>
	<div class="list1">
		Для того, чтобы писать личные сообщение Вы должны набрать 10 постов в форуме и провести на сайте 3 часа!
	</div>
	<?
}else{
	if(isset($_POST['ok'])){
		$_POST['text'] = $Filter->input($_POST['text']);
		if(empty($_POST['text'])){
			error('Введите текст сообщения...');
		}elseif(mb_strlen($_POST['text'])>16000){
			error('Максимальная длинна сообщения - 16000 символов');
		}elseif($db->query("SELECT `id` FROM `mail_ignor` WHERE `who`=".$_GET['id']." AND `whom`=".$user['id']."")->num_rows!=0){
			error("Вы находитесь в игнор-листе у ".nick($_GET['id']));
		}	
		$contact = $db->query("SELECT `id` FROM `mail_contacts` WHERE `id_us`=".$user['id']." AND `id_by`=".$_GET['id']."")->fetch_assoc();
		$db->query("INSERT INTO `mail_messages` SET `time`=".time().", `id_us`=".$_GET['id'].", `id_by`=".$user['id'].", `text`='".$_POST['text']."', `id_contact`=".$contact['id'].", `read`=0");
		$id = $db->insert_id;
		if(file_exists($_FILES['file']['tmp_name'])){
			$name = $_SERVER["HTTP_HOST"].'_'.rand(0, 1000).'_'.$user['id'].'_'.$_GET['id'].'_'.rand(0, 1000);
			$upfiletype = substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], ".") + 1);
			$Upload = new Upload('mail', $name, 0, 5, 'jpg,gif,png,jpeg,bmp,zip,rar,7z,txt,mp3,avi,mp4,3gp');
			$Upload->upload();
			$db->query("UPDATE `mail_messages` SET `file`='".$Filter->input($name).".".$upfiletype."' WHERE `id`=".$id."");
		}
		$db->query("UPDATE `mail_contacts` SET `last`=".time()." WHERE `id_us`=".$user['id']." AND `id_by`=".$_GET['id']."");
		$db->query("UPDATE `mail_contacts` SET `last`=".time()." WHERE `id_us`=".$_GET['id']." AND `id_by`=".$user['id']."");
		header('location:/mail/msg/'.$_GET['id']);
	}
	?>
	<div class="list1">
		<form action="" method="post" enctype="multipart/form-data">
			Сообщение: (<a href="/mail/msg/<?=$_GET['id']?>">обн</a>/игнор [<a href="?ignor"><?if($db->query("SELECT `id` FROM `mail_ignor` WHERE `who`=".$user['id']." AND `whom`=".$_GET['id']."")->num_rows==0){?>вкл<?}else{?>выкл<?}?></a>])<br>
			<textarea name="text"></textarea><br/>
			<?if($UserSettings->getFilesMail()!=0){
				?>
				Файл:<br/>
				<input type="file" name="file"><br/>
				<?
			}?>
			<input type="submit" value="Отправить" name="ok">
		</form>
	</div>
	<div class="rega">
		<a href="/mail/msg/<?=$_GET['id']?>?file_upload"><img src="/design/images/file_broken.png"></a>
		<?if($db->query("SELECT `id` FROM `mail_favorite` WHERE `id_who`=".$user['id']." AND `id_whom`=".$_GET['id']."")->num_rows==0){?>
			<a href="/mail/favorite/add/<?=$_GET['id']?>"><img src="/design/images/document_star.png"></a>
		<?}else{?>
			<a href="/mail/favorite/delete/<?=$_GET['id']?>"><img src="/design/images/remove.png" width="24" height="24"></a>
		<?}?>
		<a href="/mail/files/user/<?=$_GET['id']?>"><img src="/design/images/files3.png"></a>
	</div>
	<?
}
?>
<form action="/modules/mail/resend.php?id_us=<?=$user['id']?>&id_contact=<?=$_GET['id']?>" method="POST" style="margin: 0;">
	<?
	$Pagination = new Pagination("SELECT * FROM `mail_messages` WHERE `id_us`=".$user['id']." AND `id_by`=".$_GET['id']." OR `id_us`=".$_GET['id']." AND `id_by`=".$user['id']."", $_GET['page']);
	$query = $db->query("SELECT * FROM `mail_messages` WHERE `id_us`=".$user['id']." AND `id_by`=".$_GET['id']." OR `id_us`=".$_GET['id']." AND `id_by`=".$user['id']." ORDER BY `id` DESC LIMIT ".$Pagination->start.", ".$Pagination->end);
	while ($message = $query->fetch_assoc()) {
		?>
		<div class="lst">
		<input type="checkbox" name="resend[]" value="<?=$message['id']?>">
			<?=nick($message['id_by'])?> <?if($message['read']==0){?>[<font color="red"><b>Непрочитанное</b></font>]<?}?> [<?=datef($message['time'])?>]<br>
			<?=$Filter->outputText($message['text'])?>
			<?if(!empty($message['file'])){
				?>
					<br>
					Файл: <a href="/files/mail/<?=$Filter->output($message['file'])?>"><?=$Filter->output($message['file'])?></a> <?=round(filesize('../../files/mail/'.$message['file'])/1024).'Kb'?>
				<?
			}?>
		</div>
		<?
		$db->query("UPDATE `mail_messages` SET `read`=1 WHERE `id`=".$message['id']." AND `id_us`=".$user['id']."");
	}
	if($query->num_rows==0){
		?>
		<div class="lst">
			Сообщений нет...
		</div>
		<?
	}else{
		?>
		<div class="lst">
			Переслать ID:<br>
			<input type="text" name="from"><br>
			<input type="submit" name="resendd" value="Переслать выбранное">
		</div>
		<?
	}
	?>
</form>
<?
$Pagination->out('/mail/msg/'.$_GET['id']);
?>
<div class="lst">
	<a href="/mail">Все диалоги</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>