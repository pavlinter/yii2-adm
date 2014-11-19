<?php

use kartik\widgets\Select2;
use pavlinter\adm\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use pavlinter\adm\Adm;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $dynamicModel yii\base\DynamicModel */
/* @var $authItems array */


?>

<div class="user-form">

    <?php Adm::widget('Alert'); ?>

    <?php $form = Adm::begin('ActiveForm'); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($dynamicModel, 'password')->passwordInput()->label(Adm::t('user', 'Password')) ?>

    <?= $form->field($dynamicModel, 'password2')->passwordInput()->label(Adm::t('user', 'Confirm Password')) ?>

    <?php if (!Adm::getInstance()->user->can('Adm-UpdateOwnUser', $model)) {?>

        <?php
        echo $form->field($model, 'role')->widget(Select2::classname(), [
            'data' => User::roles(),
            'options' => ['placeholder' => Adm::t('','Select ...', ['dot' => false])],
            'pluginOptions' => [

            ],
        ]);
        ?>

        <?php
        echo $form->field($model, 'status')->widget(Select2::classname(), [
            'data' => User::status(),
            'options' => ['placeholder' => Adm::t('','Select ...', ['dot' => false])],
            'pluginOptions' => [

            ],
        ]);
        ?>


        <?php
            if ($model->isNewRecord) {
                echo $form->field($dynamicModel, 'assignment')->widget(Select2::classname(), [
                    'data' => \yii\helpers\ArrayHelper::map($authItems, 'name' , 'name'),
                    'options' => ['placeholder' => Adm::t('','Select ...', ['dot' => false])],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])->label(Adm::t('user', 'Assignment Role'));
            }
        ?>

    <?php }?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Adm::t('user', 'Create') : Adm::t('user', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php Adm::end('ActiveForm'); ?>

</div>
