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

    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($dynamicModel, 'ruleNamespace')->textInput() ?>

    <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Adm::t('auth', 'Create') : Adm::t('auth', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php Adm::end('ActiveForm'); ?>

</div>
