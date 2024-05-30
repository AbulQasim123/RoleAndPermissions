<?php

namespace App\Models;

use App\Models\{
    Permission,
    Role,
};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermissionRole extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'permission_roles';

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
