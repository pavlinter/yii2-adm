<?php

use pavlinter\adm\Adm;
use pavlinter\adm\models\AuthItem;
use pavlinter\adm\widgets\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel pavlinter\adm\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

Yii::$app->i18n->disableDot();
$this->title = Adm::t('auth', 'Auth Items');
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->i18n->resetDot();
?>
<div class="auth-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Adm::t('auth', 'Create Auth Item'), ['create'], ['class' => 'btn btn-primary']) ?>
    </p>


    <?= Adm::widget('GridView',[
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'type',
                'format'=>'raw',
                'value'=>function ($model, $index, $widget) {
                    return $model::typeList($model->type);
                },
                'filterOptions' => [
                    'style' => 'padding:8px 1px;',
                ],
                'filterType' => GridView::FILTER_SELECT2,
                'filter'=> $searchModel::typeList(),
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ],
                'options' => [
                    'style' => 'width: 120px;',
                ],
            ],
            'description:ntext',
            'rule_name',
            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
                'options' => [
                    'style' => 'width:70px;',
                ],
            ],
        ],
    ]);?>



</div>
