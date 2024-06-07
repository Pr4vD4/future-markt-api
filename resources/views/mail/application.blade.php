<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['title'] }}</title>
</head>
<body>
<h1>{{ $data['title'] }}</h1>

<h3>Номер телефона: {{ $data['phone'] }}</h3>

@if(isset($data['name']))
    <h3>Имя: {{ $data['name'] }}</h3>
@endif

@if(isset($data['body']))
    @foreach($data['body'] as $key => $value)
        <p>{{ $value->title }}: {{ $value->value }}</p>
    @endforeach
@endif

</body>
</html>