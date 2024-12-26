<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PayrollController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $payrolls = [];

        if ($user->hasRole('Admin Nivel 1') || $user->hasRole('Administrativo')) {
            // Admin nivel 1 y Administrativo pueden ver todas las liquidaciones
            $payrolls = Payroll::with('employee.user')
                ->orderBy('period', 'desc')
                ->get();
        } else {
            // Empleados solo ven sus propias liquidaciones
            $employee = Employed::where('users_id', $user->id)->first();
            if ($employee) {
                $payrolls = Payroll::where('employees_id', $employee->id)
                    ->orderBy('period', 'desc')
                    ->get();
            }
        }

        return view('payrolls.index', [
            'payrolls' => $payrolls,
            'isAdmin' => $user->hasRole('Admin Nivel 1') || $user->hasRole('Administrativo')
        ]);
    }

    public function store(Request $request)
    {
        // Solo Admin Nivel 1 y Administrativo pueden subir liquidaciones
        if (!auth()->user()->hasRole('Admin Nivel 1') && !auth()->user()->hasRole('Administrativo')) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para realizar esta acción.'
            ], 403);
        }

        $messages = [
            'employee_id.required' => 'Debes seleccionar un empleado.',
            'employee_id.exists' => 'El empleado seleccionado no existe.',
            'payroll_file.required' => 'Debes seleccionar un archivo de liquidación.',
            'payroll_file.mimes' => 'El archivo debe ser un PDF.',
            'payroll_file.max' => 'El archivo no debe pesar más de 2MB.',
            'period.required' => 'El período es obligatorio.',
            'period.date_format' => 'El período debe tener el formato MM/YYYY.',
            'amount.required' => 'El monto es obligatorio.',
            'amount.numeric' => 'El monto debe ser un número.',
            'amount.min' => 'El monto debe ser mayor o igual a 0.',
        ];

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'payroll_file' => 'required|mimes:pdf|max:2048',
            'period' => 'required|date_format:Y-m',
            'amount' => 'required|numeric|min:0',
        ], $messages);

        // Verificar que el empleado no tenga rol Administrativo
        $employee = Employed::with('user.roles')->find($request->employee_id);
        if ($employee->user->hasRole('Administrativo')) {
            return response()->json([
                'success' => false,
                'message' => 'No se pueden subir liquidaciones para usuarios Administrativos.'
            ], 400);
        }

        if ($request->hasFile('payroll_file')) {
            $file = $request->file('payroll_file');
            $fileName = 'liquidacion_' . $request->employee_id . '_' . $request->period . '.pdf';
            $path = $file->storeAs('payrolls', $fileName, 'public');

            Payroll::create([
                'employees_id' => $request->employee_id,
                'file_url' => $path,
                'period' => $request->period,
                'amount' => $request->amount,
                'issue_date' => Carbon::now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Liquidación subida exitosamente.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Error al subir el archivo. Por favor, inténtalo de nuevo.'
        ], 400);
    }

    public function download($id)
    {
        $payroll = Payroll::findOrFail($id);
        $user = auth()->user();
        
        // Verificar permisos de descarga
        if ($user->hasRole('Admin Nivel 1') || $user->hasRole('Administrativo')) {
            // Admin Nivel 1 y Administrativo pueden descargar cualquier liquidación
            return Storage::disk('public')->download($payroll->file_url);
        } else {
            // Empleados solo pueden descargar sus propias liquidaciones
            $employee = Employed::where('users_id', $user->id)->first();
            if ($employee && $payroll->employees_id === $employee->id) {
                return Storage::disk('public')->download($payroll->file_url);
            }
        }

        abort(403, 'No tienes permiso para descargar esta liquidación.');
    }
}
