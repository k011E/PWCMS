<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Бб-коды';
$menu = $title;
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="list1">
	1. Ссылка: [url=http://wap-obzor.ru]Название[/url] (<?=bb('[url=http://wap-obzor.ru]Название[/url]')?>)
</div>
<div class="list1">
	2. Курсив (текст): [i]Текст[/i] (<?=bb('[i]Текст[/i]')?>)
</div>
<div class="list1">
	3. Жирность (текст): [b]Текст[/b] (<?=bb('[b]Текст[/b]')?>)
</div>
<div class="list1">
	4. Подчеркивание (текст): [u]Текст[/u] (<?=bb('[u]Текст[/u]')?>)
</div>
<div class="list1">
	5. Пунктирная линия (текст): [ut]Текст[/ut] (<?=bb('[ut]Текст[/ut]')?>)
</div>
<div class="list1">
	6. Абсолютная малость (текст): [small]Текст[/small] (<?=bb('[small]Текст[/small]')?>)
</div>
<div class="list1">
	7. Пунктирная табличка (текст): [das]Текст[/das] (<?=bb('[das]Текст[/das]')?>)
</div>
<div class="list1">
	8. Бегущая строка: [marq]Текст[/marq]  (<?=bb('[marq]Текст[/marq]')?>)
</div>
<div class="list1">
	9. Центрирование: [c]Данные[/c] (<?=bb('[c]Данные[/c]')?>)
</div>
<div class="list1">
	11. Табличка: [sol]Данные[/sol] (<?=bb('[sol]Данные[/sol]')?>)
</div>
<div class="list1">
	12. Зачеркнутый текст: [ex]Текст[/ex] (<?=bb('[ex]Текст[/ex]')?>)
</div>
<div class="list1">
	13. Пунктирная табличка (1px): [dot]Текст[/dot] (<?=bb('[dot]Текст[/dot]')?>)
</div>
<div class="list1">
	14. Двойная табличка: [dou]Текст[/dou] (<?=bb('[dou]Текст[/dou]')?>)
</div>
<div class="list1">
	15. Большой шрифт: [big]Текст[/big] (<?=bb('[big]Текст[/big]')?>)
</div>
<div class="list1">
	16. PHP код: [code]Текст[/code] (<?=bb('[code]echo $a;[/code]')?>)
</div>
<div class="list1">
	17. Красный шрифт: [red]Текст[/red] (<?=bb('[red]Текст[/red]')?>)
</div>
<div class="list1">
	18. Белый шрифт: [white]Текст[/white] (<?=bb('[white]Текст[/white]')?>)
</div>
<div class="list1">
	19. Синий шрифт: [blue]Текст[/blue] (<?=bb('[blue]Текст[/blue]')?>)
</div>
<div class="list1">
	20. Зелёный шрифт: [green]Текст[/green] (<?=bb('[green]Текст[/green]')?>)
</div>
<div class="list1">
	21. Цитата: [cit]Текст[/cit] (<?=bb('[cit]Текст[/cit]')?>)
</div>
<div class="list1">
	22. Изображение: [img]Путь_к_картинке[/img] (<?=bb('[img]/design/images/logo_1.png[/img]')?>)
</div>
<div class="list1">
	23. Вывод пользователя: us{ID пользователя} (<?=bb('us{1}')?>)
</div>
<div class="list1">
	24. Вывод текущего пользователя: us{this} (<?=bb('us{this}')?>)
</div>
<div class="list1">
	27. WMID или [R|Z|U|E|B] кошельки: [wm]367576958477[/wm] (<?=bb('[wm]367576958477[/wm]')?>)
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>