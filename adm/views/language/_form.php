<?php

use kartik\checkbox\CheckboxX;
use mihaildev\elfinder\InputFile;
use pavlinter\adm\Adm;
use pavlinter\buttons\InputButton;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\Language */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="languages-form">

    <?php $form = Adm::begin('ActiveForm'); ?>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <?= $form->field($model, 'code')->textInput(['maxlength' => 16]) ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 20]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <?= Adm::widget('FileInput',[
                'form' => $form,
                'model'      => $model,
                'attribute'  => 'image',
            ]);?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <?= $form->field($model, 'weight')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <?= $form->field($model, 'active', ["template" => "{input}\n{label}\n{hint}\n{error}"])->widget(CheckboxX::classname(), ['pluginOptions'=>['threeState' => false]]); ?>
        </div>
    </div>

    <div class="form-group">
        <?= InputButton::widget([
            'label' => $model->isNewRecord ? Adm::t('', 'Create', ['dot' => false]) : Adm::t('', 'Update', ['dot' => false]),
            'options' => ['class' => 'btn btn-primary'],
            'input' => 'adm-redirect',
            'name' => 'redirect',
            'formSelector' => $form,
        ]);?>


        <?php if ($model->isNewRecord) {?>
            <?= InputButton::widget([
                'label' => Adm::t('', 'Create and insert new', ['dot' => false]),
                'options' => ['class' => 'btn btn-primary'],
                'input' => 'adm-redirect',
                'name' => 'redirect',
                'value' => Url::to(['create']),
                'formSelector' => $form, //form object or form selector
            ]);?>
        <?php }?>

        <?= InputButton::widget([
            'label' => $model->isNewRecord ? Adm::t('', 'Create and list', ['dot' => false]) : Adm::t('', 'Update and list', ['dot' => false]),
            'options' => ['class' => 'btn btn-primary'],
            'input' => 'adm-redirect',
            'name' => 'redirect',
            'value' => Url::to(['index']),
            'formSelector' => $form, //form object or form selector
        ]);?>

    </div>

    <?php Adm::end('ActiveForm'); ?>

</div>
