<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelUpsert\Eloquent\HasUpsertQueries;

/**
 * App\Show
 *
 * @property int $id
 * @property string $title
 * @property string $logo_large
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $logo_url
 * @method static \Staudenmeir\LaravelUpsert\Eloquent\Builder|\App\Show newModelQuery()
 * @method static \Staudenmeir\LaravelUpsert\Eloquent\Builder|\App\Show newQuery()
 * @method static \Staudenmeir\LaravelUpsert\Eloquent\Builder|\App\Show query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Show whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Show whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Show whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Show whereLogoLarge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Show whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Show whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Show extends Model
{
    use HasUpsertQueries;

    /**
     * @var string
     */
    protected $table = 'shows';

    /**
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * @return string
     */
    public function getLogoUrlAttribute(): string
    {
        return '//ltv.lsm.lv/' . $this->logo_large;
    }
}
