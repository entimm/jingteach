<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>教育研究调查</title>

    <link rel="stylesheet" href="/weui.css"/>
    <link rel="stylesheet" href="/play.css?v2"/>
    <style type="text/css">
        .weui-btn-area .weui-btn {
            margin-bottom: 40px;
        }
        .score {
            font-size: 1.8em;
        }
    </style>
</head>
<body ontouchstart>
<div class="container" id="container">
    <div class="page msg_success js_show">
        <div class="weui-msg">
            <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
            <div class="weui-msg__text-area">
                <h2 class="weui-msg__title">GAME OVER</h2>
                <p class="weui-msg__desc">感谢您的配合</p>
            </div>
            @if($stat)
            <div class="weui-msg__text-area">
                <h2 class="weui-msg__title score">得分: {{$score}}</h2>
            </div>
            @endif
            @if(session('student_no'))
                <div class="weui-msg__text-area">
                    <p class="weui-msg__desc"><i>{{$name}}</i> 已经完成 <i>{{$times}}次</i> 测试</p>
                    <p class="weui-msg__desc" style="font-size: 0.9em">一定要记得将该界面进行屏幕截图哦</p>
                </div>
            @endif
            <div class="weui-msg__opr-area">
                <p class="weui-btn-area">
                    @if(session('student_no'))
                        <a href="/" class="weui-btn weui-btn_primary">再玩一次</a>
                    @else
                        <a href="/quick_play" class="weui-btn weui-btn_primary">再玩一次</a>
                    @endif

                    <a href="/quit" class="weui-btn weui-btn_default">退出</a>
                    @if (session('admin'))
                        <a href="/result" class="weui-btn weui-btn_default">查看结果</a>
                    @endif
                </p>
            </div>

            <div class="weui-msg__extra-area">
                <div class="weui-footer">
                    <p class="weui-footer__text">Copyright © 2019-2020</p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
