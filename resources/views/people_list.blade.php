<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>

    <body>

        <div class="mt-3 ml-3">
            <h3>通所者一覧</h3>
        </div>

        <div class="d-flex justify-content-md-center">
            <p>─── <a data-toggle="collapse" href="#list-apple">アップル梅田</a> ───</p>
        </div>
        <div id="list-apple" class="collapse show">
            <div class="d-flex flex-column flex-md-row justify-content-md-between mb-3">
                <div class="flex-fill ml-3">
                    <p><input type="checkbox"> <a href="#">あああああ</a></p>
                    <p><input type="checkbox"> <a href="#">いいいいい</a></p>
                    <p><input type="checkbox"> <a href="#">ううううう</a></p>
                    <p><input type="checkbox"> <a href="#">えええええ</a></p>
                    <p><input type="checkbox"> <a href="#">おおおおお</a></p>
                </div>
                <div class="flex-fill ml-3">
                    <p><input type="checkbox"> <a href="#">かかかかか</a></p>
                    <p><input type="checkbox"> <a href="#">ききききき</a></p>
                    <p><input type="checkbox"> <a href="#">くくくくく</a></p>
                    <p><input type="checkbox"> <a href="#">けけけけけ</a></p>
                    <p><input type="checkbox"> <a href="#">こここここ</a></p>
                </div>
                <div class="flex-fill ml-3">
                    <p><input type="checkbox"> <a href="#">さささささ</a></p>
                    <p><input type="checkbox"> <a href="#">ししししし</a></p>
                    <p><input type="checkbox"> <a href="#">すすすすす</a></p>
                    <p><input type="checkbox"> <a href="#">せせせせせ</a></p>
                    <p><input type="checkbox"> <a href="#">そそそそそ</a></p>
                </div>
                <div class="flex-fill ml-3">
                    <p><input type="checkbox"> <a href="#">たたたたた</a></p>
                    <p><input type="checkbox"> <a href="#">ちちちちち</a></p>
                    <p><input type="checkbox"> <a href="#">つつつつつ</a></p>
                    <p><input type="checkbox"> <a href="#">ててててて</a></p>
                    <p><input type="checkbox"> <a href="#">ととととと</a></p>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-md-center">
            <p>─── <a data-toggle="collapse" href="#list-mint">ミント大阪</a> ───</p>
        </div>
        <div id="list-mint" class="collapse">
            <div class="d-flex flex-column flex-md-row justify-content-md-between mb-3">
                <div class="flex-fill ml-3">
                    <p><input type="checkbox"> <a href="#">あああああ</a></p>
                    <p><input type="checkbox"> <a href="#">いいいいい</a></p>
                    <p><input type="checkbox"> <a href="#">ううううう</a></p>
                    <p><input type="checkbox"> <a href="#">えええええ</a></p>
                    <p><input type="checkbox"> <a href="#">おおおおお</a></p>
                </div>
                <div class="flex-fill ml-3">
                    <p><input type="checkbox"> <a href="#">かかかかか</a></p>
                    <p><input type="checkbox"> <a href="#">ききききき</a></p>
                    <p><input type="checkbox"> <a href="#">くくくくく</a></p>
                    <p><input type="checkbox"> <a href="#">けけけけけ</a></p>
                    <p><input type="checkbox"> <a href="#">こここここ</a></p>
                </div>
                <div class="flex-fill ml-3">
                    <p><input type="checkbox"> <a href="#">さささささ</a></p>
                    <p><input type="checkbox"> <a href="#">ししししし</a></p>
                    <p><input type="checkbox"> <a href="#">すすすすす</a></p>
                    <p><input type="checkbox"> <a href="#">せせせせせ</a></p>
                    <p><input type="checkbox"> <a href="#">そそそそそ</a></p>
                </div>
                <div class="flex-fill ml-3">
                    <p><input type="checkbox"> <a href="#">たたたたた</a></p>
                    <p><input type="checkbox"> <a href="#">ちちちちち</a></p>
                    <p><input type="checkbox"> <a href="#">つつつつつ</a></p>
                    <p><input type="checkbox"> <a href="#">ててててて</a></p>
                    <p><input type="checkbox"> <a href="#">ととととと</a></p>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-md-center">
            <p>─── <a data-toggle="collapse" href="#list-maple">メープル関西</a> ───</p>
        </div>
        <div id="list-maple" class="collapse">
            <div class="d-flex flex-column flex-md-row justify-content-md-between mb-3">
                <div class="flex-fill ml-3">
                    <p><input type="checkbox"> <a href="#">あああああ</a></p>
                    <p><input type="checkbox"> <a href="#">いいいいい</a></p>
                    <p><input type="checkbox"> <a href="#">ううううう</a></p>
                    <p><input type="checkbox"> <a href="#">えええええ</a></p>
                    <p><input type="checkbox"> <a href="#">おおおおお</a></p>
                </div>
                <div class="flex-fill ml-3">
                    <p><input type="checkbox"> <a href="#">かかかかか</a></p>
                    <p><input type="checkbox"> <a href="#">ききききき</a></p>
                    <p><input type="checkbox"> <a href="#">くくくくく</a></p>
                    <p><input type="checkbox"> <a href="#">けけけけけ</a></p>
                    <p><input type="checkbox"> <a href="#">こここここ</a></p>
                </div>
                <div class="flex-fill ml-3">
                    <p><input type="checkbox"> <a href="#">さささささ</a></p>
                    <p><input type="checkbox"> <a href="#">ししししし</a></p>
                    <p><input type="checkbox"> <a href="#">すすすすす</a></p>
                    <p><input type="checkbox"> <a href="#">せせせせせ</a></p>
                    <p><input type="checkbox"> <a href="#">そそそそそ</a></p>
                </div>
                <div class="flex-fill ml-3">
                    <p><input type="checkbox"> <a href="#">たたたたた</a></p>
                    <p><input type="checkbox"> <a href="#">ちちちちち</a></p>
                    <p><input type="checkbox"> <a href="#">つつつつつ</a></p>
                    <p><input type="checkbox"> <a href="#">ててててて</a></p>
                    <p><input type="checkbox"> <a href="#">ととととと</a></p>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-md-center">
            <p>─── <a data-toggle="collapse" href="#list-experience">体験</a> ───</p>
        </div>
        <div id="list-experience" class="collapse">
            <div class="d-flex flex-column flex-md-row justify-content-md-between mb-3">
                <div class="flex-fill ml-3">
                    <p><input type="checkbox"> <a href="#">あああああ</a></p>
                    <p><input type="checkbox"> <a href="#">いいいいい</a></p>
                    <p><input type="checkbox"> <a href="#">ううううう</a></p>
                    <p><input type="checkbox"> <a href="#">えええええ</a></p>
                    <p><input type="checkbox"> <a href="#">おおおおお</a></p>
                </div>
                <div class="flex-fill ml-3">
                    <p><input type="checkbox"> <a href="#">かかかかか</a></p>
                    <p><input type="checkbox"> <a href="#">ききききき</a></p>
                    <p><input type="checkbox"> <a href="#">くくくくく</a></p>
                    <p><input type="checkbox"> <a href="#">けけけけけ</a></p>
                    <p><input type="checkbox"> <a href="#">こここここ</a></p>
                </div>
                <div class="flex-fill ml-3">
                    <p><input type="checkbox"> <a href="#">さささささ</a></p>
                    <p><input type="checkbox"> <a href="#">ししししし</a></p>
                    <p><input type="checkbox"> <a href="#">すすすすす</a></p>
                </div>
                </div>
            </div>
        </div>

        <div class="fixed-bottom d-flex justify-content-end bg-light pb-3">
            <input type="button" class="btn-primary mr-3" value="決定">
            <input type="button" class="btn-secondary mr-5" value="キャンセル">
        </div>

    </body>

</html>
