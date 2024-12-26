@extends('template.master')

@section('content')
<div class="w-full h-full">
    @if(session('success'))
    <div class="bg-green-500 text-white px-6 py-4 rounded-lg mb-6 flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    @endif

    @if(session('temporary_password'))
    <div class="bg-blue-500 text-white px-6 py-4 rounded-lg mb-6 flex items-center justify-between">
        <div>
            <p class="font-bold">¡Importante! Guarde esta información</p>
            <p>Contraseña temporal del nuevo empleado: <span class="font-mono bg-blue-600 px-2 py-1 rounded">{{ session('temporary_password') }}</span></p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold mb-6">Empleados</h2>
        <a href="{{ route('empleados.create') }}" 
            class="px-4 py-2 rounded bg-[#ff66c4] hover:bg-[#ff4db8] transition-colors">
            Añadir Empleado
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-6">
        @foreach($employees as $employee)
        <div 
            class="bg-[#07060B] rounded-lg p-6 hover:bg-gray-900 transition-colors" 
            data-employee-id="{{ $employee->id }}" 
            data-has-contract="{{ $employee->contract ? 'true' : 'false' }}"
        >
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-semibold">{{ $employee->user->name }}</h3>
                    <p class="text-gray-400 text-sm">{{ $employee->position->name }}</p>
                </div>
                <select 
                    class="bg-[#07060B] border border-gray-600 text-white rounded px-2 py-1 text-sm"
                    onchange="updateStatus(this.value, {{ $employee->id }})"
                >
                    <option value="activo" {{ $employee->status === 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ $employee->status === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="space-y-2 text-sm">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-gray-300">{{ $employee->user->rut }}</span>
                </div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="text-gray-300">{{ $employee->user->email }}</span>
                </div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span class="text-gray-300">{{ $employee->user->cellphone }}</span>
                </div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-gray-300">{{ $employee->entry_date }}</span>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-700 space-y-2">
                <div class="flex gap-2">
                    <button 
                        onclick="openUploadModal({{ $employee->id }})"
                        class="flex-1 bg-[#ff66c4] flex justify-center text-white px-3 py-2 rounded-lg hover:bg-[#e450ab] text-sm items-center"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Subir Contrato
                    </button>
                    @if(!$employee->user->hasRole('Administrativo'))
                    <button 
                        onclick="showUploadPayrollModal({{ $employee->id }})"
                        class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm flex items-center justify-center"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Subir Liquidación
                    </button>
                    @endif
                </div>
                <div class="flex justify-end">
                    <button 
                        onclick="confirmDelete({{ $employee->id }}, '{{ $employee->user->name }}')"
                        class="text-red-500 hover:text-red-700 p-2 hover:bg-red-500/10 rounded-lg transition-colors"
                        title="Eliminar empleado"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal para subir contrato -->
<div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-[#181C23] p-6 rounded-lg w-96">
        <h3 class="text-lg font-bold mb-4">Subir Contrato</h3>
        <div id="warningMessage" class="hidden mb-4 p-3 bg-yellow-900/50 border border-yellow-600 rounded-lg text-yellow-200 text-sm">
            Este empleado ya tiene un contrato. Si continúas, el contrato actual será reemplazado por el nuevo.
        </div>
        <form id="uploadForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="employeeId" name="employee_id">
            <div class="mb-4">
                <input type="file" name="contract" accept=".pdf" id="contractFile" class="hidden">
                <label for="contractFile" class="cursor-pointer bg-[#07060B] text-white px-4 py-2 rounded border border-gray-600 hover:bg-gray-900 inline-block">
                    <span id="fileNameDisplay">Seleccionar archivo PDF</span>
                </label>
                <p class="text-sm text-gray-400 mt-1" id="selectedFileName"></p>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeUploadModal()" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-[#ff66c4] text-white rounded hover:bg-[#e450ab]">
                    Subir
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para subir liquidación -->
<div id="uploadPayrollModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-[#07060B] rounded-lg p-6 max-w-lg w-full mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Subir Liquidación</h3>
            <button onclick="closePayrollModal()" class="text-gray-400 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="payrollForm" enctype="multipart/form-data" onsubmit="uploadPayroll(event)">
            <input type="hidden" id="employeeIdPayroll" name="employee_id">
            
            <div class="mb-4">
                <label for="period" class="block mb-2">Período</label>
                <input type="month" id="period" name="period" required
                    value="{{ now()->format('Y-m') }}"
                    class="w-full bg-[#181C23] rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff66c4]">
                <span class="text-xs text-gray-400 mt-1">Formato: {{ now()->format('m/Y') }}</span>
            </div>

            <div class="mb-4">
                <label for="amount" class="block mb-2">Monto</label>
                <input type="number" id="amount" name="amount" step="0.01" required
                    class="w-full bg-[#181C23] rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff66c4]">
            </div>

            <div class="mb-6">
                <label for="payroll_file" class="block mb-2">Archivo PDF</label>
                <div class="flex items-center gap-2">
                    <label for="payroll_file" class="cursor-pointer bg-[#181C23] rounded px-4 py-2 hover:bg-gray-700 transition-colors">
                        Seleccionar archivo
                    </label>
                    <span id="payrollFileName" class="text-gray-400">Ningún archivo seleccionado</span>
                </div>
                <input type="file" id="payroll_file" name="payroll_file" accept=".pdf" required
                    class="hidden">
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" onclick="closePayrollModal()"
                    class="px-4 py-2 rounded bg-gray-700 hover:bg-gray-600 transition-colors">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-4 py-2 rounded bg-[#ff66c4] hover:bg-[#ff4db8] transition-colors">
                    Subir
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-[#181C23] p-6 rounded-lg w-96">
        <h3 class="text-lg font-bold mb-4">Confirmar Eliminación</h3>
        <p class="mb-4 text-gray-300">¿Estás seguro de que deseas eliminar al empleado <span id="employeeNameToDelete" class="font-semibold"></span>?</p>
        <p class="mb-6 text-sm text-red-400">Esta acción no se puede deshacer.</p>
        <div class="flex justify-end gap-2">
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                Cancelar
            </button>
            <button 
                onclick="deleteEmployee()"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
            >
                Eliminar
            </button>
        </div>
    </div>
</div>

<script>
    // Agregar el evento para mostrar el nombre del archivo seleccionado
    document.getElementById('contractFile').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        document.getElementById('selectedFileName').textContent = fileName || '';
    });

    document.getElementById('payroll_file').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : 'Ningún archivo seleccionado';
        document.getElementById('payrollFileName').textContent = fileName;
    });

    function updateStatus(status, employeeId) {
        fetch(`/api/employees/${employeeId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Opcional: mostrar mensaje de éxito
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function openUploadModal(employeeId) {
        const employee = document.querySelector(`[data-employee-id="${employeeId}"]`);
        const hasContract = employee.getAttribute('data-has-contract') === 'true';
        
        document.getElementById('employeeId').value = employeeId;
        document.getElementById('warningMessage').classList.toggle('hidden', !hasContract);
        document.getElementById('uploadModal').classList.remove('hidden');
        document.getElementById('uploadModal').classList.add('flex');
    }

    function closeUploadModal() {
        document.getElementById('uploadModal').classList.add('hidden');
        document.getElementById('uploadModal').classList.remove('flex');
    }

    function showUploadPayrollModal(employeeId) {
        document.getElementById('employeeIdPayroll').value = employeeId;
        const modal = document.getElementById('uploadPayrollModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closePayrollModal() {
        const modal = document.getElementById('uploadPayrollModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.getElementById('payrollForm').reset();
    }

    let employeeIdToDelete = null;

    function confirmDelete(id, name) {
        employeeIdToDelete = id;
        document.getElementById('employeeNameToDelete').textContent = name;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
        employeeIdToDelete = null;
    }

    function deleteEmployee() {
        if (!employeeIdToDelete) return;

        fetch(`/api/employees/${employeeIdToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                console.error('Error al eliminar:', data);
                alert('Error al eliminar el empleado');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar el empleado');
        })
        .finally(() => {
            closeDeleteModal();
        });
    }

    function uploadPayroll(event) {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        
        fetch('{{ route("payrolls.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closePayrollModal();
                // Mostrar mensaje de éxito
                const successDiv = document.createElement('div');
                successDiv.className = 'bg-green-500 text-white px-6 py-4 rounded-lg mb-6 flex items-center justify-between';
                successDiv.innerHTML = `
                    <span>${data.message}</span>
                    <button onclick="this.parentElement.remove()" class="text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                `;
                document.querySelector('.w-full.h-full').insertBefore(successDiv, document.querySelector('.w-full.h-full').firstChild);
            } else {
                // Mostrar mensaje de error
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al subir la liquidación');
        });
    }

    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('{{ route("empleados.contract.upload") }}', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                closeUploadModal();
                // Mostrar mensaje de éxito
                const successDiv = document.createElement('div');
                successDiv.className = 'bg-green-500 text-white px-6 py-4 rounded-lg mb-6 flex items-center justify-between';
                successDiv.innerHTML = `
                    <span>${data.message || 'Contrato subido exitosamente'}</span>
                    <button onclick="this.parentElement.remove()" class="text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                `;
                document.querySelector('.w-full.h-full').insertBefore(successDiv, document.querySelector('.w-full.h-full').firstChild);
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            let errorMessage = 'Error al subir el contrato. Por favor, inténtalo de nuevo.';
            if (error.message) {
                errorMessage = error.message;
            } else if (error.errors) {
                errorMessage = Object.values(error.errors).flat().join('\n');
            }
            alert(errorMessage);
        });
    });

    // Cerrar modal al hacer clic fuera
    document.getElementById('uploadPayrollModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePayrollModal();
        }
    });
</script>

@endsection