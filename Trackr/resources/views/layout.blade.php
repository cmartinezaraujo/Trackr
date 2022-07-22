<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/mystyle.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre.min.css">
    <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-exp.min.css">
    <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-icons.min.css">
    <title>Disease Tracker</title>
</head>

<body>

    @if($errors->any())
    <div class="toast toast-error">
        @foreach ($errors->all() as $error)
        <span>{{$error}}</span><br />
        @endforeach
    </div>
    @endif

    @if(session()->get('success'))
    <div class="toast toast-success">
        {{session()->get('success')}}
    </div>
    @endif

    @if(session()->get('error'))
    <div class="toast toast-error">
        {{session()->get('error')}}
    </div>
    @endif
    @yield('content')
</body>

</html>