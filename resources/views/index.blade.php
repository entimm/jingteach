<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>教育研究调查</title>

    <link rel="stylesheet" href="/weui.css"/>
    <link rel="stylesheet" href="/play.css?v3"/>
</head>
<body ontouchstart>
<div class="container" id="container">
    <div class="page__hd">
        <div id="play_desc" class="page__desc"></div>
    </div>
    <div id="list" class="center-in-center">
        <div class="picture" id="countdown"></div>
        <div class="picture" id="pos1"></div>
        <div class="picture" id="pos2"></div>
        <div class="picture" id="pos3"></div>
    </div>
    <div class="page flex">
        <div class="page__ft j_bottom">
            <div class="weui-flex">
                <div class="weui-flex__item">
                    <a href="javascript:;" id="left" class="weui-btn weui-btn_primary weui-btn_disabled">⬅⬅⬅</a>
                </div>
                <div class="weui-flex__item">
                    <a href="javascript:;" id="right" class="weui-btn weui-btn_primary weui-btn_disabled">⮕⮕⮕</a>
                </div>
            </div>
        </div>
    </div>
</div>

<audio id="ok-tip">
    <source = src="/ok.mp3" type="audio/mp3">
</audio>
<audio id="bad-tip">
    <source = src="/bad.mp3" type="audio/mp3">
</audio>

