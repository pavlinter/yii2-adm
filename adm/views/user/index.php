<?php

use pavlinter\adm\widgets\GridView;
use yii\helpers\Html;
use pavlinter\adm\Adm;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
Yii::$app->i18n->disableDot();
$this->title = Adm::t('user', 'Users');
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->i18n->resetDot();
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Adm::t('user', 'Create User'), ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= Adm::widget('GridView',[
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'username',
            'email:email',
            [
                'attribute' => 'role',
                'vAlign' => 'middle',
                'value' => function ($model, $key, $index, $widget) {
                    return $model::roles($model->role);
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter'=> $searchModel::roles(),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' =>true ],
                ],
                'filterInputOptions' => ['placeholder' => Adm::t('','Select ...', ['dot' => false])],
                'format' => 'raw'
            ],
            [
                'attribute' => 'status',
                'vAlign' => 'middle',
                'value' => function ($model, $key, $index, $widget) {
                    return $model::status($model->status);
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter'=> $searchModel::status(),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' =>true ],
                ],
                'filterInputOptions' => ['placeholder' => Adm::t('','Select ...', ['dot' => false])],
                'format' => 'raw'
            ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        if ($model->id == Adm::getInstance()->user->getId()) {
                            return null;
                        }
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    }
                ],

            ],
        ],
    ]); ?>
</div>

