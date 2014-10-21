<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\AuthAssignment */

$this->title = Adm::t('auth', 'Create {modelClass}', [
    'modelClass' => 'Auth Assignment',
]);
$this->params['breadcrumbs'][] = ['label' => Adm::t('auth', 'Auth Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-assignment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
