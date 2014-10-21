<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \pavlinter\adm\models\SourceMessage */

$this->title = Adm::t('source-message', 'Create Source Message');
$this->params['breadcrumbs'][] = ['label' => Adm::t('source-message', 'Source Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="source-message-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
