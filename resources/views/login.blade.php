<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>教育研究调查</title>

    <!-- 引入 WeUI -->
    <link rel="stylesheet" href="weui.css"/>
</head>
<body ontouchstart>
<div class="container" id="container">
    <div class="page">
        <div class="weui-form">
            <div class="weui-form__text-area">
                <h2 class="weui-form__title">基本信息登记</h2>
            </div>
            <div class="weui-form__control-area">
                <div class="weui-cells__group weui-cells__group_form">
                    <div class="weui-cells weui-cells_form">
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">学校</label></div>
                            <div class="weui-cell__bd">
                                <input id="input_school" class="weui-input" placeholder="填写你的学校"/>
                            </div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">班级</label></div>
                            <div class="weui-cell__bd">
                                <input id="input_class" class="weui-input" placeholder="填写你的班级"/>
                            </div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">学号</label></div>
                            <div class="weui-cell__bd">
                                <input id="input_student_no" class="weui-input" placeholder="填写你的学号"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="weui-form__opr-area">
                <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips">确定</a>
            </div>
        </div>
        <div id="js_toast_success" style="display: none;">
            <div class="weui-mask_transparent"></div>
            <div class="weui-toast">
                <i class="weui-icon-success-no-circle weui-icon_toast"></i>
                <p class="weui-toast__content">已完成</p>
            </div>
        </div>

        <div id="js_toast_fail" style="display: none;">
            <div class="weui-mask_transparent"></div>
            <div class="weui-toast">
                <p class="weui-toast__content">请求失败</p>
            </div>
        </div>
    </div>
</div>

<script src="zepto.min.js"></script>
<script type="text/javascript">
    $(function () {
        var $toastSuccess = $('#js_toast_success');
        var $toastFail = $('#js_toast_fail');

        $('#showTooltips').on('click', function () {
            var $school = $('#input_school').val();
            var $class = $('#input_class').val();
            var $studentNo = $('#input_student_no').val();

            if ($(this).hasClass('weui-btn_disabled')) return;
            $(this).addClass('weui-btn_disabled');
            var that = this;
            setTimeout(function () {
                $(that).removeClass('weui-btn_disabled');
            }, 2000);
            $.post('/login', {school:$school, class:$class, student_no:$studentNo}, function (response) {
                if (response.code) {
                    $toastFail.fadeIn(100);
                    setTimeout(function () {
                        $toastFail.fadeOut(100);
                    }, 2000);
                    return;
                }

                window.location.href = '/';
            });
        });
    });
</script>
</body>
</html>
