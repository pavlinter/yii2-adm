<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\AuthRule */
/* @var $dynamicModel yii\base\DynamicModel */

Yii::$app->i18n->disableDot();
$this->title = Adm::t('auth', 'Update Auth Rule: {name}');
$this->params['breadcrumbs'][] = ['label' => Adm::t('auth', 'Auth Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = Adm::t('auth', 'Update');
Yii::$app->i18n->enableDot();
?>
<div class="auth-rule-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'dynamicModel' => $dynamicModel,
    ]) ?>

</div>
