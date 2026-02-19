<?php

namespace app\services;

use app\models\ShortLinks;
use yii\base\UnknownPropertyException;
use yii\httpclient\Client;

class ShortLinkService
{
    public function generate()
    {
        $link = new ShortLinks;
        $link->url = \Yii::$app->request->post('url');

        if ($link->validate()) {
            $this->create($link);
        } else {
            return [false, $link->errors];
        }

        return [$link, null];
    }

    private function createQRCode(string $shortLink)
    {
        include "/services/external/phpqrcode/qrlib.php";

        $dirPath = __DIR__.'/../web/uploads/qrcodes/';
        if (!file_exists($dirPath)) {
            mkdir($dirPath, recursive: true);
        }

        //write code into file, Error corection lecer is lowest, L (one form: L,M,Q,H)
        \QRcode::png($shortLink, $dirPath.'test.png', 'Q');

        //show benchmark
        \QRtools::timeBenchmark();

        //rebuild cache
        \QRtools::buildCache();
    }

    private function create(ShortLinks $link)
    {
        $i = 0;

        do {
            $link->short_link = 'currentsite.com/'.'link'; //random_bytes(8);
            $saved = $link->save();
            dump($i,$saved);
            $i++;
            if ($i>3){
                break;
            }
            dump($link->shortLink);
        } while (!$saved);

        $this->createQRCode($link->shortLink);
    }
}