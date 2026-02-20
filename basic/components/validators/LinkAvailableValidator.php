<?php

namespace app\components\validators;

use yii\httpclient\Client;
use yii\validators\Validator;

class LinkAvailableValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $client = new Client;
        //        todo check safety method
        try {
            $response = $client->get($model->$attribute)->send();
        } catch (\Throwable $t) {
            $this->addError($model, $attribute, 'Данный URL не доступен'); //Ссылка должна возвращать положительный статус 2xx
            return;
        }

        if (!$response->getIsOk()) {
            $this->addError($model, $attribute, 'Данный URL не доступен'); //Ссылка должна возвращать положительный статус 2xx
        }
    }
}