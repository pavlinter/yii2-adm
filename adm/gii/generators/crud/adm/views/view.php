<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
<?php
if ($generator->enableI18N) {
    echo "use pavlinter\\adm\\Adm;";
}
?>


/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

Yii::$app->i18n->disableDot();
$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->i18n->resetDot();
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">

    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>

    <p>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Update') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary']) ?>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Delete') ?>, ['delete', <?= $urlParams ?>], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= "<?= " ?>Adm::widget('DetailView', [
        'model' => $model,
        'hover' => true,
        'mode' => \kartik\detail\DetailView::MODE_VIEW,
        'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo $generator->generateColumnDetailView($column);

    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        echo $generator->generateColumnDetailView($column);
        $format = $generator->generateColumnFormat($column);

    }
}

$modelClass = new $generator->modelClass();
$behaviors = $modelClass->behaviors();
if (isset($behaviors['trans'],$behaviors['trans']['translationAttributes'])) {
    echo "\t\t\t//translations\n";
    foreach ($behaviors['trans']['translationAttributes'] as $translateField) {
        echo $generator->generateColumnTrans($translateField);
    }
}
?>
        ],
    ]) ?>

</div>
