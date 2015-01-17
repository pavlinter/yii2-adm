<?php

use kartik\widgets\Select2;
use pavlinter\adm\Adm;
use pavlinter\buttons\InputButton;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */

$rules = Adm::getInstance()->manager->createAuthRuleQuery()->select('name')->asArray()->all();
$rules = Adm::getInstance()->manager->createAuthRuleQuery()->select('name')->asArray()->all();
?>

<div class="auth-item-form">

    <?php $form = Adm::begin('ActiveForm'); ?>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
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
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
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
