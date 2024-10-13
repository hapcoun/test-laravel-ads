<?php

namespace App\Models;

use App\Events\AdBudgetUpdated;
use App\Events\AdStatusUpdated;
use App\Models\Enums\ButtonTextEnum;
use App\Models\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $id
 * @property integer $campaign_id
 * @property string $title
 * @property string $text
 * @property StatusEnum $status
 * @property string $url
 * @property integer $views
 * @property float $cpm
 * @property float $budget
 * @property ButtonTextEnum $button_text
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Campaign $campaign
 **/
class Ad extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'text',
        'cpm',
        'budget',
        'status',
        'button_text',
        'url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => StatusEnum::class,
        'button_text' => ButtonTextEnum::class
    ];

    /**
     * Get the campaign that owns the ad.
     *
     * @return BelongsTo<Campaign, Ad>
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    protected static function booted()
    {
        static::saved(function ($ad) {
            if ($ad->isDirty('status')) {
                event(new AdStatusUpdated($ad));
            }

            if ($ad->isDirty('budget')) {
                event(new AdBudgetUpdated($ad));
            }
        });
    }
}
