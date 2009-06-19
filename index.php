<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>test</title>

<script type="text/javascript" src="php/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="php/js/jquery.validate.js"></script>
<script type="text/javascript" src="php/js/jquery.form.js"></script>
<link rel="stylesheet" type="text/css" href="php/style.css" />
<script type="text/javascript">
$().ready(function() {
    function addRow(type) {
        var template = jQuery.format($("#template-"+type).val());
        $(template(i++)).appendTo("#TASK tbody");
        two_color();
    }

    function two_color(){
        $("#TASK #task_tr:even").css("backgroundColor",'#e7f3ff');
        $("#TASK #task_tr:odd").css("backgroundColor",'#effbde');
    }

    var i = 1;
    // start with one row
    addRow("rss");
    addRow("cmd");
    // add more rows on click
    $("#add").live("click" ,function(){
        addRow($(this).val());
    });

    $(":input[value=delete]").live("click" ,function(){
        $(this).parent().parent().fadeOut(250, function() {
            $(this).remove();
            two_color();
        });
    });
    var options = {
        target:        '#output1',   // target element(s) to be updated with server response
        beforeSubmit:  showRequest,  // pre-submit callback
        success:       showResponse  // post-submit callback

        // other available options:
        //url:       url         // override for form's 'action' attribute
        //type:      type        // 'get' or 'post', override for form's 'method' attribute
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
        //clearForm: true        // clear all form fields after successful submit
        //resetForm: true        // reset the form after successful submit

        // $.ajax options can be used here too, for example:
        //timeout:   3000
    };
    $("#input_form").ajaxForm(options);
    function showRequest(formData, jqForm, options) {
        // formData is an array; here we use $.param to convert it to a string to display it
        // but the form plugin does this for you automatically when it submits the data
        var queryString = $.param(formData);

        // jqForm is a jQuery object encapsulating the form element.  To access the
        // DOM element for the form do this:
        // var formElement = jqForm[0];

        alert('About to submit: \n\n' + queryString);

        // here we could return false to prevent the form from being submitted;
        // returning anything other than false will allow the form submit to continue
        return true;
    }

    // post-submit callback
    function showResponse(responseText, statusText)  {
        // for normal html responses, the first argument to the success callback
        // is the XMLHttpRequest object's responseText property

        // if the ajaxForm method was passed an Options Object with the dataType
        // property set to 'xml' then the first argument to the success callback
        // is the XMLHttpRequest object's responseXML property

        // if the ajaxForm method was passed an Options Object with the dataType
        // property set to 'json' then the first argument to the success callback
        // is the json data object returned by the server

        alert('status: ' + statusText + '\n\nresponseText: \n' + responseText +
            '\n\nThe output div should have already been updated with the responseText.');
    }
});

</script>
</head>
<body>
<pre> <?php
require_once("php/lib.php");
createDiff($_POST);
print_r($_POST);
saveCache($_POST);
$b = getCache();
#echo "<br>after----------------------------------------<br>";
#print_r($b);
?></pre>

<button id="add" value="cmd">新增 自訂命令</button>
<button id="add" value="rss">新增 RSS訂閱</button>
<form id="input_form" class="cmxform" method="post" action="index.php">
        <table id="TASK">
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <td><input class="submit" type="submit" value="Submit"/></td>
                </tr>
            </tfoot>
        </table>
</form>
<div id="output1"></div>
<textarea style="display:none" id="template-cmd">
    <tr id="task_tr">
        <td class="td_pad">
            <fieldset>
                <legend>{0}. 自訂命令執行</legend>
                <!--label>{0}. Item</label-->
                <input type="hidden" name="Task{0}[type]" value="CMD" >
                <input type="hidden" name="Task{0}[id]" value="{0}" >
                <input type="hidden" name="Task{0}[op]" value="+" >
                <SELECT NAME="Task{0}[month]">
                    <OPTION VALUE ='*'>每月</OPTION>
                    <?php makeOption(1, 12, null, "月"); ?>
                </SELECT>
                <SELECT NAME="Task{0}[day]">
                    <OPTION VALUE ='*'>每日</OPTION>
                    <?php makeOption(1, 31, null, "號"); ?>
                </SELECT>
                <SELECT NAME="Task{0}[week]">
                    <OPTION VALUE ='*'>每日</OPTION>
                    <?php makeWeekOption();?>
                </SELECT>
                <SELECT NAME="Task{0}[hour]">
                    <OPTION VALUE ='*'>每時</OPTION>
                    <?php makeOption(0, 23, null, "時"); ?>
                </SELECT>
                <SELECT NAME="Task{0}[minute]">
                    <OPTION VALUE ='*'>每分</OPTION>
                    <?php makeOption(0, 59, null, "分"); ?>
                </SELECT>
                <br>執行指令 <input type="text" autocomplete="off" name="Task{0}[cmd]" size="50" />
            </fieldset>
        </td>
        <td>
            <input  value="delete" type="button">
        </td>
    </tr>
</textarea>

<textarea style="display:none" id="template-rss">
    <tr id="task_tr" >
        <td class="td_pad">
            <fieldset>
                <legend>{0}. 追蹤RSS新消息</legend>
                <input type="hidden" name="Task{0}[type]" value="RSS" >
                <input type="hidden" name="Task{0}[id]" value="+" >
                更新週期：
                <SELECT NAME="Task{0}[month]">
                    <OPTION VALUE ='*/30 * * * *'>每30分鐘</OPTION>
                    <OPTION VALUE ='0 * * * *'>每1小時</OPTION>
                    <OPTION VALUE ='0 */3 * * *'>每3小時</OPTION>
                    <OPTION VALUE ='0 */6 * * *'>每6小時</OPTION>
                    <OPTION VALUE ='0 0,12 * * *'>每12小時</OPTION>
                    <OPTION VALUE ='0 0 * * *'>每日</OPTION>
                    <OPTION VALUE ='0 0 * * 1'>每周</OPTION>
                </SELECT>
                <br>RSS網址： <input type="text" autocomplete="off" name="Task{0}[url]" size="50" />
            </fieldset>
        </td>
        <td>
            <input  value="delete" type="button">
        </td>
    </tr>
</textarea>
</body>
</html>
