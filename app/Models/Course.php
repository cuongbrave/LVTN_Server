<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class Course extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;
    public function module()
    {
        return $this->hasMany(Module::class, 'course_id', 'id');
    }
}
