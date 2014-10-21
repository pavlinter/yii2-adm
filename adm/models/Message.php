<?php

namespace pavlinter\adm\models;

use pavlinter\adm\Adm;
use Yii;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property integer $id
 * @property integer $id_language
 * @property string $translation
 *
 * @property SourceMessage $id0
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_language'], 'required'],
            [['id', 'id_language'], 'integer'],
            [['translation'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Adm::t('model.message', 'ID'),
            'id_language' => Adm::t('model.message', 'Id Language'),
            'translation' => Adm::t('model.message', 'Translation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(SourceMessage::className(), ['id' => 'id']);
    }
}
