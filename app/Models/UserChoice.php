<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class UserChoice extends Model
{
    use HasFactory;

    use DefaultDatetimeFormat;

    protected $table = 'user_choice';
    protected $fillable = ['user_test_id', 'question_id', 'choice_id'];

    public function user_test()
    {
        return $this->belongsTo(UserTest::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function choice()
    {
        return $this->belongsTo(Choice::class);
    }
}
