<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['title'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        h3 {
            color: #3498db;
            margin: 15px 0 5px;
        }
        .section {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 18px;
            color: #2c3e50;
        }
        .item {
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <h1>{{ $data['title'] }}</h1>

    <div class="section">
        <div class="section-title">Контактная информация</div>
        <div class="item"><strong>Телефон:</strong> {{ $data['phone'] }}</div>
        @if(isset($data['name']) && !empty($data['name']))
            <div class="item"><strong>Имя:</strong> {{ $data['name'] }}</div>
        @endif
    </div>

    @if(isset($data['body']) && count($data['body']) > 0)
        <div class="section">
            <div class="section-title">Детали заявки</div>
            @foreach($data['body'] as $item)
                <div class="item"><strong>{{ $item['title'] }}:</strong> {{ $item['value'] }}</div>
            @endforeach
        </div>
    @endif
</body>
</html>
