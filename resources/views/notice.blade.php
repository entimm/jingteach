<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>家长或者老师须知</title>

    <!-- 引入 WeUI -->
    <link rel="stylesheet" href="/weui.css"/>
    <link href="https://cdn.bootcdn.net/ajax/libs/select2/4.0.9/css/select2.css" rel="stylesheet">
    <style>
        .weui-media-box__desc {
            color: rgba(0, 0, 0, 0.8);
        }
        .weui-form__opr-area {
            margin-top: 20px;
        }
    </style>
</head>
<body ontouchstart>
<div class="container" id="container">
    <div class="page">
        <div class="weui-form">
            <div class="weui-form__text-area">
                <h2 class="weui-form__title">家长或者老师须知</h2>
            </div>
            <div class="weui-panel weui-panel_access">
                <div class="weui-panel__bd">
                    <div class="weui-media-box weui-media-box_text">
                        <p class="weui-media-box__desc">1.本测试测学生的专注力耐力，时间需要大概20-30分钟不等</p>
                    </div>
                </div>
                <div class="weui-panel__bd">
                    <div class="weui-media-box weui-media-box_text">
                        <p class="weui-media-box__desc">2.请认真作答，注意力越集中，时间越短。</p>
                    </div>
                </div>
                <div class="weui-panel__bd">
                    <div class="weui-media-box weui-media-box_text">
                        <p class="weui-media-box__desc">3.保持中途不要来电话，来信息，不要退出。建议让手机处于wifi和飞行状态。</p>
                    </div>
                </div>
                <div class="weui-panel__bd">
                    <div class="weui-media-box weui-media-box_text">
                        <p class="weui-media-box__desc">4.读懂按确定键进入正式测验。</p>
                    </div>
                </div>
            </div>

            <div class="weui-form__opr-area">
                <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips">确定</a>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
    $(function () {
        $('#showTooltips').on('click', function () {
            window.location.href = '/play';
        });
    });
</script>
</body>
</html>
