function updateStatus(permissionId, status) {
    // Crear el token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Realizar la petición AJAX
    fetch(`/permissions/${permissionId}/update-status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Recargar la página para mostrar los cambios
            window.location.reload();
        } else {
            alert('Error al actualizar el estado de la solicitud');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar el estado de la solicitud');
    });
}

function showDetails(permission) {
    const modal = document.getElementById('detailsModal');
    const startDate = new Date(permission.start_date).toLocaleDateString();
    const endDate = new Date(permission.end_date).toLocaleDateString();
    const requestDate = new Date(permission.request_date).toLocaleDateString();
    
    // Actualizar el contenido del modal
    document.getElementById('permissionType').textContent = getPermissionTypeText(permission.permission_type);
    document.getElementById('permissionDates').textContent = `${startDate} - ${endDate}`;
    document.getElementById('permissionRequestDate').textContent = requestDate;
    document.getElementById('permissionStatus').textContent = getStatusText(permission.status);
    document.getElementById('permissionReason').textContent = permission.reason;
    
    // Mostrar el modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function hideDetails() {
    const modal = document.getElementById('detailsModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
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
