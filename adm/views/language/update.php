<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\Language */

Yii::$app->i18n->disableDot();
$this->title = Adm::t('language', 'Update Language: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Adm::t('language', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = Adm::t('language', 'Update');
Yii::$app->i18n->enableDot();
?>
<div class="languages-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
