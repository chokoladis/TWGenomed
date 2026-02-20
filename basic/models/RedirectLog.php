<?php

namespace app\models;

use app\components\validators\LinkAvailableValidator;
use yii\db\ActiveRecord;

//use app\components\validators\UrlWorkedValidator;

/**
 * ContactForm is the model behind the contact form.
 */
class RedirectLog extends ActiveRecord
{
    public static function tableName()
    {
        return 'short_link_redirect_log';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['url_id', 'ip_address'], 'required', 'message' => 'Поле обязательно для заполнения'],
            [['url_id'], 'exist', 'targetClass' => '\app\models\ShortLinks', 'targetAttribute' => 'id'],
            ['ip_address', 'ip'],
        ];
    }
}
