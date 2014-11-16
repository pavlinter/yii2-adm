<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel pavlinter\adm\models\AuthItemChildSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Adm::t('auth', 'Auth Item Children');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-child-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?= Html::a(Adm::t('auth', 'Create {modelClass}', [
    'modelClass' => 'Auth Item Child',
]), ['create'], ['class' => 'btn btn-primary']) ?>
    </p>


    <?= Adm::widget('GridView',[
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'parent',
            'child',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'options' => [
                    'style' => 'width:70px;',
                ],
            ],
        ],
    ]);?>


</div>
