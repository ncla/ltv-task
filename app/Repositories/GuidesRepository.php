<?php

namespace App\Repositories;

use App\Channel;
use App\Guide;
use DateTime;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class GuidesRepository
{
    /**
     * @param string $date Formatted date string (e.g. 2020-04-06)
     * @return EloquentCollection
     */
    public function getChannelsWithGuides(string $date): EloquentCollection
    {
        return $channelsWithGuides = Channel::with([
            'guides' => function ($query) use ($date) {
                /**
                 * @var $query \Illuminate\Database\Query\Builder;
                 */
                $query->where('date', $date)
                    ->orderBy('starts', 'asc');
            },
            'guides.show'
        ])->get();
    }

    /**
     * @param string $startingDate Formatted date string (e.g. 2020-04-06)
     * @return \Illuminate\Support\Collection
     */
    public function getUpcomingAvailableGuidesDates(string $startingDate): Collection
    {
        return Guide::where('date', '>=', $startingDate)
            ->select(['date'])
            ->distinct('date')
            ->orderBy('date', 'asc')
            ->pluck('date');
    }

    /**
     * @param int $showId Show ID
     * @param int $selfGuideId ID of the viewed guide to exclude
     * @return EloquentCollection
     * @throws \Exception
     */
    public function getOtherBroadCasts(int $showId, int $selfGuideId): EloquentCollection
    {
        return Guide::with('channel')
            ->orderBy('starts', 'asc')
            ->where('show_id', $showId)
            ->where('starts', '>=', (new DateTime())->format('Y-m-d'))
            ->where('id', '!=', $selfGuideId)
            ->get();
    }
}