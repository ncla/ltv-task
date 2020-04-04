<?php

namespace App\Transformer\LTV\ApiToDb;

use stdClass;

class Channel
{
    public static function transform(stdClass $channel)
    {
        return [
            'id' => (int) $channel->id,
            'title' => (string) $channel->title,
        ];
    }
}