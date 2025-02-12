<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;

    protected $table = 'branches';

    protected $fillable = [
      'name',
      'address',
      'phone'
    ];


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'user_branches','branch_id','user_id');
    }
}
