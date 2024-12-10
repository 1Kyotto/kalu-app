@extends('template.master')

@section('content')
<div class="w-full h-full">
    <div class="w-full p-8 pb-16 overflow-y-auto">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold mb-6">Añadir Nuevo Empleado</h2>

            @if(session('error'))
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-6 py-4 rounded-lg mb-6">
                {{ session('error') }}
            </div>
            @endif
    
            <form action="{{ route('empleados.store') }}" method="POST" class="bg-[#07060B] rounded-lg p-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Información Personal -->
                    <div class="col-span-2">
                        <h3 class="text-lg font-semibold mb-4 text-[#ff66c4]">Información Personal</h3>
                    </div>
    
                    <div class="flex flex-col gap-2">
                        <label for="name">Nombre Completo *</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="outline-none rounded py-2 px-3 bg-[#181C23] border @error('name') border-red-500 @else border-gray-700 @enderror focus:border-[#ff66c4] transition-colors">
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
    
                    <div class="flex flex-col gap-2">
                        <label for="rut">RUT * <span class="text-sm text-gray-400">(Formato: 12.345.678-9)</span></label>
                        <input type="text" 
                               id="rut" 
                               name="rut" 
                               value="{{ old('rut') }}"
                               placeholder="12.345.678-9"
                               class="outline-none rounded py-2 px-3 bg-[#181C23] border @error('rut') border-red-500 @else border-gray-700 @enderror focus:border-[#ff66c4] transition-colors">
                        @error('rut')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
    
                    <div class="flex flex-col gap-2">
                        <label for="email">Correo Electrónico *</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               class="outline-none rounded py-2 px-3 bg-[#181C23] border @error('email') border-red-500 @else border-gray-700 @enderror focus:border-[#ff66c4] transition-colors">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
    
                    <div class="flex flex-col gap-2">
                        <label for="cellphone">Teléfono</label>
                        <input type="text" 
                               id="cellphone" 
                               name="cellphone" 
                               value="{{ old('cellphone') }}"
                               class="outline-none rounded py-2 px-3 bg-[#181C23] border @error('cellphone') border-red-500 @else border-gray-700 @enderror focus:border-[#ff66c4] transition-colors">
                        @error('cellphone')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
    
                    <div class="flex flex-col gap-2 col-span-2">
                        <label for="address">Dirección *</label>
                        <input type="text" 
                               id="address" 
                               name="address" 
                               value="{{ old('address') }}"
                               class="outline-none rounded py-2 px-3 bg-[#181C23] border @error('address') border-red-500 @else border-gray-700 @enderror focus:border-[#ff66c4] transition-colors">
                        @error('address')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
    
                    <!-- Información Laboral -->
                    <div class="col-span-2 mt-6">
                        <h3 class="text-lg font-semibold mb-4 text-[#ff66c4]">Información Laboral</h3>
                    </div>
    
                    <div class="flex flex-col gap-2">
                        <label for="position">Cargo *</label>
                        <select id="position" 
                                name="position_id" 
                                class="outline-none rounded py-2 px-3 bg-[#181C23] border @error('position_id') border-red-500 @else border-gray-700 @enderror focus:border-[#ff66c4] transition-colors">
                            <option value="">Seleccionar cargo</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('position_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
    
                    <div class="flex flex-col gap-2">
                        <label for="entry_date">Fecha de Ingreso *</label>
                        <input type="date" 
                               id="entry_date" 
                               name="entry_date" 
                               value="{{ old('entry_date') }}"
                               class="outline-none rounded py-2 px-3 bg-[#181C23] border @error('entry_date') border-red-500 @else border-gray-700 @enderror focus:border-[#ff66c4] transition-colors">
                        @error('entry_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
    
                    <!-- Información de Acceso -->
                    <div class="col-span-2 mt-6">
                        <h3 class="text-lg font-semibold mb-4 text-[#ff66c4]">Información de Acceso</h3>
                        <p class="text-sm text-gray-400 mb-4">Se generará una contraseña provisional que el empleado deberá cambiar en su primer inicio de sesión.</p>
                    </div>
    
                    <div class="flex flex-col gap-2">
                        <label for="role">Rol de Usuario *</label>
                        <select id="role" 
                                name="role_id" 
                                class="outline-none rounded py-2 px-3 bg-[#181C23] border @error('role_id') border-red-500 @else border-gray-700 @enderror focus:border-[#ff66c4] transition-colors">
                            <option value="">Seleccionar rol</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
    
                    <div class="col-span-2 mt-6 flex justify-end gap-4">
                        <a href="{{ route('empleados.info') }}" 
                            class="px-4 py-2 rounded bg-gray-700 hover:bg-gray-600 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" 
                            class="px-4 py-2 rounded bg-[#ff66c4] hover:bg-[#ff4db8] transition-colors">
                            Guardar Empleado
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rutInput = document.getElementById('rut');
        
        rutInput.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Eliminar todo excepto números y 'k'
            value = value.replace(/[^\dkK]/g, '');
            
            // Convertir 'k' minúscula a mayúscula
            value = value.replace(/k/g, 'K');
            
            // Aplicar formato
            if (value.length > 1) {
                // Separar número y dígito verificador
                let numero = value.slice(0, -1);
                let dv = value.slice(-1);
                
                // Añadir puntos al número
                numero = numero.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                
                // Unir con el guión y el dígito verificador
                value = numero + '-' + dv;
            }
            
            e.target.value = value;
        });
    });
</script>
@endsection
