<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;
use pavlinter\adm\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel pavlinter\adm\models\AuthAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Adm::t('auth', 'Auth Assignments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-assignment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Adm::t('auth', 'Create {modelClass}', [
    'modelClass' => 'Auth Assignment',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= Adm::widget('GridView',[
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'item_name',
            [
                'attribute' => 'user_id',
                'value'=> function ($model, $index, $widget) {
                    if ($model->user) {
                        return $model->user->username;
                    }
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
    ]);?>


</div>
