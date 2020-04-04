<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\LaravelUpsert\Eloquent\HasUpsertQueries;

/**
 * App\Guide
 *
 * @property int $id
 * @property string $title
 * @property int $channel_id
 * @property int|null $show_id
 * @property string $date
 * @property string $starts
 * @property string $ends
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Staudenmeir\LaravelUpsert\Eloquent\Builder|\App\Guide newModelQuery()
 * @method static \Staudenmeir\LaravelUpsert\Eloquent\Builder|\App\Guide newQuery()
 * @method static \Staudenmeir\LaravelUpsert\Eloquent\Builder|\App\Guide query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereEnds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereShowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereStarts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Guide extends Model
{
    use HasUpsertQueries;
    use SoftDeletes;

    protected $table = 'channel_guides';
}
