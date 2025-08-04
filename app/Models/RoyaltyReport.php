<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\RoyaltyReport
 *
 * @property int $id
 * @property int $tenant_id
 * @property string $platform
 * @property \Illuminate\Support\Carbon $period_start
 * @property \Illuminate\Support\Carbon $period_end
 * @property int $total_streams
 * @property float $total_revenue
 * @property array|null $platform_data
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $processed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant $tenant
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkEarning> $workEarnings
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltyReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltyReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltyReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltyReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltyReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltyReport wherePeriodEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltyReport wherePeriodStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltyReport wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltyReport wherePlatformData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltyReport whereProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltyReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltyReport whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltyReport whereTotalRevenue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltyReport whereTotalStreams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoyaltyReport whereUpdatedAt($value)
 * @method static \Database\Factories\RoyaltyReportFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class RoyaltyReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tenant_id',
        'platform',
        'period_start',
        'period_end',
        'total_streams',
        'total_revenue',
        'platform_data',
        'status',
        'processed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'total_streams' => 'integer',
        'total_revenue' => 'decimal:2',
        'platform_data' => 'array',
        'processed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the tenant that owns the royalty report.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the work earnings for the royalty report.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workEarnings(): HasMany
    {
        return $this->hasMany(WorkEarning::class);
    }
}