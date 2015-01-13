<?php

use kartik\widgets\Select2;
use pavlinter\adm\Adm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

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
        <?= Html::submitButton($model->isNewRecord ? Adm::t('', 'Create') : Adm::t('', 'Update'), ['class' => 'btn btn-primary']) ?>
        <?= Adm::t('', 'Create', ['dot' => '.']) ?>
        <?= Adm::t('', 'Update', ['dot' => '.']) ?>
    </div>

    <?php Adm::end('ActiveForm'); ?>

</div>
