<?php
$time = mktime(date("H")-1,date("i"),date("s"),date("m"),date("d"),date("Y"));
echo date(' d.m.Y         H:i:s' , $time);

?>