<?php 
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskMaster;
use App\Http\Requests\CreateTask;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;


class TaskServices {
    
    public function createTask(Request $request) {
        
        $period = intval($request->period);
        $startDate = new Carbon($request->start_date);
        $endDate = new Carbon($request->end_date);
        
        $taskmaster               = new TaskMaster();
        $taskmaster->title        = $request->title;
        $taskmaster->description  = $request->description;
        $taskmaster->start_date   = $startDate;
        if($period == 9) {
            $taskmaster->end_date     = $startDate;
        }
        else {
            $taskmaster->end_date     = $endDate;
        }
        $taskmaster->period       = $period;
        $result                   = $taskmaster->save();

        if ($result) {
            $curentdate = Carbon::now()->toDateTimeString();

            //Every day
            if($period == 0) {
                $all_dates = array();
                while ($startDate->lte($endDate)){
                    $day = array();
                    $day['task_master_id'] = $taskmaster->task_master_id;
                    $day['task_date'] = $startDate->toDateString();
                    $day['created_at'] = $curentdate;
                    $day['updated_at'] = $curentdate;
                    $all_dates[] = $day;
                    $startDate->addDay();
                }

                $task = Task::insert($all_dates);
            }
            //Every monday
            elseif ($period == 1) {
                $all_mondays = [];
                $startMondayDate = $startDate->subDay(1)->next(Carbon::MONDAY); 
                
                while ($startMondayDate->lte($endDate)){
                    $day = array();
                    $day['task_master_id'] = $taskmaster->task_master_id;
                    $day['task_date'] = $startMondayDate->toDateString();
                    $day['created_at'] = $curentdate;
                    $day['updated_at'] = $curentdate;
                    $all_mondays[] = $day;
                    $startMondayDate->addWeek();
                }

                $task = Task::insert($all_mondays);
            }
            // Every tuesday
            elseif ($period == 2) {
                $all_tuesdays = [];
                $startTuesdayDate = $startDate->subDay(1)->next(Carbon::TUESDAY); 

                while ($startTuesdayDate->lte($endDate)){
                    $day = array();
                    $day['task_master_id'] = $taskmaster->task_master_id;
                    $day['task_date'] = $startTuesdayDate->toDateString();
                    $day['created_at'] = $curentdate;
                    $day['updated_at'] = $curentdate;
                    $all_tuesdays[] = $day;
                    $startTuesdayDate->addWeek();
                }

                $task = Task::insert($all_tuesdays);
            }
            // Every wednesday
            elseif ($period == 3) {
                $all_wednesdays = [];
                $startWednesdayDate = $startDate->subDay(1)->next(Carbon::WEDNESDAY); 

                while ($startWednesdayDate->lte($endDate)){
                    $day = array();
                    $day['task_master_id'] = $taskmaster->task_master_id;
                    $day['task_date'] = $startWednesdayDate->toDateString();
                    $day['created_at'] = $curentdate;
                    $day['updated_at'] = $curentdate;
                    $all_wednesdays[] = $day;
                    $startWednesdayDate->addWeek();
                }

                $task = Task::insert($all_wednesdays);
            }
            // Every friday
            elseif ($period == 4) {
                $all_fridays = [];
                $startFridayDate = $startDate->subDay(1)->next(Carbon::FRIDAY); 

                while ($startFridayDate->lte($endDate)){
                    $day = array();
                    $day['task_master_id'] = $taskmaster->task_master_id;
                    $day['task_date'] = $startFridayDate->toDateString();
                    $day['created_at'] = $curentdate;
                    $day['updated_at'] = $curentdate;
                    $all_fridays[] = $day;
                    $startFridayDate->addWeek();
                }

                $task = Task::insert($all_fridays);
            }
            // Every 5th of each month
            elseif ($period == 5) {
                $service_date = 5;
                $dateperiods = CarbonPeriod::create($startDate, '1 month' , $endDate);
                $dates = [];

                foreach ($dateperiods as $date) {
                    $date = $date->day($service_date);
                    
                    if ($date >= $startDate && $date <= $endDate) {
                        // $dates[] = $date->format('d-m-Y');
                        $day = array();
                        $day['task_master_id'] = $taskmaster->task_master_id;
                        $day['task_date'] = $date->toDateString();
                        $day['created_at'] = $curentdate;
                        $day['updated_at'] = $curentdate;
                        $dates[] = $day;
                    }
                }

                $task = Task::insert($dates);
            }
            // Every 5th of March of each year
            elseif ($period == 6) {
                $service_date = 5;
                $service_month = 3;

                $dateperiods = CarbonPeriod::create($startDate, '1 month' , $endDate);
                $dates = [];

                foreach ($dateperiods as $date) {
                    $date = $date->day($service_date)->month($service_month);
                
                    if ($date >= $startDate && $date <= $endDate) {
                        $day = array();
                        if(array_search($date->toDateString(), array_column($dates, 'task_date')) === false) {
                            $day = array();
                            $day['task_master_id'] = $taskmaster->task_master_id;
                            $day['task_date'] = $date->toDateString();
                            $day['created_at'] = $curentdate;
                            $day['updated_at'] = $curentdate;
                            $dates[] = $day;
                        }
                    }
                }

                $task = Task::insert($dates);
            }
            // Every Week
            elseif ($period == 7) {

                $all_week = [];
                $dayofweek = $startDate->dayOfWeek;
                $startWeekDate = $startDate->subDay(1)->next($dayofweek); 
                
                while ($startWeekDate->lte($endDate)){
                    $day = array();
                    $day['task_master_id'] = $taskmaster->task_master_id;
                    $day['task_date'] = $startWeekDate->toDateString();
                    $day['created_at'] = $curentdate;
                    $day['updated_at'] = $curentdate;
                    $all_week[] = $day;
                    $startWeekDate->addWeek();
                }

                $task = Task::insert($all_week);
            }
            // Every Month
            elseif ($period == 8) {

                $service_date = $startDate->format('d'); 
                $dateperiods = CarbonPeriod::create($startDate, '1 month' , $endDate);
                $dates = [];

                foreach ($dateperiods as $date) {
                    $date = $date->day($service_date);
                    
                    if ($date >= $startDate && $date <= $endDate) {
                        // $dates[] = $date->format('d-m-Y');
                        $day = array();
                        $day['task_master_id'] = $taskmaster->task_master_id;
                        $day['task_date'] = $date->toDateString();
                        $day['created_at'] = $curentdate;
                        $day['updated_at'] = $curentdate;
                        $dates[] = $day;
                    }
                }

                $task = Task::insert($dates);
            }
            //Every day
            elseif($period == 9) {
                $day = array();
                $day['task_master_id'] = $taskmaster->task_master_id;
                $day['task_date'] = $startDate->toDateString();
                $day['created_at'] = $curentdate;
                $day['updated_at'] = $curentdate;

                $task = Task::insert($day);
            }

            $data["type"] = "success";
        } else {
            $data["type"] = "error";
        }

        return response()->json($data);
    }

