<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Lesson;
use App\Models\WClass;
use Illuminate\Http\Request;
use DateTime;

class EmployeesController extends Controller
{
    public function index()
    {
        $employees = Employee::whereHas('classes')->get();
        return view('employees', [
            'employees' => $employees
        ]);
    }

    public function view(Request $request, Employee $employee)
    {
        $start_at_dates = Lesson::where('employee_id', $employee->id)
            ->orderBy('start_at')
            ->pluck('start_at')
            ->toArray();
        $dates = array_map(function ($item) {
            return (new DateTime($item))->format('d-m-Y');
        }, $start_at_dates);
        $dates = array_unique($dates);
        $dates = array_map(function ($item) {
            return DateTime::createFromFormat('d-m-Y', $item);
        }, $dates);
        return view('employee', [
            'employee' => $employee,
            'dates' => $dates,
        ]);
    }

    public function viewLessonsByDate(Request $request, Employee $employee, $date)
    {
        $date = DateTime::createFromFormat('d-m-Y', $date);
        $lessons = Lesson::where('employee_id', $employee->id)
            ->whereDate('start_at', $date)
            ->with('class.students')
            ->get();
        return view('dayView', [
            'date' => $date,
            'employee' => $employee,
            'lessons' => $lessons,
        ]);
    }
}
