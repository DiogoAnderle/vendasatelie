
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <div>
        <img src="{{ $message->embed(public_path('images\66848acf74df5.png')) }}" width="150px" alt="Logo">
        <p>Seu aplicativo Laravel já consegue enviar emails? 😉</p>
        <h3>Olá! Você recebeu uma mensagem de: {{$data['fromName']}}</h3>
        <p>{{$data['message']}}</p>
    </div>
</body>
</html>
