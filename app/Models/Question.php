<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class Question extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;
    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id', 'id');
    }

    public function choice()
    {
        return $this->hasMany(Choice::class, 'question_id', 'id');
    }

    public function user_choice()
    {
        return $this->hasMany(User_Choice::class, 'question_id', 'id');
    }

}
