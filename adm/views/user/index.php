<?php

use yii\helpers\Html;
use pavlinter\adm\Adm;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Adm::t('user', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index" style="height: 1000px;">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Adm::t('user', 'Create {modelClass}', [
    'modelClass' => 'User',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= Adm::widget('GridView',[
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
            'role',
            'status',
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

