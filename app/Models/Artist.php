<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Artist
 *
 * @property int $id
 * @property int $tenant_id
 * @property int $user_id
 * @property string $stage_name
 * @property string|null $real_name
 * @property string|null $bio
 * @property array|null $genres
 * @property string|null $country
 * @property string|null $avatar_url
 * @property array|null $social_links
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $contract_signed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant $tenant
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Work> $works
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Artist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Artist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Artist query()
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereContractSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereGenres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereRealName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereSocialLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereStageName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereUserId($value)
 * @method static \Database\Factories\ArtistFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Artist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tenant_id',
        'user_id',
        'stage_name',
        'real_name',
        'bio',
        'genres',
        'country',
        'avatar_url',
        'social_links',
        'status',
        'contract_signed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'genres' => 'array',
        'social_links' => 'array',
        'contract_signed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the tenant that owns the artist.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the user that owns the artist.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the works for the artist.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function works(): HasMany
    {
        return $this->hasMany(Work::class);
    }
}