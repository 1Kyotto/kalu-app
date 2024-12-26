@extends('template.master')

@section('content')
<div class="w-full p-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold">Nueva Solicitud</h2>
    </div>

    <div class="bg-[#07060B] rounded-lg p-6">
        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="permission_type" class="block mb-2">Tipo de Solicitud</label>
                <select name="permission_type" id="permission_type" 
                    class="w-full bg-[#181C23] rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff66c4]">
                    <option value="vacations">Vacaciones</option>
                    <option value="illness">Enfermedad</option>
                    <option value="personal">Personal</option>
                </select>
                @error('permission_type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="start_date" class="block mb-2">Fecha de Inicio</label>
                    <input type="date" name="start_date" id="start_date" 
                        class="w-full bg-[#181C23] rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff66c4]">
                    @error('start_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_date" class="block mb-2">Fecha de Fin</label>
                    <input type="date" name="end_date" id="end_date" 
                        class="w-full bg-[#181C23] rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff66c4]">
                    @error('end_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="reason" class="block mb-2">Motivo</label>
                <textarea name="reason" id="reason" rows="4" 
                    class="w-full bg-[#181C23] rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff66c4]"
                    placeholder="Describe el motivo de tu solicitud..."></textarea>
                @error('reason')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('permissions.index') }}" 
                    class="px-4 py-2 rounded bg-gray-700 hover:bg-gray-600 transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                    class="px-4 py-2 rounded bg-[#ff66c4] hover:bg-[#ff4db8] transition-colors">
                    Crear Solicitud
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
