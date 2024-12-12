<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('images/simple_logo.png') }}">

        <title>Kalú</title>
        @vite('resources/css/app.css')
    </head>
    <body class="grid grid-cols-12 min-h-dvh font-montserrat bg-[#07060B] text-white overflow-hidden">
        <aside class="col-span-3 flex flex-col justify-between py-6 text-white">
            <div class="flex flex-col h-[550px] justify-between">
                <div class="flex gap-3 px-8 items-center justify-between">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('user.profile', ['id' => auth()->user()->employed->id ?? 0]) }}" class="rounded-full border w-8 h-8">
                            <img src="{{ asset('images/avatar.svg') }}" alt="Avatar profile" class="w-full h-full text-white">
                        </a>
                        <div class="flex flex-col">
                            <span class="font-bold">{{ auth()->check() ? auth()->user()->name : 'Invitado' }}</span>
                            <span class="text-sm">{{ auth()->check() && auth()->user()->employed && auth()->user()->employed->position ? auth()->user()->employed->position->name : 'Sin cargo' }}</span>
                        </div>
                    </div>
                    <div class="relative" onclick="toggleDropdown(); highlightSettingsIcon()">
                        <!-- Ícono de menú (SVG) -->
                        <div class="cursor-pointer bg-[#181C23] h-8 w-8 rounded-xl flex items-center justify-center settings-icon-container">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none">
                                <path d="M15.5 12C15.5 13.933 13.933 15.5 12 15.5C10.067 15.5 8.5 13.933 8.5 12C8.5 10.067 10.067 8.5 12 8.5C13.933 8.5 15.5 10.067 15.5 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M21.011 14.0965C21.5329 13.9558 21.7939 13.8854 21.8969 13.7508C22 13.6163 22 13.3998 22 12.9669V11.0332C22 10.6003 22 10.3838 21.8969 10.2493C21.7938 10.1147 21.5329 10.0443 21.011 9.90358C19.0606 9.37759 17.8399 7.33851 18.3433 5.40087C18.4817 4.86799 18.5509 4.60156 18.4848 4.44529C18.4187 4.28902 18.2291 4.18134 17.8497 3.96596L16.125 2.98673C15.7528 2.77539 15.5667 2.66972 15.3997 2.69222C15.2326 2.71472 15.0442 2.90273 14.6672 3.27873C13.208 4.73448 10.7936 4.73442 9.33434 3.27864C8.95743 2.90263 8.76898 2.71463 8.60193 2.69212C8.43489 2.66962 8.24877 2.77529 7.87653 2.98663L6.15184 3.96587C5.77253 4.18123 5.58287 4.28891 5.51678 4.44515C5.45068 4.6014 5.51987 4.86787 5.65825 5.4008C6.16137 7.3385 4.93972 9.37763 2.98902 9.9036C2.46712 10.0443 2.20617 10.1147 2.10308 10.2492C2 10.3838 2 10.6003 2 11.0332V12.9669C2 13.3998 2 13.6163 2.10308 13.7508C2.20615 13.8854 2.46711 13.9558 2.98902 14.0965C4.9394 14.6225 6.16008 16.6616 5.65672 18.5992C5.51829 19.1321 5.44907 19.3985 5.51516 19.5548C5.58126 19.7111 5.77092 19.8188 6.15025 20.0341L7.87495 21.0134C8.24721 21.2247 8.43334 21.3304 8.6004 21.3079C8.76746 21.2854 8.95588 21.0973 9.33271 20.7213C10.7927 19.2644 13.2088 19.2643 14.6689 20.7212C15.0457 21.0973 15.2341 21.2853 15.4012 21.3078C15.5682 21.3303 15.7544 21.2246 16.1266 21.0133L17.8513 20.034C18.2307 19.8187 18.4204 19.711 18.4864 19.5547C18.5525 19.3984 18.4833 19.132 18.3448 18.5991C17.8412 16.6616 19.0609 14.6226 21.011 14.0965Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                        </div>
                    
                        <!-- Dropdown -->
                        <div id="dropdownMenu" class="hidden absolute left-[-160px] mt-2 w-48 bg-[#181C23] rounded-lg border border-[#ff66c4] shadow-lg text-white z-10">
                            <ul class="py-1">
                                <li>
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-2 py-2 hover:bg-gray-600 hover:rounded-md">Cerrar Sesión</a>
                                </li>
                            </ul>
                        </div>
                    
                        <!-- Formulario de logout -->
                        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                    
                    
                </div>

                <div class="flex flex-col mt-8">
                    <ul class="flex flex-col w-full">
                        @if(auth()->check() && (auth()->user()->hasRole('Admin Nivel 1') || auth()->user()->hasRole('Administrativo')))
                        <a href="{{ route('empleados.info') }}" class="w-full flex items-center gap-4 px-8 py-5 {{ request()->routeIs('empleados.info') ? 'bg-[#181C23] border-l-2 border-[#ff66c4] pl-12' : 'border-b border-[#181C23]' }}">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center bg-[#717171]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 15L12 16.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M3 11L3.15288 13.8633C3.31714 17.477 3.39927 19.2839 4.55885 20.3919C5.71843 21.5 7.52716 21.5 11.1446 21.5H12.8554C16.4728 21.5 18.2816 21.5 19.4412 20.3919C20.6007 19.2839 20.6829 17.477 20.8471 13.8633L21 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M2.84718 10.4431C4.54648 13.6744 8.3792 15 12 15C15.6208 15 19.4535 13.6744 21.1528 10.4431C21.964 8.90056 21.3498 6 19.352 6H4.648C2.65023 6 2.03603 8.90056 2.84718 10.4431Z" stroke="currentColor" stroke-width="1.5" />
                                    <path d="M15.9999 6L15.9116 5.69094C15.4716 4.15089 15.2516 3.38087 14.7278 2.94043C14.204 2.5 13.5083 2.5 12.1168 2.5H11.8829C10.4915 2.5 9.79575 2.5 9.27198 2.94043C8.7482 3.38087 8.52819 4.15089 8.08818 5.69094L7.99988 6" stroke="currentColor" stroke-width="1.5" />
                                </svg>
                            </div>
                            Empleados
                        </a>
                        @endif
                        @if(auth()->check() && auth()->user()->hasRole('Empleado'))
                        <a href="{{ route('liquidaciones.info') }}" class="w-full flex items-center gap-4 px-8 py-5 {{ request()->routeIs('liquidaciones.info') ? 'bg-[#181C23] border-l-2 border-[#ff66c4] pl-12' : 'border-b border-[#181C23]' }}">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center bg-[#717171]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none">
                                    <path d="M20.016 2C18.9026 2 18 4.68629 18 8H20.016C20.9876 8 21.4734 8 21.7741 7.66455C22.0749 7.32909 22.0225 6.88733 21.9178 6.00381C21.6414 3.67143 20.8943 2 20.016 2Z" stroke="currentColor" stroke-width="1.5" />
                                    <path d="M18 8.05426V18.6458C18 20.1575 18 20.9133 17.538 21.2108C16.7831 21.6971 15.6161 20.6774 15.0291 20.3073C14.5441 20.0014 14.3017 19.8485 14.0325 19.8397C13.7417 19.8301 13.4949 19.9768 12.9709 20.3073L11.06 21.5124C10.5445 21.8374 10.2868 22 10 22C9.71321 22 9.45546 21.8374 8.94 21.5124L7.02913 20.3073C6.54415 20.0014 6.30166 19.8485 6.03253 19.8397C5.74172 19.8301 5.49493 19.9768 4.97087 20.3073C4.38395 20.6774 3.21687 21.6971 2.46195 21.2108C2 20.9133 2 20.1575 2 18.6458V8.05426C2 5.20025 2 3.77325 2.87868 2.88663C3.75736 2 5.17157 2 8 2H20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M6 6H14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M8 10H6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M12.5 10.875C11.6716 10.875 11 11.4626 11 12.1875C11 12.9124 11.6716 13.5 12.5 13.5C13.3284 13.5 14 14.0876 14 14.8125C14 15.5374 13.3284 16.125 12.5 16.125M12.5 10.875C13.1531 10.875 13.7087 11.2402 13.9146 11.75M12.5 10.875V10M12.5 16.125C11.8469 16.125 11.2913 15.7598 11.0854 15.25M12.5 16.125V17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </div>
                            Liquidaciones
                        </a>
                        @endif
                        <a href="{{ route('permissions.index') }}" class="w-full flex items-center gap-4 px-8 py-5 {{ request()->routeIs('permissions.index') ? 'bg-[#181C23] border-l-2 border-[#ff66c4] pl-12' : 'border-b border-[#181C23]' }}">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center bg-[#717171]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none">
                                    <path d="M17 15.8462C17 14.8266 17.8954 14 19 14C20.1046 14 21 14.8266 21 15.8462C21 16.2137 20.8837 16.5561 20.6831 16.8438C20.0854 17.7012 19 18.5189 19 19.5385V20M18.9902 22H18.9992" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M16 22H6.59087C5.04549 22 3.81631 21.248 2.71266 20.1966C0.453365 18.0441 4.1628 16.324 5.57757 15.4816C8.12805 13.9629 11.2057 13.6118 14 14.4281" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M16.5 6.5C16.5 8.98528 14.4853 11 12 11C9.51472 11 7.5 8.98528 7.5 6.5C7.5 4.01472 9.51472 2 12 2C14.4853 2 16.5 4.01472 16.5 6.5Z" stroke="currentColor" stroke-width="1.5" />
                                </svg>
                            </div>
                            Solicitudes
                        </a>
                        <a href="{{ route('beneficios.info') }}" class="w-full flex items-center gap-4 px-8 py-5 {{ request()->routeIs('beneficios.info') ? 'bg-[#181C23] border-l-2 border-[#ff66c4] pl-12' : 'border-b border-[#181C23]' }}">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center bg-[#717171]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 11V15C4 18.2998 4 19.9497 5.02513 20.9749C6.05025 22 7.70017 22 11 22H13C16.2998 22 17.9497 22 18.9749 20.9749C20 19.9497 20 18.2998 20 15V11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M3 9C3 8.25231 3 7.87846 3.20096 7.6C3.33261 7.41758 3.52197 7.26609 3.75 7.16077C4.09808 7 4.56538 7 5.5 7H18.5C19.4346 7 19.9019 7 20.25 7.16077C20.478 7.26609 20.6674 7.41758 20.799 7.6C21 7.87846 21 8.25231 21 9C21 9.74769 21 10.1215 20.799 10.4C20.6674 10.5824 20.478 10.7339 20.25 10.8392C19.9019 11 19.4346 11 18.5 11H5.5C4.56538 11 4.09808 11 3.75 10.8392C3.52197 10.7339 3.33261 10.5824 3.20096 10.4C3 10.1215 3 9.74769 3 9Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                    <path d="M6 3.78571C6 2.79949 6.79949 2 7.78571 2H8.14286C10.2731 2 12 3.7269 12 5.85714V7H9.21429C7.43908 7 6 5.56091 6 3.78571Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                    <path d="M18 3.78571C18 2.79949 17.2005 2 16.2143 2H15.8571C13.7269 2 12 3.7269 12 5.85714V7H14.7857C16.5609 7 18 5.56091 18 3.78571Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                    <path d="M12 11L12 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            Beneficios
                        </a>
                        <a href="{{ route('politicas.info') }}" class="w-full flex items-center gap-4 px-8 py-5 {{ request()->routeIs('politicas.info') ? 'bg-[#181C23] border-l-2 border-[#ff66c4] pl-12' : 'border-b border-[#181C23]' }}">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center bg-[#717171]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none">
                                    <path d="M3 14V10C3 6.22876 3 4.34315 4.17157 3.17157C5.34315 2 7.22876 2 11 2H13C16.7712 2 18.6569 2 19.8284 3.17157C21 4.34315 21 6.22876 21 10V14C21 17.7712 21 19.6569 19.8284 20.8284C18.6569 22 16.7712 22 13 22H11C7.22876 22 5.34315 22 4.17157 20.8284C3 19.6569 3 17.7712 3 14Z" stroke="currentColor" stroke-width="1.5" />
                                    <path d="M11.3333 10.6667C12.3883 11.7216 13.7778 12.7937 13.7778 12.7937L15.6825 10.8889C15.6825 10.8889 14.6105 9.49939 13.5556 8.44444C12.5006 7.3895 11.1111 6.31746 11.1111 6.31746L9.20635 8.22222C9.20635 8.22222 10.2784 9.61172 11.3333 10.6667ZM11.3333 10.6667L8 14M16 10.5714L13.4603 13.1111M11.4286 6L8.88889 8.53968" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M8 18H16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </div>
                            Políticas y Reglamento
                        </a>
                        <a href="{{ route('leykarin.info') }}" class="w-full flex items-center gap-4 px-8 py-5 {{ request()->routeIs('leykarin.info') ? 'bg-[#181C23] border-l-2 border-[#ff66c4] pl-12' : 'border-b border-[#181C23]' }}">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center bg-[#717171]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none">
                                    <path d="M22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12Z" stroke="currentColor" stroke-width="1.5" />
                                    <path d="M12.2422 17V12C12.2422 11.5286 12.2422 11.2929 12.0957 11.1464C11.9493 11 11.7136 11 11.2422 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M11.992 8H12.001" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            Ley Karin
                        </a>
                    </ul>
                </div>

                <div class="flex flex-col items-center gap-2">
                    <img src="{{ asset('images/simple_logo.png') }}" alt="logo" class="w-14 h-14 fill-current">
                </div>
            </div>
        </aside>
        <main class="col-span-9 flex items-center justify-center py-2 px-6 rounded-l-xl bg-[#181C23] overflow-y-auto max-h-[100vh]">
            @yield('content')
        </main>

        <script>
            function toggleDropdown() {
                var dropdown = document.getElementById('dropdownMenu');
                dropdown.classList.toggle('hidden');
            }

            function highlightSettingsIcon() {
                var container = document.querySelector('.settings-icon-container');
                container.classList.toggle('bg-[#ff66c4]');
            }

            // Cerrar el dropdown cuando se hace clic fuera de él
            document.addEventListener('click', function(event) {
                var dropdown = document.getElementById('dropdownMenu');
                var settingsIcon = document.querySelector('.settings-icon-container');
                
                if (!event.target.closest('.settings-icon-container') && !dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                    settingsIcon.classList.remove('bg-[#ff66c4]');
                }
            });
        </script>

        <!-- Scripts adicionales -->
        @yield('scripts')
    </body>
</html>