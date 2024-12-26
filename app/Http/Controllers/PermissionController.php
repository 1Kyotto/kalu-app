<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Employed;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PermissionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $permissions = [];

        if ($user->hasRole('Admin Nivel 1') || $user->hasRole('Administrativo')) {
            // Administradores ven todas las solicitudes
            $permissions = Permission::with(['employee.user', 'employee.position'])->get();
        } else {
            // Empleados solo ven sus propias solicitudes
            $employee = Employed::where('users_id', $user->id)->first();
            if ($employee) {
                $permissions = Permission::with(['employee.user', 'employee.position'])
                    ->where('employees_id', $employee->id)
                    ->get();
            }
        }

        return view('permissions.index', [
            'permissions' => $permissions,
            'isAdmin' => $user->hasRole('Admin Nivel 1') || $user->hasRole('Administrativo')
        ]);
    }

    public function create()
    {
        $user = auth()->user();
        
        // Solo empleados pueden crear solicitudes
        if ($user->hasRole('Admin Nivel 1') || $user->hasRole('Administrativo')) {
            return redirect()->route('permissions.index')
                ->with('error', 'Los administradores no pueden crear solicitudes de permiso.');
        }

        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        // Verificar que no sea admin
        if ($user->hasRole('Admin Nivel 1') || $user->hasRole('Administrativo')) {
            return redirect()->route('permissions.index')
                ->with('error', 'Los administradores no pueden crear solicitudes de permiso.');
        }

        $messages = [
            'permission_type.required' => 'El tipo de permiso es obligatorio.',
            'permission_type.in' => 'El tipo de permiso seleccionado no es válido.',
            'start_date.required' => 'La fecha de inicio es obligatoria.',
            'start_date.date' => 'La fecha de inicio debe ser una fecha válida.',
            'start_date.after_or_equal' => 'La fecha de inicio debe ser igual o posterior a hoy.',
            'end_date.required' => 'La fecha de fin es obligatoria.',
            'end_date.date' => 'La fecha de fin debe ser una fecha válida.',
            'end_date.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'reason.required' => 'El motivo es obligatorio.',
            'reason.string' => 'El motivo debe ser texto.',
            'reason.max' => 'El motivo no puede exceder los 500 caracteres.'
        ];

        $request->validate([
            'permission_type' => 'required|in:vacations,illness,personal',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500'
        ], $messages);

        $employee = Employed::where('users_id', $user->id)->first();
        
        if (!$employee) {
            return redirect()->route('permissions.index')
                ->with('error', 'No se encontró el registro de empleado.');
        }

        Permission::create([
            'employees_id' => $employee->id,
            'permission_type' => $request->permission_type,
            'request_date' => Carbon::now(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending',
            'reason' => $request->reason
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'Solicitud de permiso creada exitosamente.');
    }

    public function updateStatus(Request $request, $id)
    {
        $user = auth()->user();
        
        // Solo admins pueden actualizar el estado
        if (!$user->hasRole('Admin Nivel 1') && !$user->hasRole('Administrativo')) {
            return redirect()->route('permissions.index')
                ->with('error', 'No tienes permisos para realizar esta acción.');
        }

        $messages = [
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido.'
        ];

        $request->validate([
            'status' => 'required|in:approved,denied'
        ], $messages);

        $permission = Permission::findOrFail($id);
        $permission->status = $request->status;
        $permission->save();

        $statusText = $request->status === 'approved' ? 'aprobada' : 'rechazada';
        return redirect()->route('permissions.index')
            ->with('success', "La solicitud ha sido {$statusText} exitosamente.");
    }
}
