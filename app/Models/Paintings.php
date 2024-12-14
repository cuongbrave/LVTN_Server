<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class Paintings extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;
    public function painter()
    {
        return $this->belongsTo(Painters::class, 'painter_id', 'id');
    }
}
