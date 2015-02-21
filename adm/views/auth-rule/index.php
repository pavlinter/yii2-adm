<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel pavlinter\adm\models\AuthRuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

Yii::$app->i18n->disableDot();
$this->title = Adm::t('auth', 'Auth Rules');
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->i18n->resetDot();
?>
<div class="auth-rule-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?= Html::a(Adm::t('auth', 'Create Auth Rule'), ['create'], ['class' => 'btn btn-primary']) ?>
    </p>


    <?= Adm::widget('GridView',[
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'name',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
                'width' => '70px',
            ],

        ],
    ]);?>



</div>
