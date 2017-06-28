<?php
function dateDiv($date1,$date2) { //ส่งวันที่ที่ต้องการเปรียบเทียบ ในรูปแบบ มาตรฐาน 2006-03-27 21:39:12
$t1Arr = splitTime($date1);
$t2Arr = splitTime($date2);

$Time1=mktime($t1Arr["h"], $t1Arr["m"], $t1Arr["s"], $t1Arr["M"], $t1Arr["D"], $t1Arr["Y"]);
$Time2=mktime($t2Arr["h"], $t2Arr["m"], $t2Arr["s"], $t2Arr["M"], $t2Arr["D"], $t2Arr["Y"]);
$TimeDiv=abs($Time2-$Time1);
$Time["D"]=intval($TimeDiv/86400); // จำนวนวัน
$Time["H"]=intval(($TimeDiv%86400)/3600); // จำนวน ชั่วโมง
$Time["M"]=intval((($TimeDiv%86400)%3600)/60); // จำนวน นาที
$Time["S"]=intval(((($TimeDiv%86400)%3600)%60)); // จำนวน วินาที
return $Time;
}
function splitTime($time){ // เวลาในรูปแบบ มาตรฐาน 2006-03-27 21:39:12 
$timeArr["Y"]= substr($time,2,2);
$timeArr["M"]= substr($time,5,2);
$timeArr["D"]= substr($time,8,2);
$timeArr["h"]= substr($time,11,2);
$timeArr["m"]= substr($time,14,2);
$timeArr["s"]= substr($time,17,2);
return $timeArr;
}
?>