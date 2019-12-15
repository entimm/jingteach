<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>结果</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<div class="container-fluid">
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">回合</th>
            <th scope="col">线索</th>
            <th scope="col">目标</th>
            <th scope="col">解答</th>
            <th scope="col">反应</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($result['data'] as $element)
            <tr>
                <td>{{$element['round']}}</td>
                <td>{{$element['guideId']}}</td>
                <td>{{$element['goalId']}}</td>
                <td>{{$element['answer']}}</td>
                <td>{{$element['cost_time']}}</td>
            </tr>
        @endforeach

        </tbody>
    </table>

    <br>

    <ul class="list-unstyled">
        <li>学校：{{$result['school']}}</li>
        <li>班级：{{$result['class']}}</li>
        <li>学号：{{$result['student_no']}}</li>
        <li>ip: {{$result['ip']}}</li>
        <li>时间：{{$result['created_at']}}</li>
    </ul>
</div>
</body>
</html>
