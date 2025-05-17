<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PermissionGroup
 *
 * @property int $id
 * @property string $name
 * @property int|null $group_type_id
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup whereGroupTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup whereName($value)
 * @mixin \Eloquent
 */
class PermissionGroup extends Model
{
    use HasFactory;

    protected $table = "permission_groups";

    protected $fillable = [
        'name',
        'group_type_id'
    ];
    public $timestamps = false;

    public function getPermission(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Permission::class, 'permission_groups_id', 'id');
    }
}
