<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel pavlinter\adm\models\AuthRuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Adm::t('auth', 'Auth Rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-rule-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?= Html::a(Adm::t('auth', 'Create {modelClass}', [
    'modelClass' => 'Auth Rule',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= Adm::widget('GridView',[
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
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
