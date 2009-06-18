<?php
$CONFIG_DIR="coretask";
$CONFIG_CACHE="php/.UIcache";

/* 增加POST "+" id:time()*/
/* 儲存 CONFIG_DIR/time() */
function createDiff()
{
    global $CONFIG_DIR;
    $diff=$CONFIG_DIR."/".time();
    ob_start();
    print_r($_POST);
    $output = ob_get_contents();
    ob_end_clean();

    $fp = fopen($diff, "w");
    fwrite($fp,$output);
    fclose($fp);
    chmod($diff, 0666);
}

/* 修改POST */
# save POST to file
function saveCache($a)
{
    global $CONFIG_CACHE;
    $fp = fopen($CONFIG_CACHE, "w+") or die("I could not open $CONFIG_CACHE");
    fwrite($fp, serialize($a));
    fclose($fp);
}

# retrieve from file
function getCache()
{
    global $CONFIG_CACHE;
    return unserialize(file_get_contents($CONFIG_CACHE));
}

?>
