@extends('template.master')

@section('content')
<div class="w-full h-full flex items-start flex-col p-8">
    <div class="flex w-full justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Solicitudes</h2>
        @if(!$isAdmin)
        <a href="{{ route('permissions.create') }}" 
            class="px-4 py-2 rounded bg-[#ff66c4] hover:bg-[#ff4db8] transition-colors">
            Nueva Solicitud
        </a>
        @endif
    </div>

    @if(session('success'))
    <div class="bg-green-500 text-white px-6 py-4 rounded-lg mb-6 flex items-center justify-between w-full">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-500 text-white px-6 py-4 rounded-lg mb-6 flex items-center justify-between w-full">
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    @endif

    <div class="bg-[#07060B] w-full rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-[#181C23] text-left">
                        @if($isAdmin)
                        <th class="px-6 py-3">Empleado</th>
                        @endif
                        <th class="px-6 py-3">Tipo</th>
                        <th class="px-6 py-3">Fecha Solicitud</th>
                        <th class="px-6 py-3">Estado</th>
                        <th class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach($permissions as $permission)
                    <tr class="hover:bg-gray-900">
                        @if($isAdmin)
                        <td class="px-6 py-4">{{ $permission->employee->user->name }}</td>
                        @endif
                        <td class="px-6 py-4">
                            @switch($permission->permission_type)
                                @case('vacations')
                                    <span class="bg-blue-500 text-white px-2 py-1 rounded text-sm">Vacaciones</span>
                                    @break
                                @case('illness')
                                    <span class="bg-yellow-500 text-white px-2 py-1 rounded text-sm">Enfermedad</span>
                                    @break
                                @case('personal')
                                    <span class="bg-purple-500 text-white px-2 py-1 rounded text-sm">Personal</span>
                                    @break
                            @endswitch
                        </td>
                        <td class="px-6 py-4">{{ Carbon\Carbon::parse($permission->request_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            @switch($permission->status)
                                @case('approved')
                                    <span class="bg-green-500 text-white px-2 py-1 rounded text-sm">Aprobada</span>
                                    @break
                                @case('pending')
                                    <span class="bg-yellow-500 text-white px-2 py-1 rounded text-sm">Pendiente</span>
                                    @break
                                @case('denied')
                                    <span class="bg-red-500 text-white px-2 py-1 rounded text-sm">Rechazada</span>
                                    @break
                            @endswitch
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <button type="button" 
                                    onclick="showDetailsModal({
                                        id: {{ $permission->id }},
                                        permission_type: '{{ $permission->permission_type }}',
                                        start_date: '{{ $permission->start_date }}',
                                        end_date: '{{ $permission->end_date }}',
                                        request_date: '{{ $permission->request_date }}',
                                        status: '{{ $permission->status }}',
                                        reason: '{{ str_replace("'", "\\'", $permission->reason) }}',
                                        @if($isAdmin)
                                        employee: {
                                            user: {
                                                name: '{{ $permission->employee->user->name }}'
                                            }
                                        },
                                        @endif
                                    })" 
                                    class="bg-gray-600 hover:bg-gray-500 text-white px-3 py-1 rounded text-sm">
                                    Detalles
                                </button>
                                @if($isAdmin && $permission->status === 'pending')
                                    <form action="{{ route('permissions.update-status', $permission->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                            Aprobar
                                        </button>
                                    </form>
                                    <form action="{{ route('permissions.update-status', $permission->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="denied">
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                            Rechazar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de Detalles -->
<div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display: none;">
    <div class="bg-[#07060B] rounded-lg p-6 max-w-lg w-full mx-4" onclick="event.stopPropagation();">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Detalles de la Solicitud</h3>
            <button type="button" onclick="hideDetailsModal()" class="text-gray-400 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="space-y-4">
            @if($isAdmin)
            <div>
                <span class="text-gray-400">Empleado:</span>
                <p id="permissionEmployee" class="font-medium"></p>
            </div>
            @endif
            <div>
                <span class="text-gray-400">Tipo de Permiso:</span>
                <p id="permissionType" class="font-medium"></p>
            </div>
            <div>
                <span class="text-gray-400">Fechas:</span>
                <p id="permissionDates" class="font-medium"></p>
            </div>
            <div>
                <span class="text-gray-400">Fecha de Solicitud:</span>
                <p id="permissionRequestDate" class="font-medium"></p>
            </div>
            <div>
                <span class="text-gray-400">Estado:</span>
                <p id="permissionStatus" class="font-medium"></p>
            </div>
            <div>
                <span class="text-gray-400">Motivo:</span>
                <p id="permissionReason" class="font-medium whitespace-pre-wrap"></p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Asegurarnos de que el código se ejecuta después de que el DOM está listo
document.addEventListener('DOMContentLoaded', function() {
    // Cerrar el modal cuando se hace clic fuera de él
    const modal = document.getElementById('detailsModal');
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            hideDetailsModal();
        }
    });

    // Cerrar el modal con la tecla Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            hideDetailsModal();
        }
    });
});

function showDetailsModal(permission) {
    console.log('Mostrando detalles de la solicitud:', permission);
    const modal = document.getElementById('detailsModal');
    
    try {
        // Formatear fechas
        const startDate = new Date(permission.start_date).toLocaleDateString('es-CL');
        const endDate = new Date(permission.end_date).toLocaleDateString('es-CL');
        const requestDate = new Date(permission.request_date).toLocaleDateString('es-CL');
        
        // Actualizar el contenido del modal
        if (document.getElementById('permissionEmployee')) {
            document.getElementById('permissionEmployee').textContent = permission.employee?.user?.name || 'No disponible';
        }
        
        document.getElementById('permissionType').textContent = getPermissionTypeText(permission.permission_type);
        document.getElementById('permissionDates').textContent = `${startDate} - ${endDate}`;
        document.getElementById('permissionRequestDate').textContent = requestDate;
        document.getElementById('permissionStatus').textContent = getStatusText(permission.status);
        document.getElementById('permissionReason').textContent = permission.reason || 'No se proporcionó motivo';
        
        // Mostrar el modal
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
    } catch (error) {
        console.error('Error al mostrar los detalles:', error);
        console.error('Datos recibidos:', permission);
    }
}

function hideDetailsModal() {
    const modal = document.getElementById('detailsModal');
    modal.style.display = 'none';
    modal.classList.add('hidden');
}

function getPermissionTypeText(type) {
    const types = {
        'vacations': 'Vacaciones',
        'illness': 'Enfermedad',
        'personal': 'Personal'
    };
    return types[type] || type;
}

function getStatusText(status) {
    const statuses = {
        'pending': 'Pendiente',
        'approved': 'Aprobada',
        'denied': 'Rechazada'
    };
    return statuses[status] || status;
}
</script>
@endsection
