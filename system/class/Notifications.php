<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
/**
* Notifications class
//////ID = Sections//////
1 - Forum
2 - Reputation

*/
class Notifications
{

	/*
	* Возвращает количество всех оповещений пользователя
	*/
	function getAllNotificationCount($userId){
		global $db;
		return $db->query("SELECT `id` FROM `notifications` WHERE `id_us`=".$userId."")->num_rows;
	}

	/*
	* Возвращает количество всех непрочитанных оповещений пользователя
	*/
	function getNotReadAllNotificationCount($userId){
		global $db;
		return $db->query("SELECT `id` FROM `notifications` WHERE `id_us`=".$userId." AND `read`=0")->num_rows;
	}

	/*
	* Вовзращает количество всех оповещений пользователя в конкретном разделе
	*/
	function getSectionNotificationCount($userId, $idSection){
		global $db;
		return $db->query("SELECT `id` FROM `notifications` WHERE `id_us`=".$userId." AND `section`=".$idSection."")->num_rows;
	}

	/*
	* Возваращает количество всех непрочитанных оповещений пользователя в конкретном разделе
	*/
	function getSectionNotReadNotificationCount($userId, $idSection){
		global $db;
		return $db->query("SELECT `id` FROM `notifications` WHERE `id_us`=".$userId." AND `section`=".$idSection." AND `read`=0")->num_rows;
	}

	/*
	* Выводит иконку раздела
	*/
	function viewImgSection($idSection){
		global $db, $Filter;
		$section = $db->query("SELECT `img` FROM `notifications_sections` WHERE `id`=".$idSection."")->fetch_assoc();
		echo '<img src="/files/notifications/'.$Filter->output($section['img']).'" alt="*" align="middle">';
	}

	function getNameSection($idSection){
		global $db, $Filter;
		$section = $db->query("SELECT `name` FROM `notifications_sections` WHERE `id`=".$idSection."")->fetch_assoc();
		return $Filter->output($section['name']);
	}

	function section($idSection){
		global $user, $db, $Filter;
		$section = $db->query("SELECT * FROM `notifications_sections` WHERE `id`=".$idSection."")->fetch_assoc();
		?>
		<div class="list1" style="display:block; font-size:14px;">
			<a href="/notificationsh/section/<?=$idSection?>">
				<?=$this->viewImgSection($idSection)?> <?=$Filter->output($section['name'])?> (<?=$this->getSectionNotificationCount($user['id'], $idSection)?><?if($this->getSectionNotReadNotificationCount($user['id'], $idSection)!=0){?>/<font color="red">+<?=$this->getSectionNotReadNotificationCount($user['id'], $idSection)?></font><?}?>)
			</a>
		</div>
		<?
	}

	function viewImgNotification($id){
		global $db;
		$notification = $db->query("SELECT `read` FROM `notifications` WHERE `id`=".$id."")->fetch_assoc();
		if($notification['read']==0){
			echo '<img src="/design/images/new.png" alt="*" align="middle">';
		}else{
			echo '<img src="/design/images/old.png" alt="*" align="middle">';
		}
	}

	function getTextNotification($id){
		global $db, $Filter;
		$notification = $db->query("SELECT `text` FROM `notifications` WHERE `id`=".$id."")->fetch_assoc();
		return $Filter->outputText($notification['text']);
	}

	function getDateNotification($id){
		global $db;
		$notification = $db->query("SELECT `time` FROM `notifications` WHERE `id`=".$id."")->fetch_assoc();
		return datef($notification['time']);
	}

	function notification($id){
		?>
		<div class="lst">
			<?=$this->viewImgNotification($id)?> <?=$this->getTextNotification($id)?> (<?=$this->getDateNotification($id)?>)
		</div>
		<?
	}
}
?>