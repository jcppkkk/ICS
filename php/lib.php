<?php
$CONFIG_DIR=".UIconfig";
$CONFIG_CACHE=".UIcache";

/* 增加POST "+" id:time()*/
/* 儲存 CONFIG_DIR/time() */
/* 修改POST */
/* 儲存 CONFIG_CACHE */
function handlePOST()
{
    global $CONFIG_DIR, $CONFIG_CACHE;
    if(isset($_POST["shellcmd"]))
    {
        /* 增加POST "+" id:time()*/
        /* 儲存 CONFIG_DIR/time() */
        print_r($POST);
        chmod("$CONFIG_DIR/buffer.txt", 0666);
        ob_list_handlers();
        print_r($POST);
        $buffer = ob_get_flush();
        file_put_contents("$CONFIG_DIR/buffer.txt", $buffer);

        /* 修改POST */
        /* 儲存 CONFIG_CACHE */
        $content = @fopen($CONFIG_CACHE, "w+") or die("fopen write error");
        fputs($content, $_POST);
        fclose($content);
    }
}
/* read config */
function readCatch()
{
    global $CONFIG_DIR, $CONFIG_CACHE;
    $config = @fopen($CONFIG_CACHE, "r") or die("fopen read error");
    $shellcmd="";
    while (!feof($config))
    {
        $line = fgets($config, 4096);
        $shellcmd=$shellcmd.$line;
    }
    fclose($config);
    print_r($config);
}

?>