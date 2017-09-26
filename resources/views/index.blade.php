<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>{{ config('app.name') }}</title>

  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <link rel="stylesheet" href="{{ mix('css/bulma.css') }}">
</head>
<body>
  <div id="app">
    <router-link to="/" exact>Alle data</router-link>
    <router-link to="data">Alle data</router-link>
    <router-view></router-view>
  </div>
  <flash message="{{ session('flash') }}"></flash>
  @include('scripts')
</body>
</html>
