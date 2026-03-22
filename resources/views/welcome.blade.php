<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">¡Bienvenido a WebCur!</h1>
        <p id="countdown" class="text-lg text-gray-600 mb-8">Serás redirigido al login en 10 segundos...</p>
        <button id="loginButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Ir a Login
        </button>
    </div>
    <script>
        let countdown = 10;
        const countdownElement = document.getElementById('countdown');
        const loginButton = document.getElementById('loginButton');
        
        // Usar route() pero asegurarse de que genere la URL completa
        const loginUrl = '{{ route("login") }}';
        
        // Si route() genera una URL relativa, completarla
        const finalLoginUrl = loginUrl.startsWith('http') ? loginUrl : window.location.origin + '/' + loginUrl.replace(/^\//, '');
        
        console.log('URL generada por route():', loginUrl);
        console.log('URL final:', finalLoginUrl);

        function updateCountdown() {
            countdownElement.textContent = `Serás redirigido al login en ${countdown} segundos...`;
            if (countdown <= 0) {
                window.location.href = finalLoginUrl;
                return;
            }
            countdown--;
            setTimeout(updateCountdown, 1000);
        }

        loginButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = finalLoginUrl;
        });

        updateCountdown();
    </script>
</body>
</html>
