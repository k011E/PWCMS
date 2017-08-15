<?
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/extensions.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/functions.php');
$Filter = new Filter;
?>
	<title><?=$title?></title>
	<meta charset="utf-8">
	<meta name="Wap-мастераская">
	<meta name="description" content="Помощь wap-мастерам">
	<meta name="keywords" content="WAP-мастер,скрипты,шаблоны,магазин скриптов,форум,вап мастер">
	<meta name="author" content="KekuS">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="/design/css/med/style.css">
	<link rel="stylesheet" type="text/css" href="/design/css/ef.css">
	<link rel="shortcut icon" href="/design/images/favicon.ico" type="image/x-icon">
	<style type="text/css">
		a.button1 {
			display: inline-block;
			font-family: arial,sans-serif;
			font-size: 11px;
			font-weight: bold;
			color: rgb(68,68,68);
			text-decoration: none;
			user-select: none;
			padding: .2em 1.2em;
			outline: none;
			border: 1px solid rgba(0,0,0,.1);
			border-radius: 2px;
			background: rgb(245,245,245) linear-gradient(#f4f4f4, #f1f1f1);
			transition: all .218s ease 0s;
		}
		a.button1:hover {
			color: rgb(24,24,24);
			border: 1px solid rgb(198,198,198);
			background: #f7f7f7 linear-gradient(#f7f7f7, #f1f1f1);
			box-shadow: 0 1px 2px rgba(0,0,0,.1);
		}
		a.button1:active {
			color: rgb(51,51,51);
			border: 1px solid rgb(204,204,204);
			background: rgb(238,238,238) linear-gradient(rgb(238,238,238), rgb(224,224,224));
			box-shadow: 0 1px 2px rgba(0,0,0,.1) inset;
		}

	</style>
</head>
<body>
	<?if(isset($menu)){?>
		<div class="menu">
			<?=$menu?>
		</div>
	<?}?>
	<?if(isset($user['id'])){
		$Notifications = new Notifications;
		if($UserSettings->getUpPanel()==1){
		?>

		<div class="razd1">
			<img src="/design/images/r.png" class="ico" alt="*"> <a href="/kab/money.php?f=usl&rekl">Купить рекламу</a>
		</div>
		<div class="rega" style="border-bottom:none;">
			<table style="width:100%" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td style="vertical-align:top;width:10%;">
							<center> 
								<a href="/kab" title="Кабинет">
									<img class="ico" align="middle" src="/design/images/vcard.png" alt="*">
								</a>
							</center>
						</td>
						<td style="vertical-align:top;width:10%;">
							<center>
								<a href="/mail" title="Почта">
									<img class="ico" align="middle" src="/design/images/mail2.png" alt="*">
									<?if($db->query("SELECT `id` FROM `mail_messages` WHERE `id_us`=".$user['id']." AND `read`=0")->num_rows!=0){
										echo $db->query("SELECT `id` FROM `mail_messages` WHERE `id_us`=".$user['id']." AND `read`=0")->num_rows;
									}?>
								</a>
							</center>
						</td>
						<td style="vertical-align:top;width:10%;">
							<center>
								<a href="/notifications<?if($UserSettings->getNormalNotifications()==0){?>h<?}?>" title="Оповещения">
									<img class="ico" align="middle" src="/design/images/warning.png" alt="*">
									<?if($Notifications->getNotReadAllNotificationCount($user['id'])!=0){
									echo $Notifications->getNotReadAllNotificationCount($user['id']);}?>
								</a>
							</center>
						</td>
						<td style="vertical-align:top;width:10%;">
							<center>
								<a href="/feeds.php" title="Новости">
									<img class="ico" align="middle" src="/design/images/rss2.png" alt="*">
								</a>
							</center>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<?}else{?>
			<?if($Notifications->getNotReadAllNotificationCount($user['id'])!=0){?>
				<a href="/notifications<?if($UserSettings->getNormalNotifications()==0){?>h<?}?>">Оповещения</a> +<?=$Notifications->getNotReadAllNotificationCount($user['id'])?>
			<?}?>
		<?}?>
	<?}?>