<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'project_id',
        'epic_id',
        'story_id'
    ];
}
