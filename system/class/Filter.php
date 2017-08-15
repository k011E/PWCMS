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
* @author KekuS
* Filter class
*/
class Filter
{
	function validBool($str){
		return filter_var($str, FILTER_VALIDATE_BOOLEAN);
	}

	function validEmail($str){
		return filter_var($str, FILTER_VALIDATE_EMAIL);
	}

	function validFloat($str){
		return filter_var($str, FILTER_VALIDATE_FLOAT);
	}

	function validInt($str){
		return filter_var($str, FILTER_VALIDATE_INT);
	}

	function validIP($str){
		return filter_var($str, FILTER_VALIDATE_IP);
	}

	function validURL($str){
		return filter_var($str, FILTER_VALIDATE_URL);
	}

	function clearEmail($str){
		$str = filter_var($str, FILTER_SANITIZE_EMAIL);
		return $str;
	}

	function clearMagicQuotes($str){
		$str = filter_var($str, FILTER_SANITIZE_MAGIC_QUOTES);
		return $str;
	}

	function clearFloat($str){
		$str = filter_var($str, FILTER_SANITIZE_NUMBER_FLOAT);
		return $str;
	}

	function clearInt($str){
		$str = filter_var($str, FILTER_SANITIZE_NUMBER_INT);
		return $str;
	}

	function clearSpecialChars($str){
		$str = filter_var($str, FILTER_SANITIZE_SPECIAL_CHARS);
		return $str;
	}

	function clearFullSpecialChars($str){
		$str = filter_var($str, FILTER_SANITIZE_SPECIAL_CHARS);
		return $str;
	}

	function clearString($str){
		$str = filter_var($str, FILTER_SANITIZE_STRING);
		return $str;
	}

	function clearURL($str){
		$str = filter_var($str, FILTER_SANITIZE_URL);
		return $str;
	}

	function output($str){
		$str = $this->clearFullSpecialChars($str);
		$str = nl2br($str);
		return $str;
	}

	function outputText($str){
		$str = $this->clearFullSpecialChars($str);
		$str = nl2br($str);
		$str = bb($str);
		$str = new_bb($str);
		return $str;
	}

	function input($str) {
		$str = $this->clearString($str);
		return $str;
	}
}
?>