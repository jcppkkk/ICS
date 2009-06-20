<?php require_once("php/lib.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>test</title>

        <link rel="stylesheet" type="text/css" href="php/style.css" /></link>
<script type="text/javascript" src="php/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="php/js/jquery.validate.js"></script>
<script type="text/javascript" src="php/js/jquery.form.js"></script>
<script type="text/javascript">
$().ready(function() {
    // start add row
    //addRow("you");
    $("#TASKS").hide();
    $("#TASKS select,#TASKS input:text").each(function(){
        $(this).val($(this).attr("val"));
    });
    //$("#TASKS input").each(function(){
    //    $(this).val($(this).attr("val"));
    //});
    $("#TASKS").show("normal");


    var i = <?php echo time(); ?>;

    function addRow(type) {
        var template = jQuery.format($("#template-"+type, null).val());
        $(template(i++)).appendTo("#TASKS tbody");
        two_color();
    }

    function two_color(){
        $("#TASKS #task_tr:visible:even").css("backgroundColor",'#e7f3ff');
        $("#TASKS #task_tr:visible:odd").css("backgroundColor",'#effbde');
    }

    // add more rows on click
    $("#add").live("click" ,function(){
        addRow($(this).val());
    });

    // DELETE TASKS
    $(":input[value=delete]").live("click" ,function(){
        $(this).parent().parent().fadeOut(250, function() {
            $(this).find("#op").val("-");
            two_color();
        });
    });

    // AJAX POST framwork
    var options = {
        target:        "#pre",   // target element(s) to be updated with server response
            beforeSubmit:  sendCache,  // pre-submit callback
            success:       showResponse  // post-submit callback
    };

    $("#input_form").ajaxForm(options);

    function sendCache(formData, jqForm, options) {
        // To access the DOM element for the form do this:
        // var formElement = jqForm[0];

        //var queryString = $.param(formData);
        //alert('About to submit: \n\n' + queryString);
        return true;
    }

    // post-submit callback
    function showResponse(responseText, statusText)  {
        //alert('status: ' + statusText + '\n\nresponseText: \n' + responseText +
        //    '\n\nThe output div should have already been updated with the responseText.');

        $("#TASKS tr:hidden").each(function(){$(this).remove();});
        $("#TASKS tbody select").each(function(){
            $(this).attr("val",$(this).find(":selected").val());
            //$(this).val($(this).find(":selected").val());
        });
        $("#TASKS tbody input:text").each(function(){
            $(this).attr("val",$(this).val());
            //$(this).val($(this).find(":selected").val());
        });
        $.post('php/cache.php',{ text: $("#TASKS tbody").html() }, function(txt){});
    }
});

</script>
</head>
<body>

<pre id="pre">
<?php
// read cache
//print_r($b);
?>
</pre>

<button id="add" value="cmd">新增 自訂命令</button>
<button id="add" value="rss">新增 RSS訂閱</button>
<button id="add" value="you">新增 youtube訂閱</button>
<form id="input_form" class="cmxform" method="post" action="php/commit.php">
    <table id="TASKS">
        <tbody>
<?php
$CACHE = @file_get_contents("php/UIcache/cache.html");
if($CACHE != null){
    $CACHE = str_replace('\"', '"', $CACHE);//unescape quote
    printf($CACHE,FILE_BINARY);
}
?>
        </tbody>
        <tfoot>
            <tr>
                <td><input class="submit" type="submit" value="Submit"/></td>
            </tr>
        </tfoot>
    </table>
</form>
<div class="message"></div>

<textarea style="display:none" id="template-cmd">
    <tr id="task_tr">
        <td class="td_pad">
            <fieldset>
                <legend>{0}. 自訂命令執行</legend>
                <!--label>{0}. Item</label-->
                <input type="hidden" name="Task{0}[type]" value="CMD" >
                <input type="hidden" name="Task{0}[id]" value="{0}" >
                <input type="hidden" id="op" name="Task{0}[op]" value="+" >
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
                <input type="hidden" name="Task{0}[id]" value="{0}" >
                <input type="hidden" id="op" name="Task{0}[op]" value="+" >
                更新週期：
                <SELECT NAME="Task{0}[circle]">
                    <OPTION VALUE ="*/30 * * * *">每30分鐘</OPTION>
                    <OPTION VALUE ="0 * * * *">每1小時</OPTION>
                    <OPTION VALUE ="0 */3 * * *">每3小時</OPTION>
                    <OPTION VALUE ="0 */6 * * *">每6小時</OPTION>
                    <OPTION VALUE ="0 0,12 * * *">每12小時</OPTION>
                    <OPTION VALUE ="0 0 * * *">每日</OPTION>
                    <OPTION VALUE ="0 0 * * 1">每周</OPTION>
                </SELECT>
                <br>RSS網址： <input type="text" autocomplete="off" name="Task{0}[url]" size="50" />
            </fieldset>
        </td>
        <td>
            <input  value="delete" type="button">
        </td>
    </tr>
</textarea>

<textarea style="display:none" id="template-you">
    <tr id="task_tr" >
        <td class="td_pad">
            <fieldset>
                <legend>{0}. 訂閱youtube</legend>
                <input type="hidden" name="Task{0}[type]" value="YOU" >
                <input type="hidden" name="Task{0}[id]" value="{0}" >
                <input type="hidden" id="op" name="Task{0}[op]" value="+" >
                訂閱節目：
                <SELECT NAME="Task{0}[search]">
                    <OPTION VALUE ="我愛黑澀會+2009-06-17">我愛黑澀會</OPTION>
                    <OPTION VALUE ="模范棒棒堂+2009-06-17">模范棒棒堂</OPTION>
                    <OPTION VALUE ="康熙來了+2009-06-17">康熙來了</OPTION>
                    <OPTION VALUE ="2009-06-06+我猜我猜我猜猜猜">我猜我猜我猜猜猜</OPTION>
                </SELECT>
            </fieldset>
        </td>
        <td>
            <input  value="delete" type="button">
        </td>
    </tr>
</textarea>
</body>
</html>
