@extends('template.master')

@section('content')
<div class="w-full h-full">
    <div class="py-6 px-3 border-b border-[#444852]">
        <h3 class="text-xl">Configuración de Cuenta</h3>
    </div>
    <div class="pb-4 pt-8 px-3 border-b border-[#444852] text-white">
        <h3 class="text-md pb-3">Información Personal</h3>
        <form action="{{ route('user.profile.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')
        
            <div class="flex items-center justify-between gap-10">
                <div class="mb-4 w-1/2">
                    <label for="name" class="block font-bold mb-2">Nombre Completo</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $employee->user ? $employee->user->name : '') }}" class="w-full border border-gray-300 bg-[#07060B] p-2 rounded focus:outline-none focus:border-blue-500">
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