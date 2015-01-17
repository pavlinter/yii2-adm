<?php

use pavlinter\adm\Adm;
use pavlinter\buttons\InputButton;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \pavlinter\adm\models\SourceMessage */

Yii::$app->i18n->disableDot();
$this->title = Adm::t('source-message', 'Update Source Message: {id}', [ 'id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Adm::t('source-message', 'Source Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->message, 'url' => ['index']];
$this->params['breadcrumbs'][] = Adm::t('source-message', 'Update');
Yii::$app->i18n->resetDot();
?>
<div class="source-message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = Adm::begin('ActiveForm'); ?>

    <section class="panel adm-langs-panel">
        <header class="panel-heading bg-light">
            <ul class="nav nav-tabs nav-justified text-uc">
                <?php  foreach (Yii::$app->getI18n()->getLanguages() as $id_language => $language) { ?>
                    <li><a href="#lang-<?= $id_language ?>" data-toggle="tab"><?= $language['name'] ?></a></li>
                <?php  }?>
            </ul>
        </header>
        <div class="panel-body">
            <div class="tab-content">
                <?php  foreach (Yii::$app->getI18n()->getLanguages() as $id_language => $language) { ?>
                    <div class="tab-pane" id="lang-<?= $id_language ?>">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <?= Adm::widget('Redactor',[
                                    'form' => $form,
                                    'model'      => $model->getTranslation($id_language),
                                    'attribute'  => '['.$id_language.']translation',
                                    'removeFirstTag' => true,
                                ]);?>
                            </div>
                        </div>
                    </div>
                <?php  }?>
            </div>
        </div>
    </section>

    <div class="form-group">
        <?= InputButton::widget([
            'label' => Adm::t('', 'Update', ['dot' => false]),
            'options' => ['class' => 'btn btn-primary'],
            'input' => 'adm-redirect',
            'name' => 'redirect',
            'formSelector' => $form,
        ]);?>

        <?= InputButton::widget([
            'label' => Adm::t('', 'Update and list', ['dot' => false]),
            'options' => ['class' => 'btn btn-primary'],
            'input' => 'adm-redirect',
            'name' => 'redirect',
            'value' => Url::to(['index']),
            'formSelector' => $form, //form object or form selector
        ]);?>
    </div>

    <?php Adm::end('ActiveForm'); ?>

</div>
