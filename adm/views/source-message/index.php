<?php

use pavlinter\adm\Adm;
use pavlinter\urlmanager\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel \pavlinter\adm\models\SourceMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
Yii::$app->i18n->disableDot();
$this->title = Adm::t('source-message', 'Source Messages');
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->i18n->resetDot();
?>


<div class="source-message-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="pull-right">
        <?= Html::a(Adm::t('source-message', 'Load All Translation'), ['load-translations'], ['class' => 'btn btn-primary', 'data-method' => 'post']) ?>
    </div>

    <p>
        <?= Html::a(Adm::t('source-message', 'Create Source Message'), ['create'], ['class' => 'btn btn-primary']) ?>


        <?php if (Yii::$app->request->get('is-empty')) {?>
            <?= Html::a(Adm::t('source-message', 'Only not translation(disable)'), Url::current(['is-empty' => null]), ['class' => 'btn btn-danger']) ?>
        <?php } else {?>
            <?= Html::a(Adm::t('source-message', 'Only not translation'), Url::current(['is-empty' => 1]), ['class' => 'btn btn-primary']) ?>
        <?php }?>



    </p>

    <?= Adm::widget('GridView',[
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'category',
            'message',
            [
                'attribute' => 'translation',
                'format' => 'raw',
                'value'=> function ($model, $index, $widget) {
                    $text = Html::encode(Yii::t($model->category,$model->message,['dot' => false]));
                    $dot  = Yii::t($model->category,$model->message,['dot' => '.']);
                    return $text . $dot;
                },
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
                'width' => '70px',
            ],
        ],
    ]); ?>

</div>
