<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Tenant
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $domain
 * @property string|null $description
 * @property string|null $logo_url
 * @property string|null $website
 * @property string $status
 * @property array|null $settings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Artist> $artists
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Work> $works
 * @property-read \App\Models\Subscription|null $subscription
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Invitation> $invitations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RoyaltyReport> $royaltyReports
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereLogoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereWebsite($value)
 * @method static \Database\Factories\TenantFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Tenant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'domain',
        'description',
        'logo_url',
        'website',
        'status',
        'settings',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'settings' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the users for the tenant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the artists for the tenant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function artists(): HasMany
    {
        return $this->hasMany(Artist::class);
    }

    /**
     * Get the works for the tenant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function works(): HasMany
    {
        return $this->hasMany(Work::class);
    }

    /**
     * Get the subscription for the tenant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

    /**
     * Get the invitations for the tenant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * Get the royalty reports for the tenant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function royaltyReports(): HasMany
    {
        return $this->hasMany(RoyaltyReport::class);
    }
}