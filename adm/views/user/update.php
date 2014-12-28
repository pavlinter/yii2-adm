<?php

use yii\helpers\Html;
use pavlinter\adm\Adm;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\User */
/* @var $dynamicModel yii\base\DynamicModel */

Yii::$app->i18n->disableDot();
if (Adm::getInstance()->user->can('Adm-UpdateOwnUser', $model)) {
    $this->title = Adm::t('user', 'My Profile');
} else {
    $this->title = Adm::t('user', 'Update User: {id}', ['id' => $model->id]);
    $this->params['breadcrumbs'][] = ['label' => Adm::t('user', 'Users'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = Adm::t('user', 'Update');
}
Yii::$app->i18n->resetDot();
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'dynamicModel' => $dynamicModel,
    ]) ?>

</div>
