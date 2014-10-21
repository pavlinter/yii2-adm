<?php

namespace pavlinter\adm\models;

use Yii;

/**
 * This is the model class for table "page_lang".
 *
 * @property string $id
 * @property string $id_page
 * @property integer $id_language
 * @property string $title
 * @property string $text
 *
 * @property Page $page
 */
class PageLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['id_page', 'id_language'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_page' => 'Id Page',
            'id_language' => 'Id Language',
            'title' => 'Title',
            'text' => 'Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'id_page']);
    }
}
