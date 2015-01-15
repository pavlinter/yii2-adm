<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.0
 */

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
            'id' => Yii::t('modelAdm/language', 'ID'),
            'code' => Yii::t('modelAdm/language', 'Code'),
            'name' => Yii::t('modelAdm/language', 'Name'),
            'image' => Yii::t('modelAdm/language', 'Image'),
            'weight' => Yii::t('modelAdm/language', 'Weight'),
            'active' => Yii::t('modelAdm/language', 'Active'),
            'updated_at' => Yii::t('modelAdm/language', 'Updated At'),
        ];
    }
}
