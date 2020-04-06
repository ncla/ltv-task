<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Guide;
use DateInterval;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class ChannelGuideController extends Controller
{
    public function index(Request $request)
    {
        $dateTimeNow = (new DateTime())->setTimezone(new DateTimeZone('Europe/Riga'));
        $dateTimeMorning = (new DateTime())->setTimezone(new DateTimeZone('Europe/Riga'))->setTime(6, 0);

        if ($dateTimeNow >= $dateTimeMorning) {
            $todaysDate = $dateTimeNow->format('Y-m-d');
        } else {
            $todaysDate = $dateTimeNow->sub(new DateInterval('P1D'))->format('Y-m-d');
        }

        $dateForGuides = $request->get('date', $todaysDate);

        $channelsWithGuides = Channel::with([
            'guides' => function ($query) use ($dateForGuides) {
                /**
                 * @var $query \Illuminate\Database\Query\Builder;
                 */
                $query->where('date', $dateForGuides)
                    ->orderBy('starts', 'asc');
            }
        ])->get();

        $upcomingGuideDates = Guide::where('date', '>=', $todaysDate)
            ->select(['date'])
            ->distinct('date')
            ->orderBy('date', 'asc')
            ->pluck('date');

        return view('guides.index', [
            'channels' => $channelsWithGuides,
            'daysSelection' => $upcomingGuideDates,
            'date' => $dateForGuides,
        ]);
    }

    public function show(Guide $guide)
    {
        $otherBroadCastTimes = Guide::with('channel')
            ->orderBy('starts', 'asc')
            ->where('show_id', $guide->show_id)
            ->where('starts', '>=', (new DateTime())->format('Y-m-d'))
            ->where('id', '!=', $guide->id)
            ->get();

        return view('guides.show', [
            'guide' => $guide,
            'otherBroadCastTimes' => $otherBroadCastTimes
        ]);
    }
}
