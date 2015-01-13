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
                    'data' => User::roles(),
                    'options' => ['placeholder' => Adm::t('','Select ...', ['dot' => false])],
                    'pluginOptions' => [

                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <?php
                echo $form->field($model, 'status')->widget(Select2::classname(), [
                    'data' => User::status(),
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
        <?= Html::submitButton($model->isNewRecord ? Adm::t('', 'Create') : Adm::t('', 'Update'), ['class' => 'btn btn-primary']) ?>
        <?= Adm::t('', 'Create', ['dot' => '.']) ?>
        <?= Adm::t('', 'Update', ['dot' => '.']) ?>
    </div>

    <?php Adm::end('ActiveForm'); ?>

</div>
