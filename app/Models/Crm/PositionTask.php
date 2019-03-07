<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\Position;
use App\Models\Crm\Task;

class PositionTask extends Model
{
    protected $fillable = [
        'position_id',
        'task_id',
    ];
    
    public static $validator = [
        'position_id' => 'required|exists:positions,id',
        'task_id' => 'required|exists:tasks,id',
        'active' => 'boolean'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
