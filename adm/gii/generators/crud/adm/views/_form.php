<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator pavlinter\adm\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}
echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;
<?php
if ($generator->enableI18N) {
    echo "use pavlinter\\adm\\Adm;";
}
?>


/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin(); ?>
<?php if ($generator->enableLanguage) { ?>

    <?= "<?=" ?> $form->errorSummary([$model] + $model->getLangModels()); ?>
<?php }?>

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>
<?php if ($generator->enableLanguage) {
    $modelClass = new $generator->modelClass();

    $behaviors = $modelClass->behaviors();

    if (isset($behaviors['trans'],$behaviors['trans']['translationAttributes'])) {
?>
    <?= "<?php " ?> foreach (Yii::$app->getI18n()->getLanguages() as $id_language => $language) { ?>
        <section class="panel pos-rlt clearfix">
            <header class="panel-heading">
                <ul class="nav nav-pills pull-right">
                    <li>
                        <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a>
                    </li>
                </ul>
                <h3 class="panel-title"><?= "<?=" ?> $language['name'] ?></h3>
            </header>
            <div class="panel-body clearfix">

<?php foreach ($behaviors['trans']['translationAttributes'] as $translateField) {
    echo "                <?= " . $generator->generateActiveFieldLang($translateField) . " ?>\n";
}?>

            </div>
        </section>

    <?= "<?php " ?> }?>
    <?php }}?>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('Create') ?> : <?= $generator->generateString('Update') ?>, ['class' => 'btn btn-primary']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
