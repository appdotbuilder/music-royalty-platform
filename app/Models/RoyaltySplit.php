<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\RoyaltySplit
 *
 * @property int $id
 * @property int $work_id
 * @property int $user_id
 * @property string $role
 * @property float $percentage
 * @property string $split_type
 * @property string|null $notes
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Work $work
 * @property-read \App\Models\User $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltySplit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltySplit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltySplit query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltySplit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltySplit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltySplit whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltySplit wherePercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltySplit whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltySplit whereSplitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltySplit whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltySplit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltySplit whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltySplit whereWorkId($value)
 * @method static \Database\Factories\RoyaltySplitFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class RoyaltySplit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'work_id',
        'user_id',
        'role',
        'percentage',
        'split_type',
        'notes',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'percentage' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the work that owns the royalty split.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    /**
     * Get the user that owns the royalty split.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}