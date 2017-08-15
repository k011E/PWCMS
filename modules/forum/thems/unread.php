<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Непрочитанное';
$where = 'forum';
$menu = '<a href="/forum" style="color: white;">Форум</a> | Непрочитанное';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="menu2">
	Всего <?=$db->query("select count(id) as num from `forum_t` LEFT JOIN `forum_rdm` ON `forum_t`.`id` = `forum_rdm`.`t_id` AND `forum_rdm`.`user_id` = '" . $user['id'] . "' WHERE (`forum_rdm`.`t_id` Is Null OR `forum_t`.`last` > `forum_rdm`.`time`)")->num_rows?> непрочитанных тем
</div>
<?
$Pagination = $db->query("SELECT * FROM `forum_t` LEFT JOIN `forum_rdm` ON `forum_t`.`id` = `forum_rdm`.`t_id` AND `forum_rdm`.`user_id` = '" . $b['id'] . "' WHERE (`forum_rdm`.`t_id` Is Null OR `forum_t`.`last` > `forum_rdm`.`time`) ".($b['level']>=3?null:'and forum_t.`type`!=1')." ORDER BY `forum_t`.`last`");
$query = $db->query("SELECT * FROM `forum_t` LEFT JOIN `forum_rdm` ON `forum_t`.`id` = `forum_rdm`.`t_id` AND `forum_rdm`.`user_id` = '" . $user['id'] . "' WHERE (`forum_rdm`.`t_id` Is Null OR `forum_t`.`last` > `forum_rdm`.`time`) ORDER BY `forum_t`.`last` DESC LIMIT $Pagination->start, $Pagintaion->end");
while ($topic = $query->fetch_assoc()) {
	?>

	<?
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>