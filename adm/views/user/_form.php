<?php

use kartik\widgets\Select2;
use pavlinter\adm\models\User;
use pavlinter\buttons\InputButton;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use pavlinter\adm\Adm;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $dynamicModel yii\base\DynamicModel */
/* @var $authItems array */


?>

<div class="user-form">

    <?php $form = Adm::begin('ActiveForm'); ?>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>


        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <?= $form->field($dynamicModel, 'password')->passwordInput()->label(Yii::t('modelAdm/user', 'Password')) ?>

        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <?= $form->field($dynamicModel, 'password2')->passwordInput()->label(Yii::t('modelAdm/user', 'Confirm Password')) ?>
        </div>
    </div>



    <?php if (!Adm::getInstance()->user->can('Adm-UpdateOwnUser', $model)) {?>

        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4">
                <?php
                echo $form->field($model, 'role')->widget(Select2::classname(), [
                    'data' => $model::roles(),
                    'options' => ['placeholder' => Adm::t('','Select ...', ['dot' => false])],
                    'pluginOptions' => [

                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <?php
                echo $form->field($model, 'status')->widget(Select2::classname(), [
                    'data' => $model::status(),
                    'options' => ['placeholder' => Adm::t('','Select ...', ['dot' => false])],
                    'pluginOptions' => [

                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <?php
                if ($model->isNewRecord) {
                    echo $form->field($dynamicModel, 'assignment')->widget(Select2::classname(), [
                        'data' => \yii\helpers\ArrayHelper::map($authItems, 'name' , 'name'),
                        'options' => ['placeholder' => Adm::t('','Select ...', ['dot' => false])],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label(Yii::t('modelAdm/user', 'Assignment Role'));
                }
                ?>
            </div>
        </div>

    <?php }?>

    <div class="form-group">

        <?= InputButton::widget([
            'label' => $model->isNewRecord ? Adm::t('', 'Create', ['dot' => false]) : Adm::t('', 'Update', ['dot' => false]),
            'options' => ['class' => 'btn btn-primary'],
            'input' => 'adm-redirect',
            'name' => 'redirect',
            'formSelector' => $form,
        ]);?>

        <?php if (!Adm::getInstance()->user->can('Adm-UpdateOwnUser', $model)) {?>

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

            <?= InputButton::widget([
                'label' => $model->isNewRecord ? Adm::t('', 'Create and viewing', ['dot' => false]) : Adm::t('', 'Update and viewing', ['dot' => false]),
                'options' => ['class' => 'btn btn-primary'],
                'input' => 'adm-redirect',
                'name' => 'redirect',
                'value' => Url::to(['view', 'id' => '{id}']),
                'formSelector' => $form, //form object or form selector
            ]);?>

        <?php }?>
    </div>

    <?php Adm::end('ActiveForm'); ?>

</div>
