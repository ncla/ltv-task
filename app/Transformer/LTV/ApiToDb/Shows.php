<?php

namespace App\Transformer\LTV\ApiToDb;

use stdClass;

class Shows
{
    public static function transform(stdClass $show)
    {
        return [
            'id' => (int) $show->id,
            'title' => (string) $show->title,
            'logo_large' => (string) $show->logo_large,
        ];
    }
}