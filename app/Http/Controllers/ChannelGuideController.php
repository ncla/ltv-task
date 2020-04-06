<?php

namespace App\Http\Controllers;

use App\Guide;
use App\Helpers\GuideDateTime;
use App\Repositories\GuidesRepository;
use Illuminate\Http\Request;

class ChannelGuideController extends Controller
{
    protected $guidesRepository;

    public function __construct()
    {
        $this->guidesRepository = new GuidesRepository();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $todaysDate = GuideDateTime::getTodaysGuideDate();
        $dateForGuides = $request->get('date', $todaysDate) ?? $todaysDate;

        $channels = $this->guidesRepository->getChannelsWithGuides($dateForGuides);

        $guideCount = $channels->sum(function ($channel) {
            return count($channel['guides']);
        });

        if ($request->get('date') !== null && $guideCount === 0) {
            abort(404);
        }

        return view('guides.index', [
            'channels' => $channels,
            'daysSelection' => $this->guidesRepository->getUpcomingAvailableGuidesDates($todaysDate),
            'date' => $dateForGuides,
        ]);
    }

    /**
     * @param Guide $guide
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     * @throws \Exception
     */
    public function show(Guide $guide)
    {
        if (!$guide->hasActiveShow()) {
            return abort(404);
        }

        return view('guides.show', [
            'guide' => $guide,
            'otherBroadCastTimes' => $this->guidesRepository->getOtherBroadCasts($guide->show_id, $guide->id)
        ]);
    }
}
