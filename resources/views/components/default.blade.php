<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket master</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
<!-- Barra di navigazione sticky -->
<nav class="navbar py-2 sticky top-0 z-50 bg-white shadow-md">
    <div class="container mx-auto">
        <div class="navbar-content">
            <div class="navbar-item">
                <!-- Logo -->
                <a href="#" class="navbar-logo">Il Tuo Logo</a>
            </div>
        </div>
    </div>
</nav>

<div class="flex flex-col h-screen">
    <!-- Contenuto principale -->
    <main class="flex-1 flex">
        <!-- Sidebar -->
        <aside class="w-48 bg-white shadow-md p-4">
            <div class="menu">
                <p class="menu-label">Menu</p>
                <ul class="menu-list">
                    <li><a href="#" class="block p-2 hover:bg-gray-100">Voce 1</a></li>
                    <li><a href="#" class="block p-2 hover:bg-gray-100">Voce 2</a></li>
                    <li><a href="#" class="block p-2 hover:bg-gray-100">Voce 3</a></li>
                    <!-- Aggiungi ulteriori voci di menu qui -->
                </ul>
            </div>
        </aside>

        <!-- Contenuto principale -->
        <section class="flex-1 bg-white shadow-md p-4">
            <!-- Contenuto della pagina -->
            {{ $slot }}
        </section>
    </main>
</div>

<!-- Footer sticky -->
<footer class="footer py-2 sticky bottom-0 z-50 bg-white shadow-md">
    <div class="container mx-auto">
        <div class="footer-content">
            <div class="footer-item">
                <!-- Testo del footer -->
                <p class="text-center text-gray-500">© {{ now()->format('Y') }} - Musa formazione</p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
