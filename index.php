<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
<form  method="post" action="">
  <table border="1">
  <tr>
    <td>password: </td>
    <td><input type="text" name="password" id="password" /></td>
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
echo  "你輸入的是 [".$_POST["password"]."]";
?>
</body>
</html>
