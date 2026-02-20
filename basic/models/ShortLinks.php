<?php

namespace app\models;

use app\components\validators\LinkAvailableValidator;
//use app\components\validators\UrlWorkedValidator;
use yii\db\ActiveRecord;

/**
 * ContactForm is the model behind the contact form.
 */
class ShortLinks extends ActiveRecord
{
    public static function tableName()
    {
        return 'short_links';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['url'], 'required', 'message' => 'Поле обязательно для заполнения'],
            [['url'], 'url', 'defaultScheme' => 'https', 'message' => 'Поле имеет не валидную схему ссылки'],
            [['url'], 'url', 'validSchemes' => ['http', 'https'], 'message' => 'Поле имеет не валидную схему ссылки'],
            [['url'], LinkAvailableValidator::class ],
            [['short_link'], 'unique'],
            [['qr_code_path'], 'unique'],
        ];
    }
}
