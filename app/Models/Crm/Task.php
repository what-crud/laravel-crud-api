<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\PositionTask;

class Task extends Model
{
    protected $fillable = ['name', 'active'];
    
    public function taskPositions()
    {
        return $this->hasMany(PositionTask::class);
    }
}
