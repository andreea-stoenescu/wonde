<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\Lesson;
use App\Models\School;
use App\Models\Student;
use App\Models\WClass;
use Illuminate\Console\Command;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\DB;
use Wonde\Client as WondeClient;

class DownloadData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:wonde';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the initial data from Wonde. Does not handle deltas.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $wclient = new WondeClient(Env('WONDE_TOKEN'));
        $wschool = $wclient->schools->get(Env('SCHOOL_ID', 'A1930499544'));
        DB::beginTransaction();
        try {
            $school = School::create([
                'wonde_id' => $wschool->id,
                'name' => $wschool->name,
                'timezone' => $wschool->timezone,
                'phase_of_education' => $wschool->phase_of_education,
            ]);
            $wemployees = $wclient->school($wschool->id)->employees->all();
            foreach ($wemployees AS $wemployee) {
                $employee = Employee::create([
                    'wonde_id' => $wemployee->id,
                    'school_id' => $school->id,
                    'legal_forename' => $wemployee->legal_forename,
                    'legal_surname' => $wemployee->legal_surname,
                    'upi' => $wemployee->upi,
                ]);
            }
            $wstudents = $wclient->school($wschool->id)->students->all();
            foreach ($wstudents AS $wstudent) {
                $student = Student::create([
                    'wonde_id' => $wstudent->id,
                    'school_id' => $school->id,
                    'forename' => $wstudent->forename,
                    'surname' => $wstudent->surname,
                    'upi' => $wstudent->upi,
                ]);
            }
            $wclasses = $wclient->school($wschool->id)->classes->all(['students', 'employees', 'lessons']);
            foreach ($wclasses AS $wclass) {
                $class = WClass::create([
                    'wonde_id' => $wclass->id,
                    'school_id' => $school->id,
                    'name' => $wclass->name,
                    'description' => $wclass->description,
                ]);
                $student_wonde_ids = array_map(function ($item) {
                    return $item->id;
                }, $wclass->students->data);
                $student_ids = Student::whereIn('wonde_id', $student_wonde_ids)->pluck('id');
                $class->students()->sync($student_ids);
                
                $employee_wonde_ids = array_map(function ($item) {
                    return $item->id;
                }, $wclass->employees->data);
                $employee_ids = Employee::whereIn('wonde_id', $employee_wonde_ids)->pluck('id');
                $class->employees()->sync($employee_ids);
                
                foreach ($wclass->lessons->data AS $wlesson) {
                    $lesson = Lesson::create([
                        'wonde_id' => $wlesson->id,
                        'wonde_room_id' => $wlesson->room,
                        'class_id' => $class->id,
                        'employee_id' => Employee::where('wonde_id', $wlesson->employee)->first()?->id,
                        'start_at' => $wlesson->start_at->date,
                        'end_at' => $wlesson->end_at->date,
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return Command::SUCCESS;
    }
}
