<?php

use kartik\checkbox\CheckboxX;
use mihaildev\elfinder\InputFile;
use pavlinter\adm\Adm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\Language */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="languages-form">

    <?php $form = Adm::begin('ActiveForm'); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 16]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 20]) ?>

    <?= Adm::widget('FileInput',[
        'form' => $form,
        'model'      => $model,
        'attribute'  => 'image',
    ]);?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'active', ["template" => "{input}\n{label}\n{hint}\n{error}"])->widget(CheckboxX::classname(), ['pluginOptions'=>['threeState' => false]]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Adm::t('', 'Create') : Adm::t('', 'Update'), ['class' => 'btn btn-primary']) ?>
        <?= Adm::t('', 'Create', ['dot' => '.']) ?>
        <?= Adm::t('', 'Update', ['dot' => '.']) ?>
    </div>

    <?php Adm::end('ActiveForm'); ?>

</div>
