<?php

namespace App\Console\Commands;

use App\Channel;
use App\Guide;
use App\Helpers\SimpleGetJsonRequestInterface;
use App\Show;
use App\Transformer\LTV\ApiToDb\Channel as ChannelTransformer;
use App\Transformer\LTV\ApiToDb\ChannelGuide as ChannelGuideTransformer;
use App\Transformer\LTV\ApiToDb\Shows as ShowsTransformer;
use DateTime;
use DateTimeZone;
use Illuminate\Console\Command;

class UpdateTelevisionProgramme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ltv:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update programme, channels, shows';

    /**
     * @var SimpleGetJsonRequestInterface
     */
    protected $requestClient;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $channels;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $shows;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $guides;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $days;

    /**
     * Create a new command instance.
     *
     * @param SimpleGetJsonRequestInterface $requestClient
     */
    public function __construct(SimpleGetJsonRequestInterface $requestClient)
    {
        parent::__construct();

        $this->requestClient = $requestClient;

        $this->channels = collect();
        $this->shows = collect();
        $this->guides = collect();
        $this->days = collect();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $url = config('services.ltv.api.url');

        if (!$url) {
            $this->error('Missing LTV API URL, please config files');
            return false;
        }

        $this->info('Fetching data');

        $currentDate = (new DateTime())->setTimezone(new DateTimeZone('Europe/Riga'))->format('Y-m-d');

        $apiResponse = $this->requestClient->getJson(config('services.ltv.api.url') . '&date=' . $currentDate);

        foreach ($apiResponse->data->daylist as $day) {
            $apiResponse = $this->requestClient->getJson(config('services.ltv.api.url') . '&date=' . $day->day);

            $this->days->push($day->day);

            foreach ($apiResponse->data->guide as $channelAndGuide) {
                $this->channels->put((int)$channelAndGuide->channel->id,
                    ChannelTransformer::transform($channelAndGuide->channel));

                foreach ($channelAndGuide->guide as $guide) {
                    $this->guides->put((int)$guide->id, ChannelGuideTransformer::transform($guide));

                    $show = $guide->show;

                    if ($show !== false) {
                        $this->shows->put((int)$show->id, ShowsTransformer::transform($show));
                    }
                }
            }
        }

        $this->info('Inserting into database');

        Channel::upsert($this->channels->toArray(), 'id');
        Show::upsert($this->shows->toArray(), 'id');

        foreach ($this->guides->chunk(500) as $guidesChunk) {
            /** @var \Illuminate\Support\Collection $guidesChunk */
            Guide::upsert($guidesChunk->toArray(), 'id');
        }

        $this->info('Cleaning up deleted entries');

        $guideIdsFromAPI = $this->guides->pluck('id');
        $guideIdsInDatabase = Guide::whereIn('date', $this->days->toArray())->select('id')->get()->pluck('id');
        $diff = $guideIdsInDatabase->diff($guideIdsFromAPI);

        Guide::whereIn('id', $diff->toArray())->update([
            'deleted_at' => now()->format('Y-m-d H:i:s'),
        ]);

        $this->info('Done');
    }
}
