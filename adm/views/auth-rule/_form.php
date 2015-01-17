<?php

use pavlinter\adm\Adm;
use pavlinter\buttons\InputButton;
use yii\helpers\Html;
use yii\helpers\Url;

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
            <?= $form->field($model, 'data')->textarea(['rows' => 6, 'readonly' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= InputButton::widget([
            'label' => Adm::t('', 'Create', ['dot' => false]),
            'options' => ['class' => 'btn btn-primary'],
            'input' => 'adm-redirect',
            'name' => 'redirect',
            'formSelector' => $form,
        ]);?>


        <?= InputButton::widget([
            'label' => Adm::t('', 'Create and insert new', ['dot' => false]),
            'options' => ['class' => 'btn btn-primary'],
            'input' => 'adm-redirect',
            'name' => 'redirect',
            'value' => Url::to(['create']),
            'formSelector' => $form, //form object or form selector
        ]);?>


        <?= InputButton::widget([
            'label' => Adm::t('', 'Create and list', ['dot' => false]),
            'options' => ['class' => 'btn btn-primary'],
            'input' => 'adm-redirect',
            'name' => 'redirect',
            'value' => Url::to(['index']),
            'formSelector' => $form, //form object or form selector
        ]);?>
    </div>

    <?php Adm::end('ActiveForm'); ?>

</div>
