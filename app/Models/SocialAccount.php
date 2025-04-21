<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @property string $id
 * @property string $user_id
 * @property string $provider
 * @property array<array-key, mixed> $payload
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialAccount whereUserId($value)
 *
 * @mixin \Eloquent
 */
class SocialAccount extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'provider',
        'payload',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'user_id' => 'string',
            'provider' => 'string',
            'payload' => 'json',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public static function booted(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
