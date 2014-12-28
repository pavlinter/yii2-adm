<?php

use yii\helpers\Html;
use pavlinter\adm\Adm;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\User */
/* @var $dynamicModel yii\base\DynamicModel */
/* @var $authItems array */
Yii::$app->i18n->disableDot();
$this->title = Adm::t('user', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Adm::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->i18n->resetDot();
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'dynamicModel' => $dynamicModel,
        'authItems' => $authItems,
    ]) ?>

</div>
