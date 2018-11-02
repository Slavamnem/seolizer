<?php

function getDatesDiff($date1, $date2)
{
    $diff = abs(strtotime($date2) - strtotime($date1));
    $days = floor($diff / (60*60*24));
    return $days > 0 ?  $days." ".days($days)." назад" : "сегодня";
}
function days($days)
{
    $a = substr($days,strlen($days)-1,1);
    if($a==1) $res = "день";
    if($a==2 || $a==3 || $a==4) $res = "дня";
    if($a==5 || $a==6 || $a==7 || $a==8 || $a==9 || $a==0) $res = "дней";
    return $res;
}