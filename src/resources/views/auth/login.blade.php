<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ログイン | Sauna_rally!</title>
    @vite(['resources/js/app.js'])
    <link href="{{ asset('css/admin/style.css') }}" rel="stylesheet" type="text/css">
</head>
<body class="p-login">

    <div class="p-login__inner">
        <div class="p-login__logo">
            <h1 class="p-login__logo-main">Sauna_rally!</h1>
        </div>

        <div class="p-login__card">

            @if (session('status'))
                <div class="status-message">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">メールアドレス<span class="c-badge--required">必須</span></label>
                    <input
                        id="email"
                        class="c-form__input @error('email') is-invalid @enderror"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="メールアドレスを入力してください">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="p-login__password-label-row">
                        <label for="password">パスワード<span class="c-badge--required">必須</span></label>
                    </div>
                    <input
                        id="password"
                        class="c-form__input @error('password') is-invalid @enderror"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="パスワードを入力してください">
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="remember_me" class="p-login__remember">
                        <input id="remember_me" type="checkbox" name="remember" class="p-login__remember-input">
                        ログイン状態を保持する
                    </label>
                </div>

                <div class="form-btn-group">
                    <input type="submit" class="tbl-btn edit c-btn--primary" value="ログイン">
                </div>
            </form>
        </div>

        <div class="p-login__footer">
            <a href="/" class="p-login__back-link">← サイトトップへ戻る</a>
        </div>
    </div>

</body>
</html>
