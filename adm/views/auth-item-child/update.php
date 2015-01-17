<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\AuthItemChild */

Yii::$app->i18n->disableDot();
$this->title = Adm::t('auth', 'Update Auth Item Child: {parent}', ['parent' => $model->parent]);
$this->params['breadcrumbs'][] = ['label' => Adm::t('auth', 'Auth Item Children'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->parent, 'url' => ['index']];
$this->params['breadcrumbs'][] = Adm::t('auth', 'Update');
Yii::$app->i18n->resetDot();
?>
<div class="auth-item-child-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
