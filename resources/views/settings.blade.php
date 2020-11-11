<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>结果</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <br>
    <div class="card" style="width: 22rem;">
      <div class="card-header">
        设置信息
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">步骤2停留时间(t_guide,默认100毫秒): {{$settings['t_guide']}}</li>
        <li class="list-group-item">步骤3停留时间(t_interval,默认400毫秒): {{$settings['t_interval']}}</li>
        <li class="list-group-item">步骤4停留时间(t_rt_max,默认1700毫秒): {{$settings['t_rt_max']}}</li>
        <li class="list-group-item">组数(1组40个回合): {{$settings['n']}}</li>
        <li class="list-group-item">步骤4、5的总时间: {{$settings['t_total']}}</li>
        <li class="list-group-item">是否重试: {{$settings['retry'] ? '是' : '否'}}</li>
        {{--<li class="list-group-item">回合数(默认为 组数 * 40): {{$settings['nn']}}</li>--}}
      </ul>
    </div>
</div>
</body>
</html>
