<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\AuthItem */

$this->title = Adm::t('auth', 'Update Auth Item:') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Adm::t('auth', 'Auth Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = Adm::t('auth', 'Update');
?>
<div class="auth-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
