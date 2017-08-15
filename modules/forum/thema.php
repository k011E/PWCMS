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
$query = $db->query("SELECT * FROM `forum_t` WHERE `id`='".$_GET['id']."'");
$thema = $query->fetch_assoc();
if($query->num_rows==0 or $thema['type']==1 AND $user['admin']<3){
	$title = 'Ошибочка!';
	$err = 'Данная тема была удалена!';
	$menu = '<a href="/forum" style="text-decoration:none; color:white;">Форум</a>';
}else{
	$r = $db->query("SELECT * FROM `forum_r` WHERE `id`='".$thema['id_r']."'")->fetch_assoc();
	$pr = $db->query("SELECT * FROM `forum_pr` WHERE `id`='".$thema['id_pr']."'")->fetch_assoc();
	$title = $Filter->output($thema['name']);
	$menu = '<a href="/forum/" style="text-decoration:none; color:white;">Форум</a> | <a href="/forum/razd'.$r['id'].'" style="text-decoration:none; color:white;">'.$Filter->output($r['name']).'</a> | <a href="/forum/'.$r['id'].'/'.$pr['id'].'" style="text-decoration:none; color:white;">'.$Filter->output($pr['name']).'</a> | '.$Filter->output($thema['name']);
}
$where = 'forum';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
$Forum = new Forum($_GET['id']);
if(isset($err)){
	error($err);
}
mode('user');
$Forum->updateInThema($thema['id']);
?>
<div class="list1">
	<font size="1">
		<a href="/forum/thema<?=$thema['id']?>">Обновить</a> |
		<?if($db->query("SELECT `id` FROM `forum_podp` WHERE `id_us`='".$user['id']."' AND `id_thema`='".$thema['id']."'")->num_rows==0){
			?>
			<a href="/forum/thema<?=$thema['id']?>/subscribe">Подписаться</a> |
			<?
		}else{?>
			<a href="/forum/thema<?=$thema['id']?>/subscribe">Отписаться</a> |
		<?}?>
		<?
		if($thema['type']!=3 AND $user['admin']>=1){
			?>
			<a href="/forum/thema<?=$thema['id']?>/close">Закрыть</a> |
			<?
		}

		if($user['admin']>=1){
			if($thema['type']>=3){
				?>
				<a href="/forum/thema<?=$thema['id']?>/unclose">Открыть</a> |
				<?
			}else{
				if($thema['type']!=1){?>
					<a href="/forum/thema<?=$thema['id']?>/del">Удалить</a> |
				<?}?>
				<a href="/forum/thema<?=$thema['id']?>/rename">Переименовать</a> |
				<?
			}
			?>
			<a href="/forum/thema<?=$thema['id']?>/replace">Перенести</a> |
			<?
		}
		if($user['admin']>=3){
			if($thema['type']==1){
				?>
				<a href="/forum/thema<?=$thema['id']?>/undelete">Восстановить</a> |
				<a href="/forum/thema<?=$thema['id']?>/undelete?nu">Восстановить без апа</a> |
				<?
			}

			if($thema['type']==2 or $thema['type']>=3){
				?>
				<a href="/forum/thema<?=$thema['id']?>/zakr">Закрепить</a>
				<?
			}elseif($thema['type']==0){
				?>
				<a href="/forum/thema<?=$thema['id']?>/otkr">Открепить</a>
				<?
			}
		}
		?>
	</font>
</div>
<?
if($thema['type']==1){
	?>
	<div class="post2"><img src="/design/images/deleted.png" alt="*" align="middle"> <b>Тема удалена!</b></div>
	<?
}elseif($thema['type']==3){
	?>
	<div class="post2"><img src="/design/images/closed.png" alt="*" align="middle"> <b>Тема закрыта!</b></div>
	<?
}

$Pagination = new Pagination("SELECT * FROM `forum_p` WHERE `id_thema`='".$thema['id']."' ", $_GET['page']);
$query = $db->query("SELECT * FROM `forum_p` WHERE `id_thema`='".$thema['id']."' AND `type`=0 ORDER BY `id` LIMIT ".$Pagination->start.", ".$Pagination->end."");
if($user['admin']>=3){
	$query = $db->query("SELECT * FROM `forum_p` WHERE `id_thema`='".$thema['id']."' ORDER BY `id` LIMIT ".$Pagination->start.", ".$Pagination->end."");
}
$i = 1;
if(!empty($_GET['page']) AND $_GET['page']>1)
	$i = $_GET['page']*10-9;
