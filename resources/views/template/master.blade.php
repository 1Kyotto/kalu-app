<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kalú</title>
        @vite('resources/css/app.css')
    </head>
    <body class="grid grid-cols-12 min-h-dvh font-montserrat overflow-hidden">
        <aside class="col-span-2 flex flex-col justify-between px-3 py-6 bg-black text-white">
            <div class="flex flex-col justify-between">
                <div class="flex flex-col items-center gap-2">
                    <img src="{{ asset('images/simple_logo.png') }}" alt="logo" class="w-14 h-14 fill-current">
                    <img src="{{ asset('images/logo_slogan.png') }}" alt="logo" class="w-26 h-12 fill-current">
                </div>

                <div class="flex flex-col mt-8 px-4">
                    <ul class="flex flex-col gap-6">
                        <li>
                            <a href="{{ route('empleados.info') }}">Empleados</a>
                        </li>
                        <li>
                            <a href="{{ route('contrato.info') }}">Contrato</a>
                        </li>
                        <li>
                            <a href="{{ route('liquidaciones.info') }}">Liquidaciones</a>
                        </li>
                        <li>
                            <a href="{{ route('solicitudes.info') }}">Solicitudes</a>
                        </li>
                        <li>
                            <a href="{{ route('beneficios.info') }}">Beneficios</a>
                        </li>
                        <li>
                            <a href="{{ route('politicas.info') }}">Políticas y Reglamento</a>
                        </li>
                        <li>
                            <a href="{{ route('leykarin.info') }}">Ley Karin</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="flex gap-3 items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="rounded-full border w-8 h-8">
                        <img src="{{ asset('images/avatar.svg') }}" alt="Avatar profile" class="w-full h-full text-white">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold">Nombre</span>
                        <span class="text-sm">Cargo</span>
                    </div>
                </div>
                <div class="cursor-pointer">
                    <img src="{{ asset('images/options.svg') }}" alt="Avatar profile" class="w-4 h-4">         
                </div>
            </div>
        </aside>
        <main class="col-span-10 py-2 px-6 bg-white">
            @yield('content')
        </main>
    </body>
</html>