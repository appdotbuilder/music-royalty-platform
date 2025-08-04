<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Invitation
 *
 * @property int $id
 * @property int $tenant_id
 * @property int $invited_by
 * @property string $email
 * @property string $role
 * @property string $token
 * @property string $status
 * @property array|null $metadata
 * @property \Illuminate\Support\Carbon $expires_at
 * @property \Illuminate\Support\Carbon|null $accepted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant $tenant
 * @property-read \App\Models\User $invitedBy
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation whereAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation whereInvitedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation whereUpdatedAt($value)
 * @method static \Database\Factories\InvitationFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Invitation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tenant_id',
        'invited_by',
        'email',
        'role',
        'token',
        'status',
        'metadata',
        'expires_at',
        'accepted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'array',
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the tenant that owns the invitation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the user who sent the invitation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }
}