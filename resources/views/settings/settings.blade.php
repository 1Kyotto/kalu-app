@extends('template.master')

@section('content')
<div class="w-full h-full">
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500 text-green-500 px-6 py-4 rounded-lg mx-3 mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500/10 border border-red-500 text-red-500 px-6 py-4 rounded-lg mx-3 mt-3">
            {{ session('error') }}
        </div>
    @endif

    <div class="py-6 px-3 border-b border-[#444852]">
        <h3 class="text-xl">Configuración de Cuenta</h3>
    </div>

    <!-- Información Personal -->
    <div class="pb-4 pt-8 px-3 border-b border-[#444852] text-white">
        <h3 class="text-md pb-3">Información Personal</h3>
        <form action="{{ route('user.profile.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')
        
            <div class="flex items-center justify-between gap-10">
                <div class="mb-4 w-1/2">
                    <label for="name" class="block font-bold mb-2">Nombre Completo *</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $employee->user ? $employee->user->name : '') }}" 
                           class="w-full border @error('name') border-red-500 @else border-gray-300 @enderror bg-[#07060B] p-2 rounded focus:outline-none focus:border-[#ff66c4]">
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4 w-1/2">
                    <label for="position" class="block font-bold mb-2">Cargo</label>
                    <input type="text" id="position" value="{{ $employee->position->name }}" class="w-full border border-gray-300 p-2 rounded bg-[#07060B]" readonly>
                </div>
            </div>
        
            <div class="flex items-center justify-between gap-10">
                <div class="mb-4 w-1/2">
                    <label for="entry_date" class="block font-bold mb-2">Fecha de Ingreso</label>
                    <input type="date" id="entry_date" value="{{ old('entry_date', $employee->entry_date) }}" class="w-full border bg-[#07060B] p-2 rounded focus:outline-none focus:border-blue-500" readonly>
                </div>
            
                <div class="mb-4 w-1/2">
                    <label for="status" class="block font-bold mb-2">Estado</label>
                    <input type="text" id="status" value="{{ ucfirst($employee->status) }}" class="w-full border border-gray-300 p-2 rounded bg-[#07060B]" readonly>
                </div>
            </div>
        
            <div class="flex justify-end">
                <button type="submit" class="bg-[#ff66c4] text-white px-4 py-2 rounded hover:bg-[#e450ab] focus:outline-none">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>

    <!-- Cambio de Contraseña -->
    <div class="pb-4 pt-8 px-3 border-b border-[#444852] text-white">
        <h3 class="text-md pb-3">Cambiar Contraseña</h3>
        <form action="{{ route('user.password.update', $employee->id) }}" method="POST" class="max-w-lg">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="current_password" class="block text-sm font-medium text-gray-300">Contraseña Actual</label>
                <div class="relative">
                    <input type="password" name="current_password" id="current_password"
                           class="w-full border @error('current_password') border-red-500 @else border-gray-300 @enderror bg-[#07060B] p-2 rounded focus:outline-none focus:border-[#ff66c4]">
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200" onclick="togglePasswordVisibility('current_password', this)">
                        <!-- Ícono de ojo (visible) -->
                        <svg class="h-5 w-5 show-password" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <!-- Ícono de ojo tachado (oculto) -->
                        <svg class="h-5 w-5 hide-password hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                @error('current_password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-300">Nueva Contraseña</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                           class="w-full border @error('password') border-red-500 @else border-gray-300 @enderror bg-[#07060B] p-2 rounded focus:outline-none focus:border-[#ff66c4]">
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200" onclick="togglePasswordVisibility('password', this)">
                        <svg class="h-5 w-5 show-password" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="h-5 w-5 hide-password hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-400">
                    La contraseña debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas, números y símbolos.
                </p>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirmar Nueva Contraseña</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full border @error('password_confirmation') border-red-500 @else border-gray-300 @enderror bg-[#07060B] p-2 rounded focus:outline-none focus:border-[#ff66c4]">
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200" onclick="togglePasswordVisibility('password_confirmation', this)">
                        <svg class="h-5 w-5 show-password" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="h-5 w-5 hide-password hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-[#ff66c4] text-white px-4 py-2 rounded hover:bg-[#e450ab] focus:outline-none">
                    Cambiar Contraseña
                </button>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            const showIcon = button.querySelector('.show-password');
            const hideIcon = button.querySelector('.hide-password');
            
            if (input.type === 'password') {
                input.type = 'text';
                showIcon.classList.add('hidden');
                hideIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                showIcon.classList.remove('hidden');
                hideIcon.classList.add('hidden');
            }
        }
    </script>

    <!-- Contrato -->
    <div class="pb-4 pt-8 px-3 border-b border-[#444852] text-white flex flex-col items-end">
        <h3 class="text-md pb-3 font-bold">Descarga tu Contrato</h3>
        @if($employee->contract && $employee->contract->pdf_url)
            <a href="{{ route('contract.download', $employee->id) }}" class="ml-4 bg-[#ff66c4] text-white px-4 py-2 rounded-xl hover:bg-[#e450ab] focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-white w-16 h-16" viewBox="0 0 24 24" fill="none">
                    <path d="M2.5 12C2.5 7.52166 2.5 5.28249 3.89124 3.89124C5.28249 2.5 7.52166 2.5 12 2.5C16.4783 2.5 18.7175 2.5 20.1088 3.89124C21.5 5.28249 21.5 7.52166 21.5 12C21.5 16.4783 21.5 18.7175 20.1088 20.1088C18.7175 21.5 16.4783 21.5 12 21.5C7.52166 21.5 5.28249 21.5 3.89124 20.1088C2.5 18.7175 2.5 16.4783 2.5 12Z" stroke="currentColor" stroke-width="1.5" />
                    <path d="M12.0025 7.03857L12.0025 14.0889M12.0025 14.0889C12.3286 14.0933 12.6503 13.8691 12.8876 13.5956L14.4771 11.8129M12.0025 14.0889C11.6879 14.0847 11.3693 13.8618 11.1174 13.5955L9.51864 11.8129M7.98633 17.0386L15.9863 17.0386" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </a>
        @else
            <p class="ml-4 text-gray-400">No hay contrato disponible</p>
        @endif
    </div>
</div>
@endsection