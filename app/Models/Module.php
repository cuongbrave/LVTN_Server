<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class Module extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function test()
    {
        return $this->hasMany(Test::class, 'module_id', 'id');
    }
}
