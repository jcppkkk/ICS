<?php
$CONFIG_CACHE="UIcache/cache.html";

$fp = fopen($CONFIG_CACHE, "w+") or die("I could not open $CONFIG_CACHE");
fwrite($fp, $_POST["text"]);
fclose($fp);
chmod($CONFIG_CACHE, 0666);
?>
