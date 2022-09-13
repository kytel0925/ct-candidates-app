<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    public $table = "tasks";

    protected $fillable = [
        'id', 'name_of_the_task', 'status', 'created_at', 'updated_at'
    ];
}
