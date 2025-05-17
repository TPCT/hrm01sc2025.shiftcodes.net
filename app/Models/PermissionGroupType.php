<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PermissionGroupType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PermissionGroup> $permissionGroups
 * @property-read int|null $permission_groups_count
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroupType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroupType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroupType query()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroupType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroupType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroupType whereSlug($value)
 * @mixin \Eloquent
 */
class PermissionGroupType extends Model
{
    use HasFactory;

    protected $table = "permission_group_types";

    protected $fillable = [
        'name',
        'slug'
    ];
    public $timestamps = false;

    public function permissionGroups(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PermissionGroup::class, 'group_type_id', 'id');
    }
}