while ($p = $query->fetch_assoc()) {
	?>
	<div class="lst">
		<?=$i?>. <?=nick($p['id_us'])?> <?if($thema['id_author']==$p['id_us']){?><b><font color="green">[автор]</font></b><?}?> (<?=datef($p['time'])?>)
		<?if(($p['id_us']==$user['id'] OR $user['admin']>=1) AND ($thema['type']!=3 AND $thema['type']!=4)){?>
			[<a href="/forum/redk<?=$p['id']?>">ред</a>]
		<?}?>
		<?if($user['id']!=$p['id_us']){?>
			[<a href="/forum/thema<?=$thema['id']?>=otv_i<?=$p['id_us']?>">отв</a>]
			[<a href="/forum/thema<?=$thema['id']?>=cit<?=$p['id']?>">цит</a>]
			[<a href="/msg<?=$p['id_us']?>">лс</a>]
		<?}?>
		[<a href="/form2/pos.php?id=<?=$thema['id']?>&poslike=<?=$p['id']?>">под</a>]
		<?if($user['admin']>=1 AND $p['type']==0){?>
			[<a href="/forum/del_post/<?=$p['id']?>/<?=$_GET['page']?>">x</a>]
			[<a href="/forum/bn<?=$p['id']?>/page<?=$_GET['page']?>">нар</a>]
		<?}?>
		<?if($user['id']!=$p['id_us']){?>
			[<a href="/forum/jal<?=$post['id']?>/page<?=$_GET['page']?>">жал</a>]
		<?}?>
		<?if($Forum->checkSuccessVote($p['id'])){?>
			(<a href="/forum/edit_rating_post/<?=$p['id']?>/plus">+</a> | <a href="/forum/edit_rating_post/<?=$p['id']?>/minus">-</a>)
		<?}?>
		(<?=$Forum->msgPlus($p['id'])?>/<?=$Forum->msgMinus($p['id'])?>)
		<br>
		<?if($p['cit']!=0){
			$p_cit = $db->query("SELECT * FROM `forum_p` WHERE `id`=".$p['cit']."")->fetch_assoc();
			$u_cit = $db->query("SELECT `id`, `nick` FROM `users` WHERE `id`=".$p_cit['id_us']."")->fetch_assoc();
			?>
			Цитата:<br>
			<div class="cit">
				<b><font color="red"><?=$Filter->output($u_cit['nick'])?></font></b>: <?=$Filter->output($p_cit['msg'])?>
			</div>
			<?
		}
		?>
		<?=$Filter->outputText($p['msg'])?>
		<?if($user['admin']>=3 AND $p['type']==1){?><br><font color="red"><b>пост удалил <?=nick($p['del_us'])?></b></font>[<a href="/forum/recovery_post/<?=$p['id']?>/<?=$_GET['page']?>">вос</a>]<br><?}?>
		<?if($p['rec_us']>=1 AND $user['admin']>=3){?>
			<br><font color="green"><b>пост восстановил <?=nick($p['rec_us'])?></b></font>
		<?}?>
		<?if($db->query("SELECT `id` FROM `forum_edit_p` WHERE `id_post`=".$p['id']."")->num_rows!=0){
			$ep = $db->query("SELECT * FROM `forum_edit_p` WHERE `id_post`=".$p['id']." ORDER BY `id` DESC LIMIT 0, 1")->fetch_assoc();?>
			<br>
			<i>
				<small>
					Изменено <a href="/forum/red_p/<?=$p['id']?>"><?=$db->query("SELECT `id` FROM `forum_edit_p` WHERE `id_post`=".$p['id']."")->num_rows?> раз</a>. Посл. ред. <?=nick($ep['id_us'])?> (<?=datef($ep['time'])?>)
				</small>
			</i>
		<?}?>
	</div>
	<?
	$i++;
}
if($thema['type']!=1 AND $thema['type']!=3){
	if(isset($_POST['add'])){
		$_POST['content'] = $Filter->input($_POST['content']);
		if(empty($_POST['content'])){
			error('Введите сообщение!');
		}elseif(!isset($user['id'])){
			error('Посты могут оставлять только авторизованные пользователи');
		}
	}
	?>
	<div class="list1">
		<form action="/modules/forum/add_post.php?id=<?=$thema['id']?>&otv" method="POST" style="margin: 0;">
			Сообщение:<br>
			<textarea name="content"></textarea><br>
			<input type="submit" name="add" value="Написать">
			<input type="submit" value="Назад" onclick="history.go(-1)">
		</form>
	</div>
	<?
}
$Pagination->out('/forum/thema'.$thema['id']);
?>
<div class="list1">
	В теме: <a href="/forum/in_t_now/<?=$thema['id']?>"><?=$Forum->inThemaNowCount($thema['id'])?> человек</a>, <a href="/forum/in_t/<?=$thema['id']?>"><?=$Forum->inThemaCount($thema['id'])?></a> заходили<br>
	<img src="/design/images/download.png" alt="*" align="middle"> <a href="/forum/download_t/<?=$thema['id']?>">Скачать тему</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>