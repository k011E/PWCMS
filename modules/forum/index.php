<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Форум';
$menu = '<a href="/" style="text-decoration:none; color:white;">Главная</a> | Форум';
$where = 'forum';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
$time = time()-86400;
mode('user');
?>
<div class="list1">
	<img src="/design/images/tema.png" alt="*" align="middle">
	Темы: <a href="/forum/thems/my">Мои</a> <small>|</small> <a href="/forum/thems/new">Новые</a> <small>|</small> <a href="/forum/thems/empty">Пустые</a> <small>|</small> <a href="/forum/thems/updating">Обновлённые</a><br>
	<img src="/design/images/npost.png" align="middle" alt="*">
	Посты: <a href="/posts<?=$user['id']?>">Мои</a> <small>|</small> <a href="/forum/posts/new">Новые</a><br>
	<img src="/design/images/rating.png" alt="*" align="middle">
	Активисты за <a href="/forum/activists/24h">24ч</a> / <a href="/forum/activists/7d">7с</a> / <a href="/forum/activists/over">общ</a><br>
	<img src="/design/images/book3.png" alt="*" align="middle">
	<a href="/kab/pth.php">Наблюдаемые</a>
</div>
<?
$query = $db->query("SELECT * FROM `forum_r`");
if($query->num_rows==0){
	?>
	<div class="lst">
		Разделов ещё нет
	</div>
	<?
}
while ($r = $query->fetch_assoc()) {
	$nt = $db->query("SELECT `id` FROM `forum_t` WHERE `id_r`=".$r['id']." AND `time`>".$time."")->num_rows;
	$np = $db->query("SELECT `id` FROM `forum_p` WHERE `id_r`=".$r['id']." AND `time`>".$time."")->num_rows;
	?>
	<div class="menu2">
		<img src="/design/images/inet.png" alt="*" align="middle">
		<a href="/forum/razd<?=$r['id']?>" style="text-decoration:none; color:white;"><b><?=$Filter->output($r['name'])?></b> (<?=$db->query("SELECT `id` FROM `forum_t` WHERE `id_r`=".$r['id']."")->num_rows?>/<?=$db->query("SELECT `id` FROM `forum_p` WHERE `id_r`=".$r['id']."")->num_rows?>) <?if($nt!=0){?>|<font color="red">+<?=$nt?></font>|<?}?> <?if($nt==0 AND $np!=0){?>|<?}?> <?if($np!=0){?><font color="green">+<?=$np?></font>|<?}?></a>
	</div>
	<div class="navg">
		<?
		$query1 = $db->query("SELECT * FROM `forum_pr` WHERE `r`='".$r['id']."'");
		while ($pr = $query1->fetch_assoc()) {
			?>
			<img src="/design/images/categ.png" alt="*" align="middle">
			<a href="/forum/<?=$r['id']?>/<?=$pr['id']?>"><?=$Filter->output($pr['name'])?></a> (<?=$db->query("SELECT `id` FROM `forum_t` WHERE `id_pr`=".$pr['id']."")->num_rows?>/<?=$db->query("SELECT `id` FROM `forum_p` WHERE `id_pr`=".$pr['id']."")->num_rows?>) <br>
			<?
		}
		if($query1->num_rows==0){
			?>
			<div class="lst">Подразделов ещё нет</div>
			<?
		}
		if($db->query("SELECT `id` FROM `forum_t` WHERE `id_r`=".$r['id']."")->num_rows!=0){
			$lstt = $db->query("SELECT * FROM `forum_t` WHERE `id_r`=".$r['id']." ORDER BY `id` DESC LIMIT 0, 1")->fetch_assoc();
			$lstpr = $db->query("SELECT * FROM `forum_pr` WHERE `id`=".$lstt['id_pr']."")->fetch_assoc();
			$lstp = $db->query("SELECT * FROM `forum_p` WHERE `id_thema`=".$lstt['id']." ORDER BY `id` DESC LIMIT 0, 1")->fetch_assoc();
			$tl = $db->query("SELECT `id` FROM `forum_p` WHERE `id_thema`=".$lstt['id']."")->num_rows;
			$t1 = $tl/10;
			$t2 = abs(intval($tl/10));
			if($t1>$t2){
				$pg = $t2+1;
			}else{
				$pg = $t1;
			}
			?>
			<small>
				<div class="list1">
					Подраздел: <a href="/forum/<?=$r['id']?>/<?=$lstpr['id']?>"><?=$Filter->output($lstpr['name'])?></a><br>
					<?=imgT($lstt['id'])?> <a href="/forum/thema<?=$lstt['id']?>"><?=$Filter->output($lstt['name'])?></a> (<?=$db->query("SELECT `id` FROM `forum_p` WHERE `id_thema`=".$lstt['id']."")->num_rows?>) <a href="/forum/thema<?=$lstt['id']?>/page<?=$pg?>">></a><br>
					<?=nick($lstt['id_author'])?>/<?=nick($lstp['id_us'])?> (<?=datef($lstp['time'])?>)
				</div>
			</small>
		<?}?>
	</div>
	<?
}

?>
<div class="menu2">
	<img src="/design/images/alll.png" alt="*" align="middle">
	<a href="/all/rulls.php" style="text-decoration:none; color:white;">Правила</a>
	|
	<img src="/design/images/emoc.png" alt="*" align="middle">
	<a href="/all/smiles_r.php" style="text-decoration:none; color:white;">Смайлы</a>
	|
	<img src="/design/images/cod.png" alt="*" align="middle">
	<a href="/all/bb.php" style="text-decoration: none; color: white;">ББ коды</a>
	|
	<img src="/design/images/usear.png" alt="*" align="middle">
	<a href="/forum/search" style="text-decoration: none; color: white;">Поиск</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>