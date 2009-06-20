<?php
$CONFIG_DIR="coretask";
$CONFIG_CACHE="php/.UIcache";

function createDiff()
    $diff=$CONFIG_DIR."/".time();
    ob_start();
    print_r($_POST);
    $output = ob_get_contents();
    ob_end_clean();

    $fp = fopen($diff, "w");
    fwrite($fp,$output);
    fclose($fp);
    chmod($diff, 0666);

$fp = fopen($CONFIG_CACHE, "w+") or die("I could not open $CONFIG_CACHE");
fwrite($fp, $_POST["text"]);
fclose($fp);
?>
