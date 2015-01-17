<?php

use pavlinter\adm\Adm;
use pavlinter\buttons\InputButton;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \pavlinter\adm\models\SourceMessage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="source-message-form">

    <?php $form = Adm::begin('ActiveForm'); ?>

    <?= $form->field($model, 'category')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

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
