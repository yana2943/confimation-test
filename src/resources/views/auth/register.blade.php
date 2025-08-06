<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashionably Late</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__logo">
                <h1>FashionablyLate</h1>
            </div>
            <form class="form" action="/login" method="get">
                @csrf
                <button class="header-nav__button">login</button>
            </form>
        </div>
    </header>

    <main>
        <div class="register-form__content">
            <div class="register-form__heading">
                <h2 class="register-form__title">Register</h2>
            </div>
            <form class="form" action="/register" method="post">
            @csrf
                <div class="form__body">
                    <div class="form__group">
                        <div class="form__group-title">
                            <label class="form__label--item">お名前</label>
                        </div>
                        <div class="form__group-content">
                            <div class="form__input--text">
                                <input type="text" name="name" placeholder="例　山田　太郎" value="{{ old('name') }}" />
                            </div>
                            <div class="form__error">
                                @error('name')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__group-title">
                            <label class="form__label--item">メールアドレス</label>
                        </div>
                        <div class="form__group-content">
                            <div class="form__input--text">
                                <input type="email" name="email" placeholder="例　test@example.com" value="{{ old('email') }}" />
                            </div>
                            <div class="form__error">
                                @error('email')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__group-title">
                            <label class="form__label--item">パスワード</label>
                        </div>
                        <div class="form__group-content">
                            <div class="form__input--test">
                                <input type="password" name="password" placeholder="例　coachtech1106" />
                            </div>
                            <div class="form__error">
                                @error('password')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__button">
                        <button class="form__button-submit" type="submit">登録</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</body>

</html>