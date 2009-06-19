<?php
require_once("php/lib.php");
if(count($_POST)>0)
{
createDiff($_POST);
saveCache($_POST);
print_r($_POST);//read POST
exit(0);
}
?>
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

                    var i = <?php echo time(); ?>;
                    // start with one row
                    addRow("rss");
                    addRow("cmd");
                    // add more rows on click
                    $("#add").live("click" ,function(){
                        addRow($(this).val());
                        });

                    <?php
                        $b = getCache();
                    foreach( $b as $taskname => $task)
                    {
                        switch($task["type"])
                        {
                            case "RSS":
                                //echo "RSS!";
                                break;
                            case "CMD":
                                //echo "CMD!";
                                break;
                        }
                    }
                    // load array 'b' to form
                    ?>

                        // DELETE TASK
                        $(":input[value=delete]").live("click" ,function(){
                                $(this).parent().parent().fadeOut(250, function() {
                                    $(this).find("#op").val("-");
                                    two_color();
                                    });
                                });

                    // AJAX POST framwork

                    var options = {
                        target:        "pre",   // target element(s) to be updated with server response
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
                        var queryString = $.param(formData);
                        // To access the DOM element for the form do this:
                        // var formElement = jqForm[0];
                        //alert('About to submit: \n\n' + queryString);
                        return true;
                    }

                    // post-submit callback
                    function showResponse(responseText, statusText)  {
                        //alert('status: ' + statusText + '\n\nresponseText: \n' + responseText +
                        //    '\n\nThe output div should have already been updated with the responseText.');
                    }
            });

        </script>
    </head>
    <body>

<pre>
<?php
                    // read cache
                    print_r($b);
?>
</pre>

    <button id="add" value="cmd">新增 自訂命令</button>
    <button id="add" value="rss">新增 RSS訂閱</button>
    <button id="add" value="you">新增 youtube訂閱</button>
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
                        <OPTION VALUE ='我愛黑澀會+2009-06-17&aq=f'>我愛黑澀會</OPTION>
                        <OPTION VALUE ='模范棒棒堂+2009-06-17&aq=f'>模范棒棒堂</OPTION>
                        <OPTION VALUE ='康熙來了+2009-06-17&aq=f'>康熙來了</OPTION>
                        <OPTION VALUE ='2009-06-06+我猜我猜我猜猜猜&aq=f'>我猜我猜我猜猜猜</OPTION>
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
