<?php
$CONFIG_DIR="coretask";
$CONFIG_CACHE="php/.UIcache";


# retrieve from file
function getCache()
{
    global $CONFIG_CACHE;
    return unserialize(file_get_contents($CONFIG_CACHE));
}

function makeOption($f, $t, $pre="" , $pos="")
{ for($i=$f;$i<=$t;$i++) {echo "<OPTION VALUE ='".$i."'>".$pre.$i.$pos."</OPTION>";} }

function makeWeekOption()
{
    $arr=array("一","二","三","四","五","六","日");
    for($i=0;$i<=6;$i++) {echo "<OPTION VALUE ='".$i."'>"."星期".$arr[$i]."</OPTION>";}
}

?>
