<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class HashRole extends Model
{
    use HasFactory;
    protected $fillable = ['hash', 'role_id'];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
