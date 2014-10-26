<?php

namespace pavlinter\adm\models;

use pavlinter\translation\TranslationBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "page".
 *
 * @property string $id
 * @property integer $updated_at
 * @property integer $created_at
 *
 * @property PageLang[] $pageLangs
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {


        return [
            TimestampBehavior::className(),
            'trans' => [ // name it the way you want
                'class' => TranslationBehavior::className(),
                // in case you named your relation differently, you can setup its relation name attribute
                //'relation' => 'translations',
                // in case you named the language column differently on your translation schema
                //'languageField' => 'lang',
                'translationAttributes' => [
                    'title', 'text'
                ]
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(PageLang::className(), ['id_page' => 'id']);
    }
}
