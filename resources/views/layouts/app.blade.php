<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
    @vite(['resources/js/app.js','resources/css/app.css'])
</head>
<body class="antialiased bg-gray-100">
<div class="container mx-auto px-8">
    <x-navbar></x-navbar>
    <main>
        {{ $slot }}
    </main>

</div>

@stack('script')

</body>
</html>
