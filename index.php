<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>test</title>
</head>

<body>
<form  method="post" action="">
  <table border="1">
  <tr>
    <td>password: </td>
    <td><input type="text" maxlength="5" name="password" id="password" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><label>
      <input type="submit" name="submit" id="submit" value="送出" />
    </label></td>
  </tr>
</table>
</form>
<br>
<?php
system("env VISUAL=\"echo '5 0 * * *       \$HOME/bin/daily.job >> \$HOME/tmp/out 2>&1' >\" crontab -e");
system("whoami");
system("crontab -l");
	define("struct_len",6);
	if(strlen($_POST["password"])>0)
	{
		echo  "你輸入的是 [".$_POST["password"]."]<br>";
		$tmpstr = $_POST["password"];
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
	}
?>
</body>
</html>

