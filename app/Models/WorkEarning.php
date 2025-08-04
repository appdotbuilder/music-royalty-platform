<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\WorkEarning
 *
 * @property int $id
 * @property int $work_id
 * @property int $royalty_report_id
 * @property string $platform
 * @property int $streams
 * @property float $revenue
 * @property float $rate_per_stream
 * @property string $territory
 * @property \Illuminate\Support\Carbon $period_start
 * @property \Illuminate\Support\Carbon $period_end
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Work $work
 * @property-read \App\Models\RoyaltyReport $royaltyReport
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEarning newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEarning newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEarning query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEarning whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEarning whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEarning wherePeriodEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEarning wherePeriodStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEarning wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEarning whereRatePerStream($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEarning whereRevenue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEarning whereRoyaltyReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEarning whereStreams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEarning whereTerritory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEarning whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEarning whereWorkId($value)
 * @method static \Database\Factories\WorkEarningFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class WorkEarning extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'work_id',
        'royalty_report_id',
        'platform',
        'streams',
        'revenue',
        'rate_per_stream',
        'territory',
        'period_start',
        'period_end',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'streams' => 'integer',
        'revenue' => 'decimal:2',
        'rate_per_stream' => 'decimal:6',
        'period_start' => 'date',
        'period_end' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the work that owns the work earning.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    /**
     * Get the royalty report that owns the work earning.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function royaltyReport(): BelongsTo
    {
        return $this->belongsTo(RoyaltyReport::class);
    }
}