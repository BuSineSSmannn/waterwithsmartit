<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
      'name',
      'description' ,
        'slug'
    ];


    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function (self $model) {
            $model->slug = Str::slug($model->name);
        });

        static::updating(static function (self $model) {
            $model->slug = Str::slug($model->name);
        });

    }

}
