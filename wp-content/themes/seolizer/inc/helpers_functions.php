<?php

function getDatesDiff($date1, $date2, $part)
{
    $diff = abs(strtotime($date2) - strtotime($date1));
    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
    switch($part){
        case 'years':
            return $years;
        case 'months':
            return $months;
        case 'days':
            return $days > 0 ?  $days." ".days($days)." назад" : "сегодня";
        default:
            return $days;
    }
}
function days($days)
{
    $a = substr($days,strlen($days)-1,1);
    if($a==1) $res = "день";
    if($a==2 || $a==3 || $a==4) $res = "дня";
    if($a==5 || $a==6 || $a==7 || $a==8 || $a==9 || $a==0) $res = "дней";
    return $res;
}