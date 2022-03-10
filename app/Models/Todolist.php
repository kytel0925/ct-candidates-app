<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Todolist extends Model
{
    protected $guarded = [];

    protected $appends = [
        'pending', 'badge',
    ];

    public function getPendingAttribute()
    {
        $string = Carbon::parse($this->ends_at)->diffForHumans();
        $string = str_replace(' from now', '', $string);
        $string = str_replace("minutes", "mins", $string);
        return $string;
    }

    public function getBadgeAttribute()
    {
        $clasess = [
            'mins' => 'badge-danger',
            'hour' => 'badge-info',
            'hours' => 'badge-info',
            'day' => 'badge-warning',
            'days' => 'badge-warning',
            'week' => 'badge-primary',
            'weeks' => 'badge-primary',
            'month' => 'badge-secondary',
            'months' => 'badge-secondary',
        ];

        $string = explode(" ", $this->pending)[1];

        return (isset($clasess[$string])) ? $clasess[$string] : 'none';
    }
}