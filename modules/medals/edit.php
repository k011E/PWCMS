<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Редактирование медали';
$menu = $title;
$where = 'page_user';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(3);
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT * FROM `medals` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0){
	error('Медали не существует.');
}
$medal = $query->fetch_assoc();
if(isset($_POST['edit'])){
	$_POST['for_what'] = $Filter->input($_POST['for_what']);
	$_POST['medal'] = $Filter->input($_POST['medal']);
	if(empty($_POST['for_what'])){
		error('Введите причину награждения');
	}
	$db->query("UPDATE `medals` SET `for_what`='".$_POST['for_what']."', `medal`='".$_POST['medal']."' WHERE `id`='".$_GET['id']."'");
	$medal = $db->query("SELECT * FROM `medals` WHERE `id`='".$_GET['id']."'")->fetch_assoc();
}
?>
<div class="list1">
	<form action="" method="POST">
		За что:<br>
		<textarea name="for_what"><?=$Filter->output($medal['for_what'])?></textarea><br>
		Медаль:<br>
		<input type="radio" name="medal" value="award_star_gold_2" <?if($medal['medal']=='award_star_gold_2'){?>checked<?}?>><img src="/design/images/medals/award_star_gold_2.png" alt="*"><br>
		<input type="radio" name="medal" value="award_star_gold_3" <?if($medal['medal']=='award_star_gold_3'){?>checked<?}?>><img src="/design/images/medals/award_star_gold_3.png" alt="*"><br>
		<input type="radio" name="medal" value="gold_medal" <?if($medal['medal']=='gold_medal'){?>checked<?}?>><img src="/design/images/medals/gold_medal.png" alt="*"><br>
		<input type="radio" name="medal" value="medal_bronze_1" <?if($medal['medal']=='medal_bronze_1'){?>checked<?}?>><img src="/design/images/medals/medal_bronze_1.png" alt="*"><br>
		<input type="radio" name="medal" value="medal_bronze_3" <?if($medal['medal']=='medal_bronze_3'){?>checked<?}?>><img src="/design/images/medals/medal_bronze_3.png" alt="*"><br>
		<input type="radio" name="medal" value="medal_gold_1" <?if($medal['medal']=='medal_gold_1'){?>checked<?}?>><img src="/design/images/medals/medal_gold_1.png" alt="*"><br>
		<input type="radio" name="medal" value="medal_gold_3" <?if($medal['medal']=='medal_gold_3'){?>checked<?}?>><img src="/design/images/medals/medal_gold_3.png" alt="*"><br>
		<input type="radio" name="medal" value="medal_red" <?if($medal['medal']=='medal_red'){?>checked<?}?>><img src="/design/images/medals/medal_red.png" alt="*"><br>
		<input type="radio" name="medal" value="medal_silver_2" <?if($medal['medal']=='medal_silver_2'){?>checked<?}?>><img src="/design/images/medals/medal_silver_2.png" alt="*"><br>
		<input type="radio" name="medal" value="medal_silver_3" <?if($medal['medal']=='medal_silver_3'){?>checked<?}?>><img src="/design/images/medals/medal_silver_3.png" alt="*"><br>
		<input type="submit" name="edit" value="Сохранить">
	</form>
</div>
<div class="navg">
	<a href="/medals/<?=$medal['id_us']?>">Обратно</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>