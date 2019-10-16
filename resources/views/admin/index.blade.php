<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Laravel SPA</title>
    {{-- styles --}}
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<div id="app">
    <admin></admin>
</div>

{{--javascript--}}
<script src="/js/app.js"></script>
</body>
</html>