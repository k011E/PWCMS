<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Разделы смайлов';
$menu = $title;
$where = 'kab';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$query = $db->query("SELECT * FROM `smiles_r`");
while ($r = $query->fetch_assoc()) {
	?>
	<div class="lst">
		» <a href="/all/smile/<?=$r['id']?>"><?=$Filter->output($r['name'])?></a> [<?=$db->query("SELECT `id` FROM `smiles` WHERE `r`='".$r['id']."'")->num_rows?>] 
	</div>
	<?
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>