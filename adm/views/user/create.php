<?php

use yii\helpers\Html;
use pavlinter\adm\Adm;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\User */
/* @var $passwordModel yii\base\DynamicModel */

$this->title = Adm::t('user', 'Create {modelClass}', [
    'modelClass' => 'User',
]);
$this->params['breadcrumbs'][] = ['label' => Adm::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'passwordModel' => $passwordModel,
    ]) ?>

</div>
