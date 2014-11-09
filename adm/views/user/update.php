<?php

use yii\helpers\Html;
use pavlinter\adm\Adm;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\User */
/* @var $passwordModel yii\base\DynamicModel */


if (Adm::getInstance()->user->can('Adm-UpdateOwnUser', $model)) {
    $this->title = Adm::t('user', 'My Profile');
} else {
    $this->title = Adm::t('user', 'Update {modelClass}: ', [
            'modelClass' => 'User',
        ]) . ' ' . $model->id;
    $this->params['breadcrumbs'][] = ['label' => Adm::t('user', 'Users'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = Adm::t('user', 'Update');
}


?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'passwordModel' => $passwordModel,
    ]) ?>

</div>
