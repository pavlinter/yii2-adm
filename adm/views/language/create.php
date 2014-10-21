<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\Language */

$this->title = Adm::t('language', 'Create Language');
$this->params['breadcrumbs'][] = ['label' => Adm::t('language', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="languages-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
