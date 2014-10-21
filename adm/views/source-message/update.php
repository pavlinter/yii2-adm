<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \pavlinter\adm\models\SourceMessage */

$this->title = Adm::t('source-message', 'Update Source Message: ') . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Adm::t('source-message', 'Source Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->message, 'url' => ['index']];
$this->params['breadcrumbs'][] = Adm::t('source-message', 'Update');
?>
<div class="source-message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([

    ]); ?>



    <?php foreach (Yii::$app->getI18n()->getLanguages() as $id_language => $language) { ?>
        <section class="panel pos-rlt clearfix">
            <header class="panel-heading">
                <ul class="nav nav-pills pull-right">
                    <li>
                        <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a>
                    </li>
                </ul>
                <h3 class="panel-title"><?= $language['name'] ?></h3>
            </header>
            <div class="panel-body clearfix">
                <?= Adm::widget('Redactor',[
                    'form' => $form,
                    'model'      => $model->getTranslation($id_language),
                    'attribute'  => '['.$id_language.']translation',
                ]);?>

            </div>
        </section>
    <?php }?>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
