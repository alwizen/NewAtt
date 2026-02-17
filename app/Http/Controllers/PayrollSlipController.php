<?php

namespace App\Http\Controllers;

use App\Models\PayrollDetail;
use Illuminate\Http\Request;

class PayrollSlipController extends Controller
{
    public function show(PayrollDetail $payrollDetail)
    {
        $payrollDetail->load(['employee', 'payroll', 'employee.department']);

        $employee   = $payrollDetail->employee;
        $department = $employee->department;
        $payroll    = $payrollDetail->payroll;

        return view('payroll.slip', [
            'detail'       => $payrollDetail,
            'employee'     => $employee,
            'department'   => $department,
            'payroll'      => $payroll,
            'app_address'  => config('app.address', 'Jl. Contoh No. 1, Kota'),
            'app_city'     => config('app.city', 'Jakarta'),
            'accountantName' => config('app.accountant_name', 'Godos'),
            'tanggal_cetak'  => now()->translatedFormat('d F Y'),
        ]);
    }
}
