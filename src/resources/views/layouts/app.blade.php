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

<body>

<header class="header">
    <div class="header-inner">

        <a href="/">
            <img class="header-logo" src="{{ asset('images/logo.png') }}" alt="COACHTECH">
        </a>

        <div class="header-search">
            <form method="GET" action="/">
                <input
                    class="search-input"
                    type="text"
                    name="keyword"
                    placeholder="なにをお探しですか？"
                >
            </form>
        </div>

        <nav class="header-nav">

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link">
                        ログアウト
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-link">
                    ログイン
                </a>
            @endauth

            <a href="/mypage" class="nav-link">
                マイページ
            </a>

            <a href="/sell" class="sell-button">
                出品
            </a>

        </nav>

    </div>
</header>

<main>
    @yield('content')
</main>

</body>
</html>