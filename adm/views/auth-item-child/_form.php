<?php

use kartik\widgets\Select2;
use pavlinter\adm\Adm;
use pavlinter\buttons\InputButton;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\AuthItemChild */
/* @var $form yii\widgets\ActiveForm */

$items = Adm::getInstance()->manager->createAuthItemQuery()->select('name')->asArray()->all();
?>

<div class="auth-item-child-form">

    <?php $form = Adm::begin('ActiveForm'); ?>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <?php
            echo $form->field($model, 'parent')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($items, 'name', 'name'),
                'options' => ['placeholder' => Adm::t('','Select ...', ['dot' => false])],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]);
            ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <?php
            echo $form->field($model, 'child')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($items, 'name', 'name'),
                'options' => ['placeholder' => Adm::t('','Select ...', ['dot' => false])],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]);
            ?>
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