<script src="/zepto.min.js"></script>
<script type="text/javascript">
    $(function () {
        countdown(3);
        // getData();
    });

    Date.prototype.Format = function (fmt) {
        var o = {
            "m+": this.getMonth() + 1, //月份
            "d+": this.getDate(), //日
            "h+": this.getHours(), //小时
            "i+": this.getMinutes(), //分
            "s+": this.getSeconds(), //秒
            "q+": Math.floor((this.getMonth() + 3) / 3), //季度
            "S": this.getMilliseconds() //毫秒
        };
        if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length))
        for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)))
        return fmt;
    }

    function countdown($count) {
        if ($count <= 0) {
            $('#countdown').html('GO');
            $('#countdown').animate({
              opacity: 0,
              scale:1.3,
            }, 500, 'ease-out');
            setTimeout(function () {
                $('#countdown').html('');
                getData();
            }, 1000);
            return;
        }
        $('#countdown').html($count);
        $count--;
        setTimeout(function () {
            countdown($count);
        }, 1000);
    }

    var $currentRound = 1;
    var $currentStep = 0;
    var $d1Time = 0;
    var $RTTime = 0;
    var $RTStart = 0;
    var $RTEnd = 0;
    var $startTime = 0;

    function getData() {
        $.get('/data', function (response) {
            var $data = response;
            start($data);
        });
    }

    function start($data) {
        var $roundList = $data.roundList;
        var $guideList = $data.guideList;
        var $goalList = $data.goalList;
        var $correctMap = $data.correctMap;

        var $submitData = [];

        var $audioOk = document.getElementById("ok-tip");
        var $audioBad = document.getElementById("bad-tip");

        play();

        $('#left').click(function(event) {
            if (4 != $currentStep) return;
            // console.log('你点击了⮕,$currentRound='+$currentRound+'$currentStep='+$currentStep);
            action($currentRound, 1, $RTTime);
        });
        $('#right').click(function(event) {
            if (4 != $currentStep) return;
            // console.log('你点击了⬅,$currentRound='+$currentRound+'$currentStep='+$currentStep);
            action($currentRound, 2, $RTTime);
        });

        function enabled() {
            $('#left').removeClass('weui-btn_disabled');
            $('#right').removeClass('weui-btn_disabled');
        }

        function disable() {
            $('#left').addClass('weui-btn_disabled');
            $('#right').addClass('weui-btn_disabled');
        }

        function action($currentRound, $answer, $costTime) {
            $RTEnd = Date.now();
            $RTTime = $RTEnd - $RTStart;

            disable();
            play();

            $round = $roundList[$currentRound - 1];
            if ($answer == $correctMap[$goalList[$round.goalId][1]]) {
                // console.log('对！');
                $audioOk.play();
            } else {
                // console.log('错！');
                $audioBad.play();
            }
            $submitData.push({
                'round': $currentRound,
                'guideId': $round.guideId,
                'goalId': $round.goalId,
                'answer': $answer,
                'cost_time': $costTime,
            });
        }

        function end() {
            // console.log('submit', $submitData);
            $.ajax({
                type: 'POST',
                url: '/submit',
                data: JSON.stringify({ data: $submitData }),
                contentType: 'application/json',
                success: function(data) {
                    setTimeout(function () {
                        window.location.href = '/success';
                    }, 1000);
                }
            });
        }

        function play() {
            $currentStep++;
            if ($currentStep > 5) {
                $currentStep = 1;
                $currentRound++;
            }

            $timeOut = 0;
            var $round = $roundList[$currentRound - 1];
            switch ($currentStep) {
                case 1:
                    $timeOut = step1();
                    break;
                case 2:
                    $timeOut = step2($guideList[$round.guideId]);
                    break;
                case 3:
                    $timeOut = step3();
                    break;
                case 4:
                    // console.log($round);
                    $RTStart = Date.now();
                    $RTEnd = 0;
                    $timeOut = step4($goalList[$round.goalId]);
                    enabled();

                    break;
                case 5:
                    $timeOut = step5();
                    break;
            }
            if ($currentRound > $roundList.length) {
                end();
                return;
            }

            $('#play_desc').html('步骤:' + $currentStep + ' 回合:'+ $currentRound + ' 停留毫秒:' + ($timeOut ? $timeOut : '--'));

            if (4 == $currentStep) {
                setTimeout(function() {
                    if (!$RTEnd) {
                        action($currentRound, 0, 0);
                    }
                }, 1700);
            } else {
                setTimeout(play, $timeOut);
            }
        }

        function step1() {
            // console.log('time:'+new Date().Format('hh:ii:ss')+' gap:'+(Date.now()-$startTime)+' round:'+$currentRound);
            $startTime = Date.now();

            $('#pos1').html('&nbsp');
            $('#pos2').html('✚');
            $('#pos3').html('&nbsp');

            $d1Time = getRandomInt(400, 1600);

            return $d1Time;
        }

        function step2($guide) {
            $('#pos1').html(drawGuide($guide[0]));
            $('#pos2').html(drawGuide($guide[1]));
            $('#pos3').html(drawGuide($guide[2]));

            return 100;
        }

        function step3() {
            $('#pos1').html('&nbsp');
            $('#pos2').html('✚');
            $('#pos3').html('&nbsp');

            return 400;
        }

        function step4($goalInfo) {
            var $pos = $goalInfo[0];
            var $result = drawGoal($goalInfo[1]);

            if ($pos) {
                $('#pos1').html('&nbsp');
                $('#pos2').html('✚');
                $('#pos3').html($result);
            } else {
                $('#pos1').html($result);
                $('#pos2').html('✚');
                $('#pos3').html('&nbsp');
            }

            return 0;
        }

        function step5() {
            $('#pos1').html('&nbsp');
            $('#pos2').html('✚');
            $('#pos3').html('&nbsp');

            // console.log('t1='+$d1Time+' t2='+$RTTime+' t3='+(3500 - $RTTime - $d1Time - 500));

            // 3500 - $RTTime - $d1Time - 500
            return 3500 - (Date.now() - $startTime);
        }

        function drawGuide($guideId) {
            var $result = '&nbsp';
            switch ($guideId) {
                case 1:
                    $result = '✚';
                    break;
                case 2:
                    $result = '✻';
                    break;
            }

            return $result;
        }

        function drawGoal($goal) {
            var $result = '';
            switch ($goal) {
                case 1:
                    $result = '⮕⮕⮕⮕⮕';//➡▶◀←→➨
                    break;
                case 2:
                    $result = '⬅⬅⬅⬅⬅';
                    break;
                case 3:
                    $result = '⮕⮕⬅⮕⮕';
                    break;
                case 4:
                    $result = '⬅⬅⮕⬅⬅';
                    break;
            }

            return $result;
        }

        function getRandomInt(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);

            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
    }
</script>
</body>
</html>
