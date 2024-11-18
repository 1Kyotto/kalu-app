<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Kalu</title>
        @vite('resources/css/app.css')
    </head>
    <body class="bg-[#111828] flex flex-col items-center justify-center w-screen h-screen text-white font-montserrat overflow-hidden">
        <div class="px-44 mb-6">
            <img src="{{ asset('images/simple_logo.png') }}" alt="logo" class="w-14 h-14 fill-current">
        </div>
        <form method="POST" action="{{ route('user.login') }}" class="bg-[#202938] rounded-lg px-8 py-3">
            @csrf
            <div class="flex flex-col gap-1 w-64 mb-3">
                <label for="rut">RUT</label>
                <input type="text" id="rut" name="rut" class="outline-none rounded py-1 bg-[#111828]">
            </div>

            <div class="flex flex-col gap-1 mb-3">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" class="outline-none rounded py-1 bg-[#111828]">
            </div>

            <div class="flex gap-2 mb-3">
                <input id="remember_me" type="checkbox" class="" name="remember">
                <label for="remember_me" class="text-gray-300">Recuérdame</label>
            </div>

            <div class="flex justify-center w-full mt-3">
                <button type="submit" class="bg-white text-black rounded-md py-1 px-5 uppercase">Iniciar Sesión</button>
            </div>
        </form>
    </body>
</html>