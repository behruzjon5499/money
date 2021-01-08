<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "money".
 *
 * @property int $id
 * @property string $from_price
 * @property string $amount
 * @property string $to_price
 */
class Money extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'money';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from_price', 'amount', 'to_price'], 'required'],
            [['from_price', 'amount', 'to_price'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'from_price' => Yii::t('app', 'From Price'),
            'amount' => Yii::t('app', 'Amount'),
            'to_price' => Yii::t('app', 'To Price'),
        ];
    }
}
