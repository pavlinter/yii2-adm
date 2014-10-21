<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\AuthAssignment */

$this->title = Adm::t('auth', 'Update {modelClass}: ', [
    'modelClass' => 'Auth Assignment',
]) . ' ' . $model->item_name;
$this->params['breadcrumbs'][] = ['label' => Adm::t('auth', 'Auth Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->item_name, 'url' => ['index']];
$this->params['breadcrumbs'][] = Adm::t('auth', 'Update');
?>
<div class="auth-assignment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
