<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="{{ asset('images/simple_logo.png') }}">
        
        <title>Kalu - Iniciar Sesión</title>
        @viteReactRefresh
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#07060B] flex flex-col items-center justify-center w-screen h-screen text-white font-montserrat overflow-hidden">
        @if(session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 animate-fade-in-down">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <div class="text-center mb-8">
            <img src="{{ asset('images/simple_logo.png') }}" alt="Kalu Logo" class="w-20 h-20 mx-auto mb-4">
            <h1 class="text-2xl font-bold">Bienvenido a Kalu</h1>
            <p class="text-gray-400">Inicia sesión para continuar</p>
        </div>

        <form method="POST" action="{{ route('user.login') }}" class="bg-[#181C23] rounded-lg px-8 py-6 w-full max-w-md">
            @csrf

            @error('auth')
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                {{ $message }}
            </div>
            @enderror

            <div class="flex flex-col gap-1 mb-4">
                <label for="email" class="text-sm font-medium">Correo electrónico</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       class="outline-none rounded py-2 px-3 bg-[#07060B] border border-transparent focus:border-[#ff66c4] transition-colors @error('email') border-red-500 @enderror"
                       placeholder="ejemplo@correo.com">
                @error('email')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-1 mb-4">
                <label for="password" class="text-sm font-medium">Contraseña</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="outline-none rounded py-2 px-3 bg-[#07060B] border border-transparent focus:border-[#ff66c4] transition-colors @error('password') border-red-500 @enderror"
                       placeholder="••••••••">
                @error('password')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center gap-2 mb-6">
                <input id="remember" 
                       type="checkbox" 
                       name="remember" 
                       {{ old('remember') ? 'checked' : '' }}
                       class="w-4 h-4 text-[#ff66c4] bg-[#07060B] border-gray-600 rounded focus:ring-[#ff66c4]">
                <label for="remember" class="text-sm text-gray-300">Recordar mi sesión</label>
            </div>

            <div class="flex justify-center w-full">
                <button type="submit" 
                        class="w-full bg-[#ff66c4] hover:bg-[#ff66c4]/90 text-white font-medium rounded-md py-2 px-5 transition-colors">
                    Iniciar Sesión
                </button>
            </div>
        </form>
    </body>
</html>