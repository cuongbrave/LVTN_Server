<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\ModelTree;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class CourseType extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;
    use ModelTree;
}
