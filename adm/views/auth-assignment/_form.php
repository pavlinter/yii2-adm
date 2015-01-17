<?php

use kartik\widgets\Select2;
use pavlinter\adm\Adm;
use pavlinter\buttons\InputButton;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\AuthAssignment */
/* @var $form yii\widgets\ActiveForm */

$users = Adm::getInstance()->manager->createUserQuery()->select('id,username')->asArray()->all();
$items = Adm::getInstance()->manager->createAuthItemQuery()->select('name')->asArray()->all();

?>

<div class="auth-assignment-form">

    <?php $form = Adm::begin('ActiveForm'); ?>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <?php
            $url = Url::to(['find-user']);
            $initScript = <<< SCRIPT
                function (element, callback) {
                    var id=\$(element).val();
                    if (id !== "") {
                        \$.ajax("{$url}?id=" + id, {
                            dataType: "json"
                        }).done(function(data) { callback(data.results);});
                    }
                }
SCRIPT;
            echo $form->field($model, 'user_id')->widget(Select2::classname(), [
                'options' => ['placeholder' => Adm::t('','Select ...', ['dot' => false])],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'ajax' => [
                        'url' => $url,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(term,page) { return {search:term}; }'),
                        'results' => new JsExpression('function(data,page) {return {results:data.results}; }'),
                    ],
                    'escapeMarkup' => new JsExpression('function (m) { return m; }'),
                    'initSelection' => new JsExpression($initScript)
                ],
            ]);
            ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <?php
            echo $form->field($model, 'item_name')->widget(Select2::classname(), [
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
