<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Verhuur - @yield('title')</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<div id="app">

@yield('content')

</div>

<body>
{{--<script src="{{ mix('/js/manifest.js') }}"></script>--}}
{{--<script src="{{ mix('/js/vendor.js') }}"></script>--}}
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>