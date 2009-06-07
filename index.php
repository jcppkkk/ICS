<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>test</title>
<script type="text/javascript" src="./js/jquery-dynamic-form.js"></script>
</head>
<body>
<form name="input_form" id="input_form"  method="post" action="">
  <table border="1">
    <tr>
	<td>分</td>
	<td>
	<SELECT NAME="minute_shellcmd">
		<?php
			for($i=1;$i<61;$i++)
			{echo "<OPTION VALUE ='".$i."'>".$i."</OPTION>\n";}
		?>
	</SELECT>
	</td>
	<td>時</td>
	<td>
	<SELECT NAME="hour_shellcmd">
		<?php
			for($i=0;$i<24;$i++)
			{echo "<OPTION VALUE ='".$i."'>".$i."</OPTION>\n";}
		?>
	</SELECT>
	</td>
	<td>日</td>
	<td>
	<SELECT NAME="day_shellcmd">
		<?php
			for($i=1;$i<32;$i++)
			{echo "<OPTION VALUE ='".$i."'>".$i."</OPTION>\n";}
		?>
	</SELECT>
	</td>
	<td>月</td>
	<td>
	<SELECT NAME="month_shellcmd">
		<?php
			for($i=1;$i<13;$i++)
			{echo "<OPTION VALUE ='".$i."'>".$i."</OPTION>\n";}
		?>
	</SELECT>
	</td>
	<td>星期</td>
	<td>
	<SELECT NAME="week_shellcmd">
		<?php
			for($i=1;$i<7;$i++)
			{echo "<OPTION VALUE ='".$i."'>".$i."</OPTION>\n";}
		?>
		<OPTION VALUE ='7'>日</OPTION>
	</SELECT>
	</td>
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