    public function loadTasks(Request $request) {

        $tasks = Task::oldest('task_date')->get();

        $todaytasks = $tasks->where('task_date', Carbon::today()->toDateString())->where('status', 0);

        $tomorrowtasks = $tasks->where('task_date', Carbon::tomorrow()->toDateString())->where('status', 0);

        $nextweektasks = $tasks->whereBetween('task_date', [Carbon::now()->nextWeekday()->startOfWeek(Carbon::SATURDAY), Carbon::now()->nextWeekday()->endOfWeek(Carbon::SATURDAY)])->where('status', 0);
        
        $nextmonthtasks = $tasks->whereBetween('task_date', [Carbon::now()->addMonth(1)->startOfMonth()->subDay(1), Carbon::now()->addMonth(1)->endOfMonth()])->where('status', 0);
        
        $nexttasks = $tasks->where('task_date', '>', Carbon::now()->addMonth(1)->endOfMonth())->where('status', 0);
        
        $completedtasks = $tasks->where('status', 1);


        $data['today_tasks_html']   = view('ajax.tasks', ['tasks' => $todaytasks])->render();
        $data['tomorrow_tasks_html']   = view('ajax.tasks', ['tasks' => $tomorrowtasks])->render();
        $data['nextweek_tasks_html']   = view('ajax.tasks', ['tasks' => $nextweektasks])->render();
        $data['nextmonth_tasks_html']   = view('ajax.tasks', ['tasks' => $nextmonthtasks])->render();
        $data['next_tasks_html']   = view('ajax.tasks', ['tasks' => $nexttasks])->render();
        
        $data['completed_tasks_html']   = view('ajax.tasks', ['tasks' => $completedtasks])->render();


        return response()->json($data);
    }

    public function completeTasks(Request $request) {
        $data = [];

        $task_id = intval($request->task_id);

        $task = Task::find($task_id);
        if(!empty($task)) {
            $task->status = 1;
            
            if($task->update()) {
                $data['type'] = 'success';
                $data['caption'] = 'Task marked as completed.';
            }
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Unable to mark task as completed.';
            }
        
        }
        else {
            $data['type'] = 'error';
            $data['caption'] = 'Invalid Task.';
        }

        return response()->json($data);
    }
    
    public function pendingTasks(Request $request) {
        $data = [];

        $task_id = intval($request->task_id);

        $task = Task::find($task_id);
        if(!empty($task)) {
            $task->status = 0;
            
            if($task->update()) {
                $data['type'] = 'success';
                $data['caption'] = 'Task marked as pending.';
            }
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Unable to mark task as pending.';
            }
        
        }
        else {
            $data['type'] = 'error';
            $data['caption'] = 'Invalid Task.';
        }

        return response()->json($data);
    }

    public function deleteTasks(Request $request) {
        $data = [];

        $task_id = intval($request->task_id);

        $task = Task::find($task_id);
        if(!empty($task)) {
    
            if($task->delete()) {
                $data['type'] = 'success';
                $data['caption'] = 'Task Deleted.';
            }
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Unable to delete task.';
            }
        
        }
        else {
            $data['type'] = 'error';
            $data['caption'] = 'Invalid Task.';
        }

        return response()->json($data);
    }

}