<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;

class UserProfileController extends Controller
{
    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
        ]);

        $employee = Employed::findOrFail($id);
        
        // Verificar que el usuario autenticado es el dueño del perfil
        if ($employee->users_id !== auth()->id()) {
            return redirect()->back()->with('error', 'No tienes permiso para realizar esta acción.');
        }

        $employee->user->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Perfil actualizado exitosamente.');
    }

    public function updatePassword(Request $request, $id)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'password' => ['required', 'confirmed', Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()],
            ], [
                'current_password.required' => 'La contraseña actual es obligatoria.',
                'password.required' => 'La nueva contraseña es obligatoria.',
                'password.confirmed' => 'La confirmación de la contraseña no coincide.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'password.letters' => 'La contraseña debe contener al menos una letra.',
                'password.mixed' => 'La contraseña debe contener mayúsculas y minúsculas.',
                'password.numbers' => 'La contraseña debe contener al menos un número.',
                'password.symbols' => 'La contraseña debe contener al menos un símbolo.',
            ]);

            $employee = Employed::findOrFail($id);
            
            // Verificar que el usuario autenticado es el dueño del perfil
            if ($employee->users_id !== auth()->id()) {
                return redirect()->back()->with('error', 'No tienes permiso para realizar esta acción.');
            }

            $user = $employee->user;

            // Verificar la contraseña actual
            if (!Hash::check($request->current_password, $user->password)) {
                Log::error('Contraseña actual incorrecta para el usuario ID: ' . $user->id);
                return redirect()->back()
                    ->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
            }

            Log::info('Actualizando contraseña para el usuario ID: ' . $user->id);

            // Actualizar la contraseña
            $user->forceFill([
                'password' => Hash::make($request->password)
            ])->save();

            Log::info('Contraseña actualizada exitosamente para el usuario ID: ' . $user->id);

            // Cerrar la sesión actual
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')
                ->with('success', 'Contraseña actualizada exitosamente. Por favor, inicia sesión nuevamente.');

        } catch (\Exception $e) {
            Log::error('Error al actualizar contraseña: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Hubo un error al actualizar la contraseña. Por favor, intente nuevamente.');
        }
    }
}
