<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>test</title>
</head>
<body>
<?php
require_once("php/lib.php");
createDiff($_POST);
#print_r($_POST);
saveCache($_POST);
$b = getCache();
#echo "<br>after----------------------------------------<br>";
#print_r($b);
?>

<form  method="post" action="">
<input type="hidden" name="task[1][id]" value=6526815602157 />
<input type="hidden" name="task[1][op]" value=+ />
<input type="hidden" name="task[1][at][mon]" value=10 />
<input type="hidden" name="task[1][at][day]" value=10 />
<input type="hidden" name="task[1][at][week]" value=-1 />
<input type="hidden" name="task[1][at][hour]" value=17 />
<input type="hidden" name="task[1][at][min]" value=45 />
<input type="hidden" name="task[1][do]" value="tar -zcvf back.tgz WWW" />

<input type="hidden" name="task[2][id]" value=6526815602157 />
<input type="hidden" name="task[2][op]" value=- />
<input type="hidden" name="task[2][at][mon]" value=-1 />
<input type="hidden" name="task[2][at][day]" value=-1 />
<input type="hidden" name="task[2][at][week]" value=-1 />
<input type="hidden" name="task[2][at][hour]" value=-1 />
<input type="hidden" name="task[2][at][min]" value=15 />
<input type="hidden" name="task[2][do]" value="tar -zcvf back.tgz WWW" />

<input type="hidden" name="task[3][id]" value=6526815602157 />
<input type="hidden" name="task[3][op]" value=! />
<input type="hidden" name="task[3][at][mon]" value=-1 />
<input type="hidden" name="task[3][at][day]" value=-1 />
<input type="hidden" name="task[3][at][week]" value=-1 />
<input type="hidden" name="task[3][at][hour]" value=-1 />
<input type="hidden" name="task[3][at][min]" value=15 />
<input type="hidden" name="task[3][do]" value="tar -zcvf back.tgz WWW" />
  <table border="1">
    <tr>
      <td>目前指令</td>
      <td><?php echo $shellcmd; ?></td>
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
      <td><input type="text" name="shellcmd" />
        <input type="submit" name="submit" value="送出" /></td>
    </tr>
  </table>
</form>
<br>
</body>
</html>
