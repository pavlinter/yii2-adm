<?php

namespace pavlinter\adm\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\rbac\Item;

/**
 * This is the model class for table "adm_auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 */
class AuthItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_item}}';
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'data', 'rule_name'], 'default', 'value' => null],
            [['name', 'type'], 'required'],
            [['type'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('modelAdm/authitem', 'Name'),
            'type' => Yii::t('modelAdm/authitem', 'Type'),
            'description' => Yii::t('modelAdm/authitem', 'Description'),
            'rule_name' => Yii::t('modelAdm/authitem', 'Rule Name'),
            'data' => Yii::t('modelAdm/authitem', 'Data'),
            'created_at' => Yii::t('modelAdm/authitem', 'Created At'),
            'updated_at' => Yii::t('modelAdm/authitem', 'Updated At'),
        ];
    }

    /**
     * @param null $type
     * @return array|null
     */
    public static function typeList($type = null)
    {
        $list = [
            Item::TYPE_ROLE => Yii::t('adm/auth', 'ROLE', ['dot' => false]),
            Item::TYPE_PERMISSION => Yii::t('adm/auth', 'PERMISSION', ['dot' => false])
        ];

        if ($type !== null) {
            if (isset($list[$type])) {
                return $list[$type];
            }
            return null;
        }

        return $list;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren()
    {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }
}
