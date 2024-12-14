<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class Painters extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;
    public function paintings()
    {
        return $this->hasMany(Paintings::class, 'painter_id', 'id');
    }



}
