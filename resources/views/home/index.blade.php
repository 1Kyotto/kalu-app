@extends('template.master')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[80vh] p-8">
    <div class="flex flex-col items-center max-w-2xl text-center space-y-8">
        <img src="{{ asset('images/kalu-logo.png') }}" alt="Kalu Logo" class="w-64 h-auto mb-6">
        
        <h1 class="text-4xl font-bold text-white mb-4">
            ¡Bienvenido a <span class="text-[#ff66c4]">Kalu</span>!
        </h1>
        
        <p class="text-xl text-gray-300 leading-relaxed">
            Tu plataforma integral para la gestión de recursos humanos. Aquí podrás gestionar contratos, 
            liquidaciones y mantenerte informado sobre tus beneficios y políticas de la empresa.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 w-full">
            <div class="bg-[#07060B] p-6 rounded-lg border border-gray-800 hover:border-[#ff66c4] transition-colors">
                <h3 class="text-lg font-semibold text-[#ff66c4] mb-2">Gestión de Personal</h3>
                <p class="text-gray-400">Administra la información de tus empleados, contratos y documentación laboral de manera eficiente.</p>
            </div>
            <div class="bg-[#07060B] p-6 rounded-lg border border-gray-800 hover:border-[#ff66c4] transition-colors">
                <h3 class="text-lg font-semibold text-[#ff66c4] mb-2">Documentación</h3>
                <p class="text-gray-400">Accede y gestiona contratos, liquidaciones y otros documentos importantes de manera segura.</p>
            </div>
        </div>
    </div>
</div>
@endsection