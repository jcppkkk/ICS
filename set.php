<?php require_once("php/lib.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>test</title>

        <link rel="stylesheet" type="text/css" href="php/style.css" /></link>
<script src="php/js/jquery-1.3.2.min.js"></script>
<script src="php/js/jquery.validate.js"></script>
<script src="php/js/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    // start add row
    //$("#TASKS").hide();

    $("#TASKS select,#TASKS input:text, input.submit").each(function(){
        $(this).val($(this).attr("val"));
        $(this).attr("disabled", "disabled");
    });

    //$("#TASKS").show("slow");


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
    $("#add").live("click", function(){
        addRow($(this).val());
    });

    $("button, :button").live("click", function(){
        $("input.submit").removeAttr("disabled");
    });

    // Rename TASKS
    //<legend><input type="text" value="{0}. 追蹤RSS新消息" size="30"></legend>
    $(":input[button=rename]").live("click" ,function(){
        $legend = $(this).parent().parent().find("legend");
        $text = $legend.html();
        $legend.html('<input id="legendBOX" type="text" value="'+$text+'" size="30">');
        $(this).parent().parent().find("#op").val("!");
    });

    // DELETE TASKS
    $(":input[button=delete]").live("click" ,function(){
        $(this).parent().parent().fadeOut(250, function() {
            if($(this).find("#op").val()=="+")
                $(this).remove();
            else
                $(this).find("#op").val("-");
            two_color();
        });
    });

    // Modify TASKS
    $(":input[button=modify]").live("click" ,function(){
        $(this).parent().parent().find("select, input:text").each(function(){
            $(this).removeAttr("disabled");
        });
        $(this).parent().parent().find("#op").val("!");
    });

    // AJAX POST framwork
    var options = {
        target:        "#pre",   // target element(s) to be updated with server response
            beforeSubmit:  before,  // pre-submit callback
            success:       showResponse  // post-submit callback
    };

    $("#input_form").ajaxForm(options);

    function before(formData, jqForm, options) {
        // To access the DOM element for the form do this:
        // var formElement = jqForm[0];
        if($("#legendBOX").length)
        {
            $("#legendBOX").each(function(){
                $text = $(this).val();
                $(this).parent().html($text);
                //$(this).remove();
            });
        }
        //var queryString = $.param(formData);
        //alert('About to submit: \n\n' + queryString);
        return true;
    }

    // post-submit callback
    function showResponse(responseText, statusText)  {
        //alert('status: ' + statusText + '\n\nresponseText: \n' + responseText +
        //    '\n\nThe output div should have already been updated with the responseText.');

        /* delete */
        $("#TASKS tr:hidden").each(function(){$(this).remove();});

        /* backup selected to "val" */
        $("#TASKS tbody select").each(function(){
            $(this).attr("val",$(this).find(":selected").val());
        });

        /* backup text to "val" */
        $("#TASKS tbody input:text").each(function(){
            $(this).attr("val",$(this).val());
        });

        /* lock submit & inputs */
        $("#TASKS select, #TASKS input:text, input.submit").each(function(){
            $(this).attr("disabled", "disabled");
        });

        $("#TASKS").find("#op").val("=");

        /* post cache */
        $.post('php/cache.php',{ text: $("#TASKS tbody").html() }, function(txt){ });

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
                <td id="td"><input class="submit" type="submit" value="送出"/></td>
            </tr>
        </tfoot>
    </table>
</form>



























<textarea style="display:none" id="template-cmd">
    <tr id="task_tr">
        <td id="td" class="td_input">
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
        <td id="td">
            <input button="rename" value="改標題" type="button"><br>
            <input button="delete" value="刪除" type="button"><br>
            <input button="modify" value="重新修改" type="button">
        </td>
        <td id="td">
            <a href="data/{0}" target="data">瀏覽</a>
        </td>
    </tr>
</textarea>

<textarea style="display:none" id="template-rss">
    <tr id="task_tr" >
        <td id="td" class="td_input">
            <fieldset>
                <legend><input type="text" value="{0}. 追蹤RSS新消息" size="30"></legend>
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
        <td id="td">
            <input button="rename" value="改標題" type="button"><br>
            <input button="delete" value="刪除" type="button"><br>
            <input button="modify" value="重新修改" type="button">
        </td>
        <td id="td">
            <a href="data/{0}" target="data">瀏覽</a>
        </td>
    </tr>
</textarea>

<textarea style="display:none" id="template-you">
    <tr id="task_tr" >
        <td id="td" class="td_input">
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
        <td id="td">
            <input button="rename" value="改標題" type="button"><br>
            <input button="delete" value="刪除" type="button"><br>
            <input button="modify" value="重新修改" type="button">
        </td>
        <td id="td">
            <a href="data/{0}" target="data">瀏覽</a>
        </td>
    </tr>
</textarea>


</body>
</html>
