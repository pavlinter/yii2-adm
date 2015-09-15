<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.5
 */

namespace pavlinter\adm\models;

use Yii;

/**
 * This is the model class for table "adm_auth_item_child".
 *
 * @property string $parent
 * @property string $child
 *
 * @property AuthItem $itemParent
 * @property AuthItem $itemChild
 */
class AuthItemChild extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_item_child}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'unique', 'targetAttribute' => ['parent', 'child']],
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['child'], 'compare','compareAttribute' => 'parent', 'operator' => '!='],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent' => Yii::t('modelAdm/authitemchild', 'Parent'),
            'child' => Yii::t('modelAdm/authitemchild', 'Child'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemParent()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemChild()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'child']);
    }
}
