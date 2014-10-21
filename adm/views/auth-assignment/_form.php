<?php

use kartik\widgets\Select2;
use pavlinter\adm\Adm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\AuthAssignment */
/* @var $form yii\widgets\ActiveForm */

$users = Adm::getInstance()->manager->createUserQuery()->select('id,username')->asArray()->all();
$items = Adm::getInstance()->manager->createAuthItemQuery()->select('name')->asArray()->all();

?>

<div class="auth-assignment-form">

    <?php $form = ActiveForm::begin(); ?>


    <?php
    echo $form->field($model, 'item_name')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($items, 'name', 'name'),
        'options' => ['placeholder' => 'Select a item ...'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]);
    ?>


    <?php
    echo $form->field($model, 'user_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($users, 'id', 'username'),
        'options' => ['placeholder' => 'Select a user ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'ajax' => [
                'url' => Url::to(['find-user']),
                'dataType' => 'json',
                'data' => new JsExpression('function(term,page) { return {search:term}; }'),
                'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
            ],
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Adm::t('auth', 'Create') : Adm::t('auth', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
