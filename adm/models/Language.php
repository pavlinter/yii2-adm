<?php

namespace pavlinter\adm\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%language}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $image
 * @property integer $weight
 * @property integer $active
 * @property string $updated_at
 */
class Language extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%language}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['weight', 'active'], 'integer'],
            [['updated_at'], 'safe'],
            [['code'], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 20],
            [['image'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('adm/model.language', 'ID'),
            'code' => Yii::t('adm/model.language', 'Code'),
            'name' => Yii::t('adm/model.language', 'Name'),
            'image' => Yii::t('adm/model.language', 'Image'),
            'weight' => Yii::t('adm/model.language', 'Weight'),
            'active' => Yii::t('adm/model.language', 'Active'),
            'updated_at' => Yii::t('adm/model.language', 'Updated At'),
        ];
    }
}
