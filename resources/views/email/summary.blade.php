<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Preferred location - Summary</title>
</head>
<body>
    <div>
        <h2>{{ $name }}</h2>
        <h2>Here is your weekly weather summary for {{ $location }}</h2>
        <h3>{{ $forecast['summary'] }}</h3>
    </div>
</body>
</html>