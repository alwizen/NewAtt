<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use App\Models\WorkSchedule;
use App\Models\Employee;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Departments
        $kitchen = Department::create([
            'name' => 'Dapur Utama',
            'code' => 'KITCHEN-01',
            'description' => 'Departemen dapur utama',
            'is_active' => true,
        ]);

        $pastry = Department::create([
            'name' => 'Pastry',
            'code' => 'PASTRY-01',
            'description' => 'Departemen pastry dan kue',
            'is_active' => true,
        ]);

        // Create Work Schedules

        // Schedule untuk Dapur Utama (shift malam: 22:00 - 06:00)
        WorkSchedule::create([
            'department_id' => $kitchen->id,
            'check_in_time' => '22:00:00',
            'check_out_time' => '06:00:00',
            'grace_period_minutes' => 15,
            'is_overnight' => true,
            'max_work_hours' => 8,
            'is_active' => true,
        ]);

        // Schedule untuk Pastry (shift normal: 08:00 - 16:00)
        WorkSchedule::create([
            'department_id' => $pastry->id,
            'check_in_time' => '08:00:00',
            'check_out_time' => '16:00:00',
            'grace_period_minutes' => 10,
            'is_overnight' => false,
            'max_work_hours' => 8,
            'is_active' => true,
        ]);

        // Create Employees
        Employee::create([
            'rfid_number' => 'RFID001',
            'employee_number' => 'EMP001',
            'name' => 'Budi Santoso',
            'department_id' => $kitchen->id,
            'join_date' => '2024-01-01',
            'is_active' => true,
        ]);

        Employee::create([
            'rfid_number' => 'RFID002',
            'employee_number' => 'EMP002',
            'name' => 'Siti Aminah',
            'department_id' => $pastry->id,
            'join_date' => '2024-01-01',
            'is_active' => true,
        ]);

        Employee::create([
            'rfid_number' => 'RFID003',
            'employee_number' => 'EMP003',
            'name' => 'Ahmad Wijaya',
            'department_id' => $kitchen->id,
            'join_date' => '2024-01-15',
            'is_active' => true,
        ]);
    }
}
