<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Logbook {
    
/**
 * Возвращает название месяца по его номеру
 *  */
static function month($index, $short = 0)
{
    $months = ['-', 'январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь' ];
    $months_short = ['-', 'янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек' ];
    
    if (is_numeric($index) and $index >= 0 and $index <= 12) 
        {
        if ($short) {$month = $months_short[$index];}
        else {$month = $months[$index];}
        } 
    elseif (is_numeric(strtotime($index))) {
        $index = (int)substr($index, 5, 2);
        if ($short) {$month = $months_short[$index];}
        else {$month = $months[$index];}
    }
    else {
        $month = 'n/a';
    }
    //dump($month);
    return $month;
}


    /**
 * Возвращает сумму прописью
 * @author runcore
 * @uses morph(...)
 */
static function num2str($num) {
	$nul='ноль';
	$ten=array(
		array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
		array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
	);
	$a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
	$tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
	$hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
	$unit=array( // Units
		array('копейка' ,'копейки' ,'копеек',	 1),
		array('рубль'   ,'рубля'   ,'рублей'    ,0),
		array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
		array('миллион' ,'миллиона','миллионов' ,0),
		array('миллиард','милиарда','миллиардов',0),
	);
	//
	list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
	$out = array();
	if (intval($rub)>0) {
		foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
			if (!intval($v)) continue;
			$uk = sizeof($unit)-$uk-1; // unit key
			$gender = $unit[$uk][3];
			list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
			// mega-logic
			$out[] = $hundred[$i1]; # 1xx-9xx
			if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
			else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
			// units without rub & kop
			if ($uk>1) $out[]= Logbook::morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
		} //foreach
	}
	else $out[] = $nul;
	$out[] = Logbook::morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
	$out[] = $kop.' '.Logbook::morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
	return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

/**
 * Склоняем словоформу
 * @ author runcore
 */
static function morph($n, $f1, $f2, $f5) {
	$n = abs(intval($n)) % 100;
	if ($n>10 && $n<20) return $f5;
	$n = $n % 10;
	if ($n>1 && $n<5) return $f2;
	if ($n==1) return $f1;
	return $f5;
}


static function normal_date($date) {
    return date('d.m.Y', strtotime($date));
}
 
// пересечение временных интервалов. interval1 и interval2 - массивы из 2 элементов - [старт, финиш]
static function time_cross($interval1, $interval2) {
    $start1 = $interval1[0];
    $start2 = $interval2[0];
    
    $finish1 = $interval1[1];
    $finish2 = $interval2[1];
    
    $cross = false;
               if (     ($start1    >=  $start2 &&   $finish1 <=   $finish2) or // один меньше другого и внутри
                        ($start1    <=  $start2 &&   $finish1 >=   $finish2) or // один больше другого и поглощает его
                        ($finish1   >=  $start2 &&   $finish1 <=   $finish2) or // зацепляет концом
                        ($finish1   >=  $start2 &&   $start1 <=    $finish2)    // зацепляет началом
                  )
               {$cross = true;}
    return $cross;
}

}
