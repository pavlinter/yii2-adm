<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator pavlinter\adm\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */
/* @var $modelLangClass \yii\db\ActiveRecord */
$modelLangClassName = \yii\helpers\StringHelper::basename($generator->modelLangClass);
$haveWeight = $generator->haveWeight($tableSchema->columns);

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;

/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 *
<?php if ($generator->modelLangClass): ?>
 * @method \pavlinter\translation\TranslationBehavior getLangModels
 * @method \pavlinter\translation\TranslationBehavior setLanguage
 * @method \pavlinter\translation\TranslationBehavior getLanguage
 * @method \pavlinter\translation\TranslationBehavior saveTranslation
 * @method \pavlinter\translation\TranslationBehavior saveAllTranslation
 * @method \pavlinter\translation\TranslationBehavior saveAll
 * @method \pavlinter\translation\TranslationBehavior validateAll
 * @method \pavlinter\translation\TranslationBehavior validateLangs
 * @method \pavlinter\translation\TranslationBehavior loadAll
 * @method \pavlinter\translation\TranslationBehavior loadLang
 * @method \pavlinter\translation\TranslationBehavior loadLangs
 * @method \pavlinter\translation\TranslationBehavior getTranslation
 * @method \pavlinter\translation\TranslationBehavior hasTranslation
 *
<?php endif; ?>
<?php foreach ($tableSchema->columns as $column): ?>
 * @property <?= "{$column->phpType} \${$column->name}\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . ($name == $modelLangClassName.'s'? 'translations' : lcfirst($name) ) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . "\n" ?>
{
<?php if ($generator->modelClassQuery): ?>
    /**
     * @inheritdoc
     * @return <?= $className ?>Query
     */
    public static function find()
    {
        return new <?= $className ?>Query(get_called_class());
    }
<?php endif; ?>
<?php if ($generator->modelLangClass): ?>
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
<?= $generator->timestampBehavior($tableSchema->columns) ?>
            'trans' => [
                'class' => \pavlinter\translation\TranslationBehavior::className(),
                'translationAttributes' => [
<?php
$modelLangClassObj  = new $generator->modelLangClass();
foreach ($modelLangClassObj->attributes() as $attribute){
    if($attribute == 'id' || preg_match('#^id_#i', $attribute) || preg_match('#_id$#i', $attribute)){
        continue;
    }
?>
                    '<?= $attribute;?>',
<?php } ?>
                ]
            ],
        ];
    }

<?php endif; ?>
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [<?= "\n            " . implode(",\n            ", $rules) . "\n        " ?>];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
<?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
        ];
    }
<?php if ($haveWeight !== false) {?>

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (empty($this-><?= $haveWeight ?>) && $this-><?= $haveWeight ?> != 0) {
            $query = self::find()->select(['MAX(<?= $haveWeight ?>)']);
            if (!$insert) {
                $query->where(['!=', 'id', $this->id]);
            }
            $this-><?= $haveWeight ?> = $query->scalar() + 50;
        }
        return parent::beforeSave($insert);
    }

<?php }?>
<?php foreach ($relations as $name => $relation): ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name == $modelLangClassName.'s'? 'Translations' :$name; ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
}
