<?php

namespace pavlinter\adm\models;

use pavlinter\adm\Adm;
use pavlinter\translation\TranslationBehavior;
use Yii;

/**
 * This is the model class for table "{{%source_message}}".
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * @property Message[] $messages
 */
class SourceMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'trans' => [
                'class' => TranslationBehavior::className(),
                'translationAttributes' => [
                    'translation'
                ]
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%source_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category'], 'required'],
            [['message'], 'string'],
            [['category'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Adm::t('model.source-message', 'ID'),
            'category' => Adm::t('model.source-message', 'Category'),
            'message' => Adm::t('model.source-message', 'Message'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(Message::className(), ['id' => 'id']);
    }
}
