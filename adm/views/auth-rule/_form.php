<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\AuthRule */
/* @var $form yii\widgets\ActiveForm */
/* @var $dynamicModel yii\base\DynamicModel */

?>

<div class="auth-rule-form">

    <?php $form = Adm::begin('ActiveForm'); ?>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <?= $form->field($dynamicModel, 'ruleNamespace')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>
        </div
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Adm::t('', 'Create') : Adm::t('', 'Update'), ['class' => 'btn btn-primary']) ?>
        <?= Adm::t('', 'Create', ['dot' => '.']) ?>
        <?= Adm::t('', 'Update', ['dot' => '.']) ?>
    </div>

    <?php Adm::end('ActiveForm'); ?>

</div>
