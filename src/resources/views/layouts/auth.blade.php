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

    <header class="auth-header">
        <div class="auth-header-inner">
            <img class="auth-logo" src="{{ asset('images/logo.png') }}" alt="COACHTECH">
        </div>
    </header>

    <main class="auth-main">
        @yield('content')
    </main>

</body>
</html>