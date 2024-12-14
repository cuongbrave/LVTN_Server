<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;





class UserTest extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;

    protected $table = 'user_test';

    protected $fillable = ['user_id', 'test_id', 'score', 'status', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function user_choice()
    {
        return $this->hasMany(UserChoice::class);
    }
}
