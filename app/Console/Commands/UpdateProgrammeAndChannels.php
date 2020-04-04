<?php

namespace App\Console\Commands;

use App\Channel;
use App\Guide;
use App\Show;
use DateTime;
use DateTimeZone;
use GuzzleHttp\ClientInterface;
use Illuminate\Console\Command;
use App\Transformer\LTV\ApiToDb\ChannelGuide as ChannelGuideTransformer;
use App\Transformer\LTV\ApiToDb\Shows as ShowsTransformer;
use App\Transformer\LTV\ApiToDb\Channel as ChannelTransformer;

class UpdateProgrammeAndChannels extends Command
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
     * @var ClientInterface
     */
    protected $requestClient;

    protected $channels;
    protected $shows;
    protected $guides;

    /**
     * Create a new command instance.
     *
     * @param ClientInterface $requestClient
     */
    public function __construct(ClientInterface $requestClient)
    {
        parent::__construct();

        $this->requestClient = $requestClient;

        $this->channels = collect();
        $this->shows = collect();
        $this->guides = collect();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
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

        $apiResponse = $this->requestClient->request('GET', config('services.ltv.api.url') . '&date=' . $currentDate);

        $responseParsed = json_decode($apiResponse->getBody());

        foreach ($responseParsed->data->daylist as $day) {
            $apiResponse = $this->requestClient->request('GET', config('services.ltv.api.url') . '&date=' . $day->day);

            $responseParsedDay = json_decode($apiResponse->getBody());

            foreach ($responseParsedDay->data->guide as $channelAndGuide) {
                $this->channels->put((int) $channelAndGuide->channel->id, ChannelTransformer::transform($channelAndGuide->channel));

                foreach ($channelAndGuide->guide as $guide) {
                    $this->guides->put((int) $guide->id, ChannelGuideTransformer::transform($guide));

                    $show = $guide->show;

                    if ($show !== false) {
                        $this->shows->put((int) $show->id, ShowsTransformer::transform($show));
                    }
                }
            }
        }

        $this->info('Inserting into database');

        Channel::upsert($this->channels->toArray(), 'id');
        Show::upsert($this->shows->toArray(), 'id');
        Guide::upsert($this->guides->toArray(), 'id');

        $this->info('Done');
    }
}
