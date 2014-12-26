<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel \pavlinter\adm\models\SourceMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
Yii::$app->i18n->disableDot();
$this->title = Adm::t('source-message', 'Source Messages');
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->i18n->enableDot();
?>


<div class="source-message-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?= Html::a(Adm::t('source-message', 'Create Source Message'), ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= Adm::widget('GridView',[
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'category',
            'message',
            [
                'attribute' => 'translation',
                'format' => 'raw',
                'value'=> function ($model, $index, $widget) {
                    return Yii::t($model->category,$model->message,['dot' => true]);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'options' => [
                    'style' => 'width:70px;',
                ],
            ],
        ],
    ]); ?>

</div>
