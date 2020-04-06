<?php

namespace App\Helpers;

class FileGetContentsSimpleGetJsonRequest implements SimpleGetJsonRequestInterface
{
    /**
     * @param string $url
     * @return mixed
     */
    public function getJson(string $url)
    {
        $output = file_get_contents($url);

        return json_decode($output);
    }
}