<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelUpsert\Eloquent\HasUpsertQueries;

/**
 * App\Channel
 *
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Guide[] $guides
 * @property-read int|null $guides_count
 * @method static \Staudenmeir\LaravelUpsert\Eloquent\Builder|\App\Channel newModelQuery()
 * @method static \Staudenmeir\LaravelUpsert\Eloquent\Builder|\App\Channel newQuery()
 * @method static \Staudenmeir\LaravelUpsert\Eloquent\Builder|\App\Channel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Channel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Channel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Channel whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Channel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Channel extends Model
{
    use HasUpsertQueries;

    /**
     * @var string
     */
    protected $table = 'channels';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function guides()
    {
        return $this->hasMany('App\Guide', 'channel_id');
    }
}
