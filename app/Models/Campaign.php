<?php

namespace App\Models;

use App\Events\CampaignStatusUpdated;
use App\Models\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property StatusEnum $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 * @property Ad[] $ads
 **/
class Campaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => StatusEnum::class
    ];

    /**
     * Get the user that owns the campaign.
     *
     * @return BelongsTo<User, Campaign>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the ads associated with the campaign.
     *
     * @return HasMany<Ad>
     */
    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

    protected static function booted()
    {
        static::saved(function ($campaign) {
            if ($campaign->isDirty('status')) {
                event(new CampaignStatusUpdated($campaign));
            }
        });
    }
}
