<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskMaster extends Model
{
    use HasFactory;

    protected $table        = 'task_masters';

    protected $primaryKey   = 'task_master_id';

    public function tasks() {
        return $this->hasMany('App\Models\Task', 'task_master_id');
    }
}
