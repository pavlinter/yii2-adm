<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\AuthItem */

$this->title = Adm::t('auth', 'Create Auth Item');
$this->params['breadcrumbs'][] = ['label' => Adm::t('auth', 'Auth Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
