<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>test</title>
</head>
<body>
<?php
$CONFIG_FILE=".UIconfig";

/* save the POST */
if(isset($_POST["shellcmd"])){
    $content = @fopen($CONFIG_FILE, "w") or die("fopen write error");
    fputs($content, $_POST["shellcmd"]);
    fclose($content);
}

/* read config */
$content = @fopen($CONFIG_FILE, "r") or die("fopen read error");
$shellcmd="";
while (!feof($content))
{
    $line = fgets($content, 4096);
    $shellcmd=$shellcmd.$line;
}
fclose($content);
print_r($shellcmd);

?>
<form  method="post" action="">
  <table border="1">
    <tr>
      <td>目前指令</td>
      <td><?php echo $shellcmd; ?></td>
    </tr>
    <tr>
      <td>變更:執行指令</td>
      <td><input type="text" name="shellcmd" id="shellcmd" />
        <input type="submit" name="submit" id="submit" value="送出" /></td>
    </tr>
  </table>
</form>
<br>
<?php
        /*define("struct_len",6);
        if(strlen($_POST["shellcmd"])>0)
        {
                echo  "你輸入的是 [".$_POST["shellcmd"]."]<br>";
                $tmpstr = $_POST["shellcmd"];
                $fp = fopen("log.txt","a+");
                echo ftell($fp)."<br>";
                while(strlen($tmpstr) < 5)
                {
                        $tmpstr = $tmpstr." ";
                }
                $tmpstr = $tmpstr."\n";
                print_r($_POST);
                echo "<br>";
                fwrite($fp,$tmpstr);
                echo ftell($fp)."<br>";
                                fseek($fp,struct_len*-2,SEEK_END);
                if(ftell($fp)>struct_len)
                {
                        $prev = fgets($fp);
                        echo $prev;
                        echo  "上回你輸入的是".$prev."<br>";
                }
                fclose($fp);
        }*/
?>
</body>
</html>
