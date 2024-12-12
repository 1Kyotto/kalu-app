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
                'password.mixed' => 'La contraseña debe contener al menos una letra mayúscula y una minúscula.',
                'password.numbers' => 'La contraseña debe contener al menos un número.',
                'password.symbols' => 'La contraseña debe contener al menos un símbolo.',
            ]);

            $employee = Employed::findOrFail($id);
            
            // Verificar que el usuario autenticado es el dueño del perfil
            if ($employee->users_id !== auth()->id()) {
                return redirect()->back()
                    ->with('error', 'No tienes permiso para realizar esta acción.');
            }

            // Verificar la contraseña actual
            if (!Hash::check($request->current_password, $employee->user->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
            }

            $employee->user->update([
                'password' => Hash::make($request->password),
                'first_login' => false
            ]);

            return redirect()->back()->with('success', 'Contraseña actualizada exitosamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error al actualizar contraseña: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Hubo un error al cambiar la contraseña. ' . $e->getMessage());
        }
    }
}
