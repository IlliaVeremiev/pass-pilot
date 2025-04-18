<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property string $id
 * @property string $name
 * @property string|null $slug
 * @property string|null $description
 * @property string $owner_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 *
 * @method static Builder<static>|Organization newModelQuery()
 * @method static Builder<static>|Organization newQuery()
 * @method static Builder<static>|Organization query()
 * @method static Builder<static>|Organization whereCreatedAt($value)
 * @method static Builder<static>|Organization whereDescription($value)
 * @method static Builder<static>|Organization whereId($value)
 * @method static Builder<static>|Organization whereName($value)
 * @method static Builder<static>|Organization whereOwnerId($value)
 * @method static Builder<static>|Organization whereSlug($value)
 * @method static Builder<static>|Organization whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Organization extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'owner_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
        ];
    }

    /**
     * The "booted" method of the model.
     */
    public static function booted(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * The users that belong to the organization.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id', 'owner_id');
    }
}
