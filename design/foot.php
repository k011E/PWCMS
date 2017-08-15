<?
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
if($_SERVER["PHP_SELF"]!='/index.php'){
	?>
	<div class="navg">
		<img src="/design/images/homepage.gif" alt="home">
		<a href="/">На главную</a>
	</div>
	<?
}
?>
<div class="blk">
	<span style="color: #fff">
		Онлайн: <a href="/online.php"><?=$db->query("SELECT `id` FROM `users` WHERE `online`>".(time()-3600)."")->num_rows?></a> из <a href="/masters"><?=$db->query("SELECT `id` FROM `users`")->num_rows?></a>
	</span>
</div>