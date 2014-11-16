<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel pavlinter\adm\models\LanguageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Adm::t('language', 'Languages');
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="languages-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Adm::t('language', 'Create Language'), ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= Adm::widget('GridView',[
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value'=> function ($model, $index, $widget) {
                    if ($model->image) {
                        return Html::img($model->image,['style' => 'max-width: 100px;max-height:100px;']);
                    }
                },
                'options' => [
                    'style' => 'width:100px;',
                ],
            ],
            'name',
            'code',
            [
                'class' => '\kartik\grid\BooleanColumn',
                'attribute' => 'active',
            ],
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
