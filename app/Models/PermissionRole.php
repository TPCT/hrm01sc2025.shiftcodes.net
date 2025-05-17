<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PermissionRole
 *
 * @property int|null $permission_id
 * @property int|null $role_id
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereRoleId($value)
 * @mixin \Eloquent
 */
class PermissionRole extends Model
{
    use HasFactory;

    protected $table = "permission_roles";

    protected $fillable = [
        'permission_id',
        'role_id'
    ];

    public $timestamps = false;
}
