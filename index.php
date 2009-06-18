<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>test</title>

<script type="text/javascript" src="php/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="php/js/jquery-dynamic-form.js"></script>
<script type="text/javascript" src="php/js/jquery.validate.js"></script>
<link rel="stylesheet" type="text/css" href="php/style.css" />
<script type="text/javascript">
// only for demo purposes
$.validator.setDefaults({
    submitHandler: function() {
        alert("submitted!");
    }
});

$().ready(function() {
    $("#input_form").validate({
        errorPlacement: function(error, element) {
            error.appendTo( element.parent().next() );
        },
            highlight: function(element, errorClass) {
                $(element).addClass(errorClass).parent().prev().children("select").addClass(errorClass);
            }
    });

    var template = jQuery.format($("#template-cmd").val());

    function addRow() {
        $(template(i++)).appendTo("#TASK tbody");
        $("#TASK td").addClass('task_pad');
        $("#TASK #task_tr:even").css("backgroundColor",'#e7f3ff');
        $("#TASK #task_tr:odd").css("backgroundColor",'#effbde');
    }

    var i = 1;
    // start with one row
    addRow();
    // add more rows on click
    $("#add").click(addRow);

    // check keyup on quantity inputs to update totals field
    $("#input_form").delegate("keyup", "input.quantity", function(event) {
        var totals = 0;
        $("#TASK input.quantity").each(function() {
            totals += +this.value;
        });
        $("#totals").attr("value", totals).valid();
    });

});

</script>
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

<button id="add">Add another input to the form</button>
<form id="input_form" class="cmxform" method="post" action="">
    <fieldset>
        <legend>大家一起測爆他</legend>
        <table id="TASK">
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <td><input class="submit" type="submit" value="Submit"/></td>
                </tr>
            </tfoot>
        </table>
    </fieldset>
</form>

<textarea style="display:none" id="template-cmd">
    <tr id="task_tr" ><td id="task_cmd">
        <label>{0}. Item</label>
        月：    <SELECT NAME="Task[{0}]month"> <?php makeoption(1, 12); ?><OPTION VALUE ='*'>每月</OPTION> </SELECT>
        日：    <SELECT NAME="Task[{0}]day"> <?php makeoption(1, 31); ?> <OPTION VALUE ='*'>每日</OPTION></SELECT>
        星期：  <SELECT NAME="Task[{0}]week"> <?php makeoption(1, 6); ?> <OPTION VALUE ='7'>日</OPTION> </SELECT><br><br>
        時：    <SELECT NAME="Task[{0}]minute"> <?php makeoption(0, 60); ?> </SELECT>
        分：    <SELECT NAME="Task[{0}]hour"> <?php makeoption(0, 23); ?> </SELECT>
        執行指令 <input type="text" name="shellcmd" size="35" />
    </td></tr>
</textarea>

</body>
</html>
