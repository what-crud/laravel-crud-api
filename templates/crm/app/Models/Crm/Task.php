<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\PositionTask;

class Task extends Model
{
    protected $fillable = ['name', 'description', 'active'];
    
    public static $validator = [
        'name' => 'required|string|max:200',
        'description' => 'string|max:500|nullable',
        'active' => 'boolean'
    ];
    
    public function taskPositions()
    {
        return $this->hasMany(PositionTask::class);
    }
}
