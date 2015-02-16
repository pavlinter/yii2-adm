<?php
/**
 * This is the template for generating the model query class of a specified model.
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

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use yii\db\ActiveQuery;

/**
 * Class <?= $className ?>Query
 */
class <?= $className ?>Query extends ActiveQuery
{
    /**
     * @inheritdoc
     */
    public function active($state = true)
    {
        $this->andWhere(['active' => $state]);
        return $this;
    }
}