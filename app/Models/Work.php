<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Work
 *
 * @property int $id
 * @property int $tenant_id
 * @property int $artist_id
 * @property string $title
 * @property string|null $isrc
 * @property string|null $upc
 * @property array|null $genres
 * @property string $language
 * @property int|null $duration_seconds
 * @property \Illuminate\Support\Carbon|null $release_date
 * @property string|null $album_name
 * @property string|null $cover_art_url
 * @property string|null $audio_file_url
 * @property array|null $metadata
 * @property string $status
 * @property array|null $distribution_platforms
 * @property \Illuminate\Support\Carbon|null $distributed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant $tenant
 * @property-read \App\Models\Artist $artist
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RoyaltySplit> $royaltySplits
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkEarning> $workEarnings
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Work newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Work newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Work query()
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereAlbumName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereArtistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereAudioFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereCoverArtUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereDistributedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereDistributionPlatforms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereDurationSeconds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereGenres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereIsrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereUpc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereUpdatedAt($value)
 * @method static \Database\Factories\WorkFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Work extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tenant_id',
        'artist_id',
        'title',
        'isrc',
        'upc',
        'genres',
        'language',
        'duration_seconds',
        'release_date',
        'album_name',
        'cover_art_url',
        'audio_file_url',
        'metadata',
        'status',
        'distribution_platforms',
        'distributed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'genres' => 'array',
        'metadata' => 'array',
        'distribution_platforms' => 'array',
        'release_date' => 'date',
        'distributed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the tenant that owns the work.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the artist that owns the work.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    /**
     * Get the royalty splits for the work.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function royaltySplits(): HasMany
    {
        return $this->hasMany(RoyaltySplit::class);
    }

    /**
     * Get the work earnings for the work.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workEarnings(): HasMany
    {
        return $this->hasMany(WorkEarning::class);
    }
}