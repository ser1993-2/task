<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">Выход</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>


<div id="app">
</div>

<script src="{{mix('js/user.js')}}"></script>
</body>
</html>
