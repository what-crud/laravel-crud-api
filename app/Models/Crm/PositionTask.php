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

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
