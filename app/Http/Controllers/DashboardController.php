<?php

namespace App\Http\Controllers;

use App\Models\Employed;
use App\Models\Position;
use App\Models\Contract;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DashboardController
{
    public function index()
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
        return view('employees.employed');
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

    public function download($id)
    {
        $employee = Employed::findOrFail($id);
        $contract = $employee->contract;

        if ($contract && Storage::disk('public')->exists($contract->pdf_url)) {
            return Storage::disk('public')->download($contract->pdf_url);
        }

        return redirect()->back()->with('error', 'No hay contrato disponible.');
    }
}
