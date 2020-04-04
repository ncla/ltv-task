<?php

namespace App\Transformer\LTV\ApiToDb;

use stdClass;

class ChannelGuide
{
    public static function transform(stdClass $guide)
    {
        return [
            'id' => (int) $guide->id,
            'title' => (string) $guide->title,
            'channel_id' => (int) $guide->channel,
            'show_id' => $guide->show === false ? null : (int) $guide->show->id,
            'date' => (string) $guide->date,
            'starts' => date('Y-m-d H:i:s', $guide->starts),
            'ends' => date('Y-m-d H:i:s', $guide->ends),
        ];
    }
}