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
$query = $db->query("SELECT * FROM `forum_t` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0){
	header('location:/forum/thema'.$_GET['id']);
}
$thema = $query->fetch_assoc();
$title = 'Перенос темы "'.$Filter->output($thema['name']).'"';
$menu = $title;
$where = 'forum';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
admin(1);
if($thema['type']==1 AND $user['admin']<3){
	error('Тема удалена!');
}
if(isset($_POST['replace'])){
	$_POST['razd'] = abs(intval($_POST['razd']));
	if(empty($_POST['razd'])){
		error('Вы не выбрали подраздел!');
	}elseif($db->query("SELECT `id` FROM `forum_pr` WHERE `id`='".$_POST['razd']."'")->num_rows==0){
		error('Данного подраздела не существует!');
	}
	$oldpr = $db->query("SELECT * FROM `forum_pr` WHERE `id`='".$thema['id_pr']."'")->fetch_assoc();
	$newpr = $db->query("SELECT * FROM `forum_pr` WHERE `id`='".$_POST['razd']."'")->fetch_assoc();
	$newname = $thema['name'].' (перенесено)';
	$db->query("UPDATE `forum_t` SET `id_r`='".$newpr['r']."', `id_pr`='".$newpr['id']."', `name`='".$newname."', `last`='".time()."' WHERE `id`='".$_GET['id']."'");
	$db->query("UPDATE `forum_p` SET `id_r`='".$newpr['r']."', `id_pr`='".$newpr['id']."' WHERE `thema_id`='".$_GET['id']."'");
	$tex = '[b]Тему перен' . ($user['sex'] == 'Муж' ? 'ёс' : 'есла') . ' из подраздела ' . $oldpr['name'] . ' в подраздел ' . $newpr['name'] . '!:-)[/b]';
	$db->query("INSERT INTO `forum_p` SET `id_r`='".$newpr['r']."', `id_pr`='".$newpr['id']."', `msg`='".$tex."', `type`=0, `id_us`='".$user['id']."', `time`='".time()."', `id_thema`='".$_GET['id']."'");
	header('location:/forum/thema'.$thema['id']);

}
?>
<div class="list1">
	<form action="" method="POST">
		<select size="1" name="razd">
			<?
			$razds = $db->query("SELECT * FROM `forum_pr` ORDER BY `id` DESC");
			while ($pr = $razds->fetch_assoc()) {
				$r = $db->query("SELECT * FROM `forum_r` WHERE `id`='".$pr['r']."'")->fetch_assoc();
				?>
				<option value="<?=$pr['id']?>">
					<?=$Filter->output($pr['name'])?> (<?=$Filter->output($r['name'])?>)
				</option>
				<?
			}
			?>
		</select><br>
		<input type="submit" name="replace" value="Перенести">
		<input type="submit" value="Назад" onClick="history.go(-1);">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>