<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div id="app">
        <div class="container is-fluid">
            <div class="tabs">
                <ul>
                    <li><router-link to="/" exact>Alle data</router-link></li>
                    <li><router-link to="data">Alle data</router-link></li>
                </ul>
            </div>
        </div>
        <section class="section">
            <div class="container is-fluid">
                <router-view></router-view>
            </div>
        </section>

            <flash message="{{ session('flash') }}"></flash>
        </div>
    </div>

    @include('scripts')
</body>
</html>
