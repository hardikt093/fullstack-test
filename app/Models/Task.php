<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Task extends Model
{
    use HasFactory;

    protected $table        = 'tasks';

    protected $primaryKey   = 'task_id';

    protected $appends      = [
        'taskdatestring',
    ];

    public function getTaskdatestringAttribute() {
        return Carbon::parse($this->task_date)->format(config('constants.dateformat_listing_date'));
    }

    public function taskmaster() {
        return $this->belongsTo('App\Models\TaskMaster', 'task_master_id');
    }
}
