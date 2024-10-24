<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <title>Home</title>
</head>

<body class=" bg-gray-200 max-h-full m-0 p-0">
    <!--
  This example requires updating your template:

  ```
  <html class="h-full bg-gray-100">
  <body class="h-full">
  ```
-->
    <div class="max-h-full bg-gray-200">
        <x-navbar></x-navbar>

        <x-header>{{ $title }}</x-header>
        <main>
            <div class="mx-auto max-w-5xl px-2 py-4 sm:px-4 lg:px-6">
                {{ $slot }}
            </div>
        </main>
    </div>

</body>

</html>
