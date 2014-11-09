<?php

use kartik\widgets\Alert;
use kartik\widgets\Select2;
use pavlinter\adm\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use pavlinter\adm\Adm;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $passwordModel yii\base\DynamicModel */




?>

<div class="user-form">

    <?php
    if (Yii::$app->getSession()->hasFlash('success')) {
        echo Alert::widget([
            'type' => Alert::TYPE_SUCCESS,
            'body' => Yii::$app->getSession()->getFlash('success')
        ]);
    }
    ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($passwordModel, 'password')->passwordInput() ?>

    <?= $form->field($passwordModel, 'password2')->passwordInput() ?>

    <?php if (!Adm::getInstance()->user->can('Adm-UpdateOwnUser', $model)) {?>

        <?php
        echo $form->field($model, 'role')->widget(Select2::classname(), [
            'data' => User::roles(),
            'options' => ['placeholder' => Adm::t('','Select ...', ['dot' => false])],
            'pluginOptions' => [
                //'allowClear' => true,
            ],
        ]);
        ?>

        <?php
        echo $form->field($model, 'status')->widget(Select2::classname(), [
            'data' => User::status(),
            'options' => ['placeholder' => Adm::t('','Select ...', ['dot' => false])],
            'pluginOptions' => [
                //'allowClear' => false,
            ],
        ]);
        ?>

    <?php }?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Adm::t('user', 'Create') : Adm::t('user', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
