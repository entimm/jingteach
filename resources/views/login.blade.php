<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>教育研究调查</title>

    <!-- 引入 WeUI -->
    <link rel="stylesheet" href="/weui.css"/>
    <link href="https://cdn.bootcdn.net/ajax/libs/select2/4.0.9/css/select2.css" rel="stylesheet">
    <style>
        .weui-cell_select .weui-cell__bd:after {
            width: 0;
            height: 0;
        }
    </style>
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
                    @if ($history_login)
                    <div class="weui-cell weui-cell_active weui-cell_select weui-cell_select-after">
                        <div class="weui-cell__hd">
                            <label for="" class="weui-label">快速登录</label>
                        </div>
                        <div class="weui-cell__bd">
                            <select style="width: 90%" id="quick-login">
                                <option value="">请选择账号</option>
                                @foreach ($history_login as $item)
                                    <option value="{{$loop->index}}">{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif

                    <div class="weui-cells weui-cells_form">
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
                            <div class="weui-cell__bd">
                                <input id="input_name" class="weui-input" placeholder="填写你的姓名"/>
                            </div>
                        </div>
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
                            <div class="weui-cell__hd"><label class="weui-label">年级</label></div>
                            <div class="weui-cell__bd">
                                <input id="input_grade" class="weui-input" placeholder="填写你的年级"/>
                            </div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">年龄</label></div>
                            <div class="weui-cell__bd">
                                <input id="input_age" class="weui-input" placeholder="填写你的年龄"/>
                            </div>
                        </div>
                        <div class="weui-cell weui-cell_active weui-cell_select weui-cell_select-after">
                            <div class="weui-cell__hd">
                                <label for="" class="weui-label">性别</label>
                            </div>
                            <div class="weui-cell__bd">
                                <select class="weui-select" name="input_sex">
                                    <option value="0">填写你的性别</option>
                                    <option value="1">男</option>
                                    <option value="2">女</option>
                                </select>
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
                <p class="weui-toast__content" id="toast_msg"></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/select2/4.0.9/js/i18n/zh-CN.js"></script>

<script type="text/javascript">

    $('#quick-login').select2({
      language: "zh-CN"
    });
    var historyLogin = {!!json_encode($history_login)!!}
    $(function () {
        var $toastSuccess = $('#js_toast_success');
        var $toastFail = $('#js_toast_fail');

        $('#showTooltips').on('click', function () {
            var $school = $('#input_school').val();
            var $class = $('#input_class').val();
            var $name = $('#input_name').val();
            var $grade = $('#input_grade').val();
            var $age = $('#input_age').val();
            var $sex = $('#input_sex').val();
            var $studentNo = $('#input_student_no').val();

            if ($(this).hasClass('weui-btn_disabled')) return;
            $(this).addClass('weui-btn_disabled');
            var that = this;
            setTimeout(function () {
                $(that).removeClass('weui-btn_disabled');
            }, 2000);
            $.post('/login', {school:$school, class:$class, name:$name, grade:$grade, age:$age, sex:$sex, student_no:$studentNo}, function (response) {
                if (response.code) {
                    $('#toast_msg').html(response.msg);
                    $toastFail.fadeIn(100);
                    setTimeout(function () {
                        $toastFail.fadeOut(100);
                    }, 2000);
                    return;
                }

                window.location.href = '/';
            });
        });
        $('#quick-login').on('change', function () {
            var index = $(this).val();
            if (index !== '') {
                var loginInfo = historyLogin[index];
                $('#input_school').val(loginInfo.school);
                $('#input_class').val(loginInfo.class);
                $('#input_name').val(loginInfo.name);
                $('#input_grade').val(loginInfo.grade);
                $('#input_age').val(loginInfo.age);
                $('#input_sex').val(loginInfo.sex);
                $('#input_student_no').val(loginInfo.student_no);
            }
            
        });
    });
</script>
</body>
</html>
