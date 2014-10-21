<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var pavlinter\adm\models\LoginForm $model
 */

?>
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <a class="nav-brand" href="index.html">Adm</a>
    <div class="row m-n">
        <div class="col-md-4 col-md-offset-4 m-t-lg">
            <section class="panel">
                <header class="panel-heading text-center">
                    Login
                </header>
                <?php $form = ActiveForm::begin(['id' => 'login-form','options' => ['class' => 'panel-body']]); ?>
                    <?= $form->field($model, 'username') ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    <?= Html::submitButton('Login', ['class' => 'btn btn-info', 'name' => 'login-button']) ?>
                    <div class="line line-dashed"></div>
                    <?php ActiveForm::end(); ?>
            </section>
        </div>
    </div>
</section>
