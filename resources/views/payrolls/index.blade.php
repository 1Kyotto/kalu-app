@extends('template.master')
@section('content')
<div class="w-full h-full flex items-start flex-col p-8">
    <div class="flex w-full justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">{{ $isAdmin ? 'Liquidaciones' : 'Mis Liquidaciones' }}</h2>
        @if($isAdmin)
        <button type="button" class="bg-[#ff66c4] hover:bg-[#ff66c4]/80 text-white px-4 py-2 rounded-lg flex items-center gap-2" data-bs-toggle="modal" data-bs-target="#uploadPayrollModal">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Subir Liquidación
        </button>
        @endif
    </div>

    <div class="bg-[#07060B] w-full rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-[#181C23] text-left">
                        @if($isAdmin)
                        <th class="px-6 py-3">Empleado</th>
                        @endif
                        <th class="px-6 py-3">Período</th>
                        <th class="px-6 py-3">Monto</th>
                        <th class="px-6 py-3">Fecha de Emisión</th>
                        <th class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($payrolls as $payroll)
                    <tr class="hover:bg-gray-900">
                        @if($isAdmin)
                        <td class="px-6 py-4">{{ $payroll->employee->user->name }} {{ $payroll->employee->user->lastname }}</td>
                        @endif
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($payroll->period)->format('m/Y') }}</td>
                        <td class="px-6 py-4">${{ number_format($payroll->amount, 2, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($payroll->issue_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('payrolls.download', $payroll->id) }}" 
                               class="bg-[#ff66c4] hover:bg-[#ff66c4]/80 text-white px-3 py-1 rounded text-sm inline-flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Descargar PDF
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $isAdmin ? 5 : 4 }}" class="px-6 py-4 text-center text-gray-500">
                            No hay liquidaciones disponibles
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($isAdmin)
<!-- Modal para subir liquidación -->
<div class="modal fade" id="uploadPayrollModal" tabindex="-1" aria-labelledby="uploadPayrollModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-[#07060B] text-white">
            <div class="modal-header border-b border-gray-800">
                <h5 class="modal-title" id="uploadPayrollModalLabel">Subir Liquidación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadPayrollForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="employee_id" class="form-label">Empleado</label>
                        <select class="form-select bg-[#181C23] text-white border-gray-700" id="employee_id" name="employee_id" required>
                            <option value="">Seleccionar empleado</option>
                            @foreach(App\Models\Employed::with(['user', 'user.roles'])->get() as $employee)
                                @if(!$employee->user->hasRole('Administrativo'))
                                <option value="{{ $employee->id }}">{{ $employee->user->name }} {{ $employee->user->lastname }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="period" class="form-label">Período</label>
                        <input type="month" class="form-control bg-[#181C23] text-white border-gray-700" id="period" name="period" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Monto</label>
                        <input type="number" step="0.01" class="form-control bg-[#181C23] text-white border-gray-700" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="payroll_file" class="form-label">Archivo de Liquidación (PDF)</label>
                        <input type="file" class="form-control bg-[#181C23] text-white border-gray-700" id="payroll_file" name="payroll_file" accept=".pdf" required>
                    </div>
                </div>
                <div class="modal-footer border-t border-gray-800">
                    <button type="button" class="btn btn-secondary bg-gray-600 hover:bg-gray-700" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary bg-[#ff66c4] hover:bg-[#ff66c4]/80">Subir</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
@if($isAdmin)
<script>
$(document).ready(function() {
    $('#uploadPayrollForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            url: '{{ route("payrolls.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message,
                        background: '#07060B',
                        color: '#fff'
                    }).then((result) => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                        background: '#07060B',
                        color: '#fff'
                    });
                }
            },
            error: function(xhr) {
                var errorMessage = 'Ha ocurrido un error al subir la liquidación.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).flat().join('\n');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                    background: '#07060B',
                    color: '#fff'
                });
            }
        });
    });
});
</script>
@endif
@endsection
