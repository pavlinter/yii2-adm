<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel pavlinter\adm\models\AuthItemChildSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

Yii::$app->i18n->disableDot();
$this->title = Adm::t('auth', 'Auth Item Children');
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->i18n->enableDot();
?>
<div class="auth-item-child-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?= Html::a(Adm::t('auth', 'Create Auth Item Child'), ['create'], ['class' => 'btn btn-primary']) ?>
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
