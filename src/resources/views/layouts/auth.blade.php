<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @yield('css')
</head>

<body class="auth-body">

    <header class="header">
        <div class="header-inner">
            <a href="/">
                <img class="header-logo" src="{{ asset('images/logo.png') }}" alt="COACHTECH">
            </a>
        </div>
    </header>

    <main class="auth-main">
        @yield('content')
    </main>

</body>
</html>