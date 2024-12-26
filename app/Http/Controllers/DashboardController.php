<?php

namespace App\Http\Controllers;

use App\Models\Employed;
use App\Models\Position;
use App\Models\Contract;
use App\Models\User;
use App\Models\Role;
use App\Rules\ChileanRut;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function leykarin()
    {
        return view('ley_karin.ley_karin');
    }

    public function contrato()
    {
        return view('contracts.contract');
    }

    public function liquidaciones()
    {
        return view('payroll.payroll');
    }

    public function solicitudes()
    {
        return view('permissions.permission');
    }

    public function beneficios()
    {
        return view('benefits.benefits');
    }

    public function politicas()
    {
        return view('policies_regulations.policy');
    }

    public function empleados()
    {
        $user = auth()->user();
        $userRoles = $user->roles()->pluck('roles.id')->toArray();

        \Log::info('Usuario actual ID: ' . $user->id);
        \Log::info('Roles del usuario: ' . implode(', ', $userRoles));

        // Obtener los IDs de todos los usuarios que son admin (roles 1 o 2)
        $adminUserIds = DB::table('role_user')
            ->whereIn('roles_id', [1, 2])
            ->pluck('users_id')
            ->toArray();

        \Log::info('IDs de usuarios admin: ' . implode(', ', $adminUserIds));

        $query = Employed::with(['user.roles', 'position', 'contract']);

        // Si es administrador nivel 1 (ID = 1)
        if (in_array(1, $userRoles)) {
            \Log::info('Es admin nivel 1');
            // Mostrar todos los empleados excepto a sí mismo
            $query->whereHas('user', function($q) use ($user) {
                $q->where('id', '!=', $user->id);
            });
        }
        // Si es administrador nivel 2 (ID = 2)
        elseif (in_array(2, $userRoles)) {
            \Log::info('Es admin nivel 2');
            // Mostrar solo empleados que no sean administradores y que no sea él mismo
            $query->whereHas('user', function($q) use ($user, $adminUserIds) {
                $q->where('id', '!=', $user->id)
                  ->whereNotIn('id', $adminUserIds);
            });
        }

        $sql = $query->toSql();
        $bindings = $query->getBindings();
        \Log::info('SQL Query: ' . $sql);
        \Log::info('SQL Bindings: ' . implode(', ', $bindings));

        $employees = $query->get();
        
        \Log::info('Empleados encontrados: ' . $employees->pluck('user.id')->implode(', '));

        $employees = $employees->map(function ($employee) {
            $employee->entry_date = Carbon::parse($employee->entry_date)->format('d-m-Y');
            return $employee;
        });

        return view('employees.employed', compact('employees'));
    }

    public function createEmpleado()
    {
        $positions = Position::all();
        $roles = Role::where('name', '!=', 'Admin Nivel 1')->get(); // No permitimos crear Admin Nivel 1
        
        return view('employees.create', compact('positions', 'roles'));
    }

    public function storeEmpleado(Request $request)
    {
        $messages = [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'rut.required' => 'El RUT es obligatorio.',
            'rut.unique' => 'Este RUT ya está registrado.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'cellphone.string' => 'El teléfono debe ser texto.',
            'cellphone.max' => 'El teléfono no puede tener más de 20 caracteres.',
            'address.required' => 'La dirección es obligatoria.',
            'address.string' => 'La dirección debe ser texto.',
            'address.max' => 'La dirección no puede tener más de 255 caracteres.',
            'position_id.required' => 'El cargo es obligatorio.',
            'position_id.exists' => 'El cargo seleccionado no es válido.',
            'entry_date.required' => 'La fecha de ingreso es obligatoria.',
            'entry_date.date' => 'La fecha de ingreso debe ser una fecha válida.',
            'role_id.required' => 'El rol es obligatorio.',
            'role_id.exists' => 'El rol seleccionado no es válido.'
        ];

        $rules = [
            'name' => 'required|string|max:255',
            'rut' => ['required', 'string', 'unique:users', new ChileanRut],
            'email' => 'required|email|unique:users',
            'cellphone' => 'nullable|string|max:20',
            'address' => 'required|string|max:255',
            'position_id' => 'required|exists:positions,id',
            'entry_date' => 'required|date',
            'role_id' => 'required|exists:roles,id'
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Generar contraseña provisional aleatoria
            $temporaryPassword = Str::random(8);
            
            // Crear usuario
            $user = User::create([
                'name' => $request->name,
                'rut' => $request->rut,
                'email' => $request->email,
                'password' => Hash::make($temporaryPassword),
                'cellphone' => $request->cellphone ?? '',
                'address' => $request->address,
                'first_login' => true, // Marcar como primer inicio de sesión
            ]);

            // Asignar rol
            $user->roles()->attach($request->role_id);

            // Crear empleado
            $employed = Employed::create([
                'users_id' => $user->id,
                'positions_id' => $request->position_id,
                'entry_date' => Carbon::parse($request->entry_date)->format('Y-m-d'),
            ]);

            DB::commit();

            // Aquí podrías agregar el código para enviar el correo con las credenciales
            
            return redirect()->route('empleados.info')
                ->with('success', "Empleado creado exitosamente. Contraseña temporal: {$temporaryPassword}");

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error al crear empleado: ' . $e->getMessage());
            
            // Si ya existe un usuario creado, intentar limpiarlo
            if (isset($user)) {
                try {
                    $user->roles()->detach();
                    $user->delete();
                } catch (\Exception $cleanupError) {
                    \Log::error('Error al limpiar usuario: ' . $cleanupError->getMessage());
                }
            }

            return redirect()->route('empleados.info')
                ->with('error', 'Hubo un error al crear el empleado. Por favor, contacte al administrador.');
        }
    }

    public function edit($id)
    {
        $employee = Employed::with('user', 'position', 'contract')->findOrFail($id);
        $positions = Position::all();
        return view('settings.settings', compact('employee', 'positions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $employee = Employed::with('user')->findOrFail($id);

        if ($employee->user) {
            $employee->user->update(['name' => $request->name]);
        }

        return redirect()->route('user.profile', $id)->with('success', 'Información del empleado actualizada correctamente.');
    }

    public function updateEmployeeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:activo,inactivo'
        ]);

        $employee = Employed::findOrFail($id);
        $employee->status = $request->status;
        $employee->save();

        return response()->json(['success' => true]);
    }

    public function updateStatus($id, Request $request)
    {
        try {
            $employee = Employed::findOrFail($id);
            $employee->status = $request->status;
            $employee->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error al actualizar estado del empleado: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function uploadContract(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'contract' => 'required|file|mimes:pdf|max:10240'
            ]);

            $employee = Employed::with('contract')->findOrFail($request->employee_id);
            
            // Asegurarse de que el directorio existe
            $contractsPath = storage_path('app/public/contracts');
            if (!file_exists($contractsPath)) {
                mkdir($contractsPath, 0777, true);
            }

            // Generar un nombre único para el archivo
            $fileName = 'contract_' . $employee->id . '_' . time() . '.pdf';
            
            DB::beginTransaction();
            try {
                // Si ya existe un contrato, eliminarlo
                if ($employee->contract) {
                    $oldPath = $employee->contract->pdf_url;
                    $employee->contract->delete();
                    
                    // Eliminar el archivo anterior si existe
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }

                // Guardar el nuevo archivo
                $path = $request->file('contract')->storeAs('contracts', $fileName, 'public');
                if (!$path) {
                    throw new \Exception('No se pudo guardar el archivo');
                }

                // Crear nuevo contrato
                Contract::create([
                    'employees_id' => $employee->id,
                    'pdf_url' => $path
                ]);

                DB::commit();
                return response()->json([
                    'success' => true, 
                    'message' => 'Contrato subido exitosamente'
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                // Si algo falla, eliminar el archivo que acabamos de subir
                if (isset($path) && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                throw $e;
            }
        } catch (\Exception $e) {
            \Log::error('Error al subir contrato: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el contrato: ' . $e->getMessage()
            ], 500);
        }
    }

    public function download($id)
    {
        try {
            $employee = Employed::findOrFail($id);
            $contract = $employee->contract;

            if (!$contract) {
                return redirect()->back()->with('error', 'No hay contrato disponible.');
            }

            $filePath = storage_path('app/public/' . $contract->pdf_url);
            
            if (!file_exists($filePath)) {
                return redirect()->back()->with('error', 'El archivo del contrato no se encuentra.');
            }

            return response()->download($filePath);
        } catch (\Exception $e) {
            \Log::error('Error al descargar contrato: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al descargar el contrato.');
        }
    }

    public function destroy($id)
    {
        try {
            $employee = Employed::with(['contract', 'user', 'permissions', 'attendances', 'evaluations'])->findOrFail($id);

            // Eliminar el contrato y el archivo si existe
            if ($employee->contract) {
                if (Storage::disk('public')->exists($employee->contract->pdf_url)) {
                    Storage::disk('public')->delete($employee->contract->pdf_url);
                }
                $employee->contract->delete();
            }

            // Eliminar permisos, asistencias y evaluaciones
            $employee->permissions()->delete();
            $employee->attendances()->delete();
            $employee->evaluations()->delete();

            // Obtener el usuario antes de eliminar el empleado
            $user = $employee->user;

            // Eliminar el empleado
            $employee->delete();

            // Eliminar los roles del usuario y luego el usuario si existe
            if ($user) {
                // Eliminar las relaciones en la tabla role_user
                DB::table('role_user')->where('users_id', $user->id)->delete();
                // Ahora sí podemos eliminar el usuario
                $user->delete();
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error al eliminar empleado: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function settings()
    {
        $user = auth()->user();
        $employee = Employed::with('contract', 'position', 'user')
            ->where('users_id', $user->id)
            ->firstOrFail();

        return view('settings.settings', compact('employee'));
    }
}
