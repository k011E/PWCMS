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
* Pagination class
*/
class Pagination
{
	public $total;
	public $start;
	public $end;
	public $page;

	function __construct($sql, $page, $max = 10)
	{
		global $db, $UserSettings;

		$max = $UserSettings->getMaxP();
		if(empty($page)) $page = 1;
		$this->page = $page;
		$this->total = $db->query($sql)->num_rows;
		$this->pages = ceil($this->total / $max);
		$this->start = $page * $max - 10;
		if($page == 1) $this->start = 0;
		$this->end = $start + $max;
	}

	function out($self)
	{
		$out .= 'Стр. ';

		if ($this->page != 1) {
			$out .= '<a href="' . $self . '/page1"><<</a> ';
			$out .= '<a href="' . $self . '/page' . ($this->page - 1) . '"><</a> ';  
		}

		if (($this->page - 2) > 0) {
			$out .= '<a href="' . $self .'/page'. ($this->page - 2) .'">'. ($this->page - 2) .'</a>';
			$out .= ' | ';  
		}
	
		if (($this->page - 1) > 0) {
			$out .= '<a href="' . $self .'/page'. ($this->page - 1) .'">'. ($this->page - 1) .'</a>';
			$out .= ' | ';  
		}

		$out .= $this->page;

		if (($this->page + 1) <= $this->pages) {
			$out .= ' | ';
			$out .= '<a href="' . $self . '/page' . ($this->page + 1) .'">' . ($this->page + 1) . '</a>'; 
		}

		if($this->page + 2 <= $this->pages) {
			$out .= ' | ';
			$out .= '<a href="' . $self . '/page' . ($this->page + 2) .'">' . ($this->page + 2) . '</a>';  
		}

		if ($this->page != $this->pages) {
			$out .= ' <a href="' . $self . '/page' . ($this->page + 1) . '">></a>';
			$out .= ' <a href="'.$self.'/page' . $this->pages .'">>></a>';  
		}
		
		if($this->total!=0){
			echo '<div class="lst">'.$out.'</div>';
		}
	}
}
?>