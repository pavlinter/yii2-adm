<?php

use kartik\widgets\Select2;
use pavlinter\adm\Adm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */

$rules = Adm::getInstance()->manager->createAuthRuleQuery()->select('name')->asArray()->all();
$rules = Adm::getInstance()->manager->createAuthRuleQuery()->select('name')->asArray()->all();
?>

<div class="auth-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

    <?php
    echo $form->field($model, 'type')->widget(Select2::classname(), [
        'data' => $model::typeList(),
        'options' => ['placeholder' => Adm::t('','Select ...', ['dot' => false])],
        'pluginOptions' => [

        ],
    ]);
    ?>


    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php
    echo $form->field($model, 'rule_name')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($rules, 'name', 'name'),
        'options' => ['placeholder' => Adm::t('','Select ...', ['dot' => false])],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>


    <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Adm::t('auth', 'Create') : Adm::t('auth', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
