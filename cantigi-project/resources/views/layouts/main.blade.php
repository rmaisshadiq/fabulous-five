<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cantigi Tours</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="fontawesome-free-6.6.0-web/css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <style>
        body {
            font-family: 'roboto', sans-serif;
        }
    </style>
</head>

<body class="bg-white text-gray-800">
    @include('layouts/header')
    <main class="flex-shrink-0">
        <div class="container">
            @yield('content')
        </div>
    </main>
    @include('layouts/footer')
</body>

</html>