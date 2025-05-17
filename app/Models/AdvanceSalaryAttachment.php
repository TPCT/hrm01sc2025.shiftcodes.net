<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\AdvanceSalaryAttachment
 *
 * @property int $id
 * @property int $advance_salary_id
 * @property string $name
 * @property-read \App\Models\AdvanceSalary $advanceSalaryDetail
 * @method static \Illuminate\Database\Eloquent\Builder|AdvanceSalaryAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvanceSalaryAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvanceSalaryAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvanceSalaryAttachment whereAdvanceSalaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvanceSalaryAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvanceSalaryAttachment whereName($value)
 * @mixin \Eloquent
 */
class AdvanceSalaryAttachment extends Model
{
    use HasFactory;

    protected $table = 'advance_salary_attachments';

    public $timestamps = false;

    protected $fillable = [
        'advance_salary_id',
        'name',
    ];

    const RECORDS_PER_PAGE = 20;

    const UPLOAD_PATH = 'uploads/advanceSalary/';

    public function advanceSalaryDetail(): BelongsTo
    {
        return $this->belongsTo(AdvanceSalary::class, 'advance_salary_id', 'id');
    }
}
