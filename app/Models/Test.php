<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Support\Str;

class Test extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;

    protected $table = 'test';

    protected $fillable = [
        'name',
        'description',
        'time',
        'user_token',
        'test_code', // Thêm trường test_code vào đây
    ];

    public function question()
    {
        return $this->hasMany(Question::class, 'test_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->test_code = self::generateUniqueTestCode();
        });
    }

    private static function generateUniqueTestCode()
    {
        do {
            $code = Str::random(6);
        } while (self::where('test_code', $code)->exists());

        return $code;
    }
}