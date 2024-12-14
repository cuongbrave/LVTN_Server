<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

    public function user_choice()
    {
        return $this->hasMany(User_Choice::class, 'choice_id', 'id');
    }
}
