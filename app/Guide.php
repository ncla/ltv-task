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
 * @property \Illuminate\Support\Carbon $starts
 * @property \Illuminate\Support\Carbon $ends
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Channel $channel
 * @property-read mixed $formatted_end_time
 * @property-read mixed $formatted_full_date_time
 * @property-read mixed $formatted_start_date_time
 * @property-read mixed $formatted_start_time
 * @property-read \App\Show $show
 * @method static bool|null forceDelete()
 * @method static \Staudenmeir\LaravelUpsert\Eloquent\Builder|\App\Guide newModelQuery()
 * @method static \Staudenmeir\LaravelUpsert\Eloquent\Builder|\App\Guide newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Guide onlyTrashed()
 * @method static \Staudenmeir\LaravelUpsert\Eloquent\Builder|\App\Guide query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereEnds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereShowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereStarts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guide whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Guide withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Guide withoutTrashed()
 * @mixin \Eloquent
 */
class Guide extends Model
{
    use HasUpsertQueries;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'channel_guides';

    /**
     * @var array
     */
    protected $dates = [
        'starts',
        'ends'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function show()
    {
        return $this->hasOne('App\Show', 'id', 'show_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function channel()
    {
        return $this->hasOne('App\Channel', 'id', 'channel_id');
    }

    /**
     * @return string
     */
    public function getFormattedStartTimeAttribute(): string
    {
        return $this->starts->format('H:i');
    }

    /**
     * @return string
     */
    public function getFormattedStartDateTimeAttribute(): string
    {
        return $this->starts->format('m-d H:i');
    }

    /**
     * @return string
     */
    public function getFormattedEndTimeAttribute(): string
    {
        return $this->ends->format('H:i');
    }

    /**
     * @return string
     */
    public function getFormattedFullDateTimeAttribute(): string
    {
        return $this->starts->format('m-d H:i:s');
    }
}
