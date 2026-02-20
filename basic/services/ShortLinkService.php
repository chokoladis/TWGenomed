<?php

namespace app\services;

use app\models\RedirectLog;
use app\models\ShortLinks;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Yii;
use yii\base\Exception;

class ShortLinkService
{
    const DIR_QR_CODES = '/uploads/qrcodes/';

    public function generate()
    {
        $link = new ShortLinks;
        $link->url = \Yii::$app->request->post('url');

        if ($link->validate()) {
            $result = $this->create($link);
            if (!$result) {
                return [false, ['Ошибка создания короткой ссылки']];
            }
        } else {
            return [false, $link->errors];
        }

        return [$link, null];
    }

    private function create(ShortLinks &$link)
    {
        for ($i = 0; $i < 3; $i++) {
            $link->short_link = env('APP_URL') . '/'.bin2hex(random_bytes(4));
            $valid = $link->validate();
            if (!$valid) {
                continue;
            }

            $qrCodePath = $this->createQRCode($link->short_link);
            if (!$qrCodePath) {
                throw new Exception('Error creating QR Code');
            }

            $link->qr_code_path = $qrCodePath;
            if ($link->save()) {
                return true;
            }

            if (!$link->hasErrors('short_link')) {
                throw new \RuntimeException(
                    'Failed to save ShortLink: ' . json_encode($link->errors)
                );
            }
        }

        return false;
    }

    private function createQRCode(string $shortLink)
    {
        $dirPath = $_SERVER['DOCUMENT_ROOT'].self::DIR_QR_CODES;
        if (!file_exists($dirPath)) {
            mkdir($dirPath, recursive: true);
        }

        $i = 0;
        $limiter = 4;
        do {
            $qrCodeName = bin2hex(random_bytes(8)).'.png';
            $qrCodePath = $dirPath.$qrCodeName;

            $i++;
            if ($i >= $limiter)
                return false;
        } while (file_exists($qrCodePath));

        $qrCode = new QrCode($shortLink);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $result->saveToFile($qrCodePath);

        if (file_exists($qrCodePath)) {
            return self::DIR_QR_CODES.$qrCodeName;
        }

        return false;
    }

    public function getFullLink(string $shortLink) : ?string
    {
        $shortLink = env('APP_URL'). '/'. $shortLink;
        if ($model = ShortLinks::findOne(['short_link' => $shortLink])) {
            $redirect = new RedirectLog;

            try {
                $data = [
                    'url_id' => $model->id,
                    'ip_address' => \Yii::$app->request->userIP
                ];

                $redirect->setAttributes($data);

                $isValid = $redirect->validate();
                if (!$isValid || !$redirect->save()) {
                    Yii::error(print_r($redirect->errors, true), 'save_redirect_log');
                }
            } catch (\Throwable $exception) {
                Yii::error(print_r($exception->errors, true), 'system_error');
            }

            return $model->url;
        }

        return null;
    }
}