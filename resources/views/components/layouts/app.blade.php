<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket master</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-100">
<header class="bg-blue-500 py-4">
    <!-- Inserisci qui il contenuto del tuo header -->
    <div class="container mx-auto px-4 text-white">
        Ticket master
    </div>
</header>

<main class="container mx-auto py-8 h-full">
    <livewire:utils.toast />
    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-lg">
            {{ $slot ?? '' }}
        </div>
    </div>
</main>

<footer class="bg-blue-500 py-4 mt-8 sticky bottom-0">
    <!-- Inserisci qui il contenuto del tuo footer -->
    <div class="container mx-auto px-4 text-white">
        © {{ now()->format('Y') }} - Musa formazione
    </div>
</footer>
</body>

</html>
