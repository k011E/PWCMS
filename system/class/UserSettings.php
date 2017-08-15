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
* class UserSettings
/////Да-да-да я знаю что это наитупейший код, но я это понял слишком поздно/////
*/
class UserSettings
{
	private $settings;
	private $userid;

	function __construct($id)
	{
		global $user;
		global $db;
		$this->userid = abs(intval($id));
		$this->updateSettings($this->userid);
		if(!isset($user['id'])){
			$this->settings['max_p'] = 10;
			$this->settings['homet'] = 3;
			$this->settings['homef'] = 3;
			$this->settings['homec'] = 3;
		}
	}

	function updateSettings($id){
		global $db;
		return $this->settings = $db->query("SELECT * FROM `users_settings` WHERE `id_us`=".$id."")->fetch_assoc();
	}

	function getMaxP(){
		return $this->settings['max_p'];
	}

	function setMaxP($value){
		global $db, $Filter;
		$value = $Filter->input($value);
		if(empty($value)){
			error('Введите значение!');
		}elseif(!is_numeric($value)){
			error('Значение должно быть числом!');
		}elseif($value<=0){
			error('Значение должно быть больше нуля!');
		}
		$db->query("UPDATE `users_settings` SET `max_p`=".$value." WHERE `id_us`=".$this->userid."");
		$this->updateSettings($this->userid);
	}

	function setHome($thome, $fhome, $chome){
		$this->setHomeT($thome);
		$this->setHomeF($fhome);
		$this->setHomeC($chome);
	}

	function getHomeT(){
		return $this->settings['homet'];
	}

	function setHomeT($value){
		global $db, $Filter;
		$value = $Filter->input($value);
		if(empty($value)){
			error('Введите значение!');
		}elseif(!is_numeric($value)){
			error('Значение должно быть числом!');
		}elseif($value<=0){
			error('Значение должно быть больше нуля!');
		}
		$db->query("UPDATE `users_settings` SET `homet`=".$value." WHERE `id_us`=".$this->userid."");
		$this->updateSettings($this->userid);
	}

	function getTopHome(){
		return $this->settings['top_home'];
	}

	function setTopHome(){
		global $db;
		if($this->settings['top_home']==1){
			$db->query("UPDATE `users_settings` SET `top_home`=0 WHERE `id_us`=".$this->userid."");
		}else{
			$db->query("UPDATE `users_settings` SET `top_home`=1 WHERE `id_us`=".$this->userid."");
		}
		header('location:/kab/additional_settings');
	}

	function getCommHome(){
		return $this->settings['comm_home'];
	}

	function setCommHome(){
		global $db;
		if($this->settings['comm_home']==1){
			$db->query("UPDATE `users_settings` SET `comm_home`=0 WHERE `id_us`=".$this->userid."");
		}else{
			$db->query("UPDATE `users_settings` SET `comm_home`=1 WHERE `id_us`=".$this->userid."");
		}
		header('location:/kab/additional_settings');
	}

	function getHomeF(){
		return $this->settings['homef'];
	}

	function setHomeF($value){
		global $db, $Filter;
		$value = $Filter->input($value);
		if(empty($value)){
			error('Введите значение!');
		}elseif(!is_numeric($value)){
			error('Значение должно быть числом!');
		}elseif($value<=0){
			error('Значение должно быть больше нуля!');
		}
		$db->query("UPDATE `users_settings` SET `homef`='".$value."' WHERE `id_us`=".$this->userid."");
		$this->updateSettings($this->userid);
	}

	function getHomeC(){
		return $this->settings['homec'];	
	}

	function setHomeC($value){
		global $db, $Filter;
		$value = $Filter->input($value);
		if(empty($value)){
			error('Введите значение!');
		}elseif(!is_numeric($value)){
			error('Значение должно быть числом!');
		}elseif($value<=0){
			error('Значение должно быть больше нуля!');
		}
		$db->query("UPDATE `users_settings` SET `homec`='".$value."' WHERE `id_us`=".$this->userid."");
		$this->updateSettings($this->userid);
	}

	function getFilesForum(){
		return $this->settings['files_forum'];
	}

