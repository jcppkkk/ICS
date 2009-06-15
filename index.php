<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>test</title>
<script type="text/javascript" src="./js/jquery-dynamic-form.js"></script>
<style type="text/css">

div#task_cmd {
   width: 100px;
   height: 100px;
   background-color: red;
}

</style>
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
<form name="input_form" id="input_form"  method="post" action="">
<div id="task_cmd" >
    <SELECT NAME="minute_shellcmd"> <?php for($i=1;$i<61;$i++) {echo "<OPTION VALUE ='".$i."'>".$i."</OPTION>";} ?> </SELECT>
    分
    <SELECT NAME="hour_shellcmd"> <?php for($i=0;$i<24;$i++) {echo "<OPTION VALUE ='".$i."'>".$i."</OPTION>";} ?> </SELECT>
    時
    <SELECT NAME="day_shellcmd"> <?php for($i=1;$i<32;$i++) {echo "<OPTION VALUE ='".$i."'>".$i."</OPTION>";} ?> </SELECT>
    日
    <SELECT NAME="month_shellcmd"> <?php for($i=1;$i<13;$i++) {echo "<OPTION VALUE ='".$i."'>".$i."</OPTION>";} ?> </SELECT>
    月
    星期
    <SELECT NAME="week_shellcmd"> <?php for($i=1;$i<7;$i++) {echo "<OPTION VALUE ='".$i."'>".$i."</OPTION>";} ?> <OPTION VALUE ='7'>日</OPTION> </SELECT>
    <p>執行指令 <input type="text" name="shellcmd" size="35" /></p>
</div>
    <input type="submit" name="submit" value="送出" />
</form>
<br>
</body>
</html>
