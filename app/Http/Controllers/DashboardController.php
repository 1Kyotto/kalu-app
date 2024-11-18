<?php

namespace App\Http\Controllers;

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
}
