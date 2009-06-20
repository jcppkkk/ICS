<?php
$CONFIG_DIR="../coretask";
if(count($_POST)>0)
{
    $diff=$CONFIG_DIR."/".time();
    ob_start();
    print_r($_POST);
    $output = ob_get_contents();
    ob_end_clean();

    $fp = fopen($diff, "w");
    fwrite($fp,$output);
    fclose($fp);
    chmod($diff, 0666);
    //print_r($_POST);//read POST
}
?>