	function setFilesForum(){
		global $db;
		if($this->settings['files_forum']==1){
			$db->query("UPDATE `users_settings` SET `files_forum`=0 WHERE `id_us`=".$this->userid."");
		}else{
			$db->query("UPDATE `users_settings` SET `files_forum`=1 WHERE `id_us`=".$this->userid."");
		}
		header('location:/kab/additional_settings');
	}

	function getAds(){
		return $this->settings['ads'];
	}

	function setAds(){
		global $db;
		if($this->settings['ads']==1){
			$db->query("UPDATE `users_settings` SET `ads`=0 WHERE `id_us`=".$this->userid."");
		}else{
			$db->query("UPDATE `users_settings` SET `ads`=1 WHERE `id_us`=".$this->userid."");
		}
		header('location:/kab/additional_settings');
	}

	function getSmile(){
		return $this->settings['smiles'];
	}

	function setSmile(){
		global $db;
		if($this->settings['smiles']==1){
			$db->query("UPDATE `users_settings` SET `smiles`=0 WHERE `id_us`=".$this->userid."");
		}else{
			$db->query("UPDATE `users_settings` SET `smiles`=1 WHERE `id_us`=".$this->userid."");
		}
		header('location:/kab/additional_settings');
	}

	function getViewMail(){
		return $this->settings['view_mail'];
	}

	function setViewMail(){
		global $db;
		if($this->settings['view_mail']==1){
			$db->query("UPDATE `users_settings` SET `view_mail`=2 WHERE `id_us`=".$this->userid."");
		}else{
			$db->query("UPDATE `users_settings` SET `view_mail`=1 WHERE `id_us`=".$this->userid."");
		}
		header('location:/kab/additional_settings');
	}

	function getAjax(){
		return $this->settings['ajax'];
	}

	function setAjax(){
		global $db;
		if($this->settings['ajax']==1){
			$db->query("UPDATE `users_settings` SET `ajax`=0 WHERE `id_us`=".$this->userid."");
		}else{
			$db->query("UPDATE `users_settings` SET `ajax`=1 WHERE `id_us`=".$this->userid."");
		}
		header('location:/kab/additional_settings');
	}

	function getFilesMail(){
		return $this->settings['files_mail'];
	}

	function setFilesMail(){
		global $db;
		if($this->settings['files_mail']==1){
			$db->query("UPDATE `users_settings` SET `files_mail`=0 WHERE `id_us`=".$this->userid."");
		}else{
			$db->query("UPDATE `users_settings` SET `files_mail`=1 WHERE `id_us`=".$this->userid."");
		}
		header('location:/kab/additional_settings');
	}

	function getNormalNotifications(){
		return $this->settings['normal_notifications'];
	}

	function setNormalNotifications(){
		global $db;
		if($this->settings['normal_notifications']==1){
			$db->query("UPDATE `users_settings` SET `normal_notifications`=0 WHERE `id_us`=".$this->userid."");
		}else{
			$db->query("UPDATE `users_settings` SET `normal_notifications`=1 WHERE `id_us`=".$this->userid."");
		}
		header('location:/kab/additional_settings');
	}

	function getUpPanel(){
		return $this->settings['up_panel'];
	}

	function setUpPanel(){
		global $db;
		if($this->settings['up_panel']==1){
			$db->query("UPDATE `users_settings` SET `up_panel`=0 WHERE `id_us`=".$this->userid."");
		}else{
			$db->query("UPDATE `users_settings` SET `up_panel`=1 WHERE `id_us`=".$this->userid."");
		}
		header('location:/kab/additional_settings');
	}

	function getFeedAnk(){
		return $this->settings['feed_ank'];
	}

	function setFeedAnk(){
		global $db;
		if($this->settings['feed_ank']==1){
			$db->query("UPDATE `users_settings` SET `feed_ank`=0 WHERE `id_us`=".$this->userid."");
		}else{
			$db->query("UPDATE `users_settings` SET `feed_ank`=1 WHERE `id_us`=".$this->userid."");
		}
		header('location:/kab/additional_settings');
	}
}
?>