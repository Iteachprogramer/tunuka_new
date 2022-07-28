<?php

namespace common\models;

class SendMessage extends \yii\db\ActiveRecord
{
    public $phone;
    public $message;

    public function rules()
    {
        return [
            [['message'], 'required'],
            [['message', 'phone'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'message' => 'Xabar',
            'phone' => 'Telefon',
        ];
    }
}

?>