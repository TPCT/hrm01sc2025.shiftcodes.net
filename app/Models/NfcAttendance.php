<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\NfcAttendance
 *
 * @property int $id
 * @property string|null $title
 * @property string $identifier
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $created_by
 * @property-read \App\Models\User $createdBy
 * @method static Builder|NfcAttendance newModelQuery()
 * @method static Builder|NfcAttendance newQuery()
 * @method static Builder|NfcAttendance query()
 * @method static Builder|NfcAttendance whereCreatedAt($value)
 * @method static Builder|NfcAttendance whereCreatedBy($value)
 * @method static Builder|NfcAttendance whereId($value)
 * @method static Builder|NfcAttendance whereIdentifier($value)
 * @method static Builder|NfcAttendance whereTitle($value)
 * @method static Builder|NfcAttendance whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NfcAttendance extends Model
{
    use HasFactory;

    protected $table = 'nfc_attendances';

    protected $fillable = ['title','identifier','created_by'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
        });

        if (Auth::check() && Auth::user()->id != 1 && isset(Auth::user()->branch_id)) {
            $branchId = Auth::user()->branch_id;

            static::addGlobalScope('branch', function (Builder $builder) use($branchId){
                $builder->whereHas('createdBy', function ($query) use ($branchId) {
                    $query->where('branch_id', $branchId);
                });

            });
        }
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

}
