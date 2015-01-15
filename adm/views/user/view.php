<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use pavlinter\adm\Adm;

/* @var $this yii\web\View */
/* @var $model pavlinter\adm\models\User */
Yii::$app->i18n->disableDot();
$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Adm::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->i18n->resetDot();
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Adm::t('user', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?php if (!Adm::getInstance()->user->can('Adm-UpdateOwnUser', $model)) {?>
            <?= Html::a(Adm::t('user', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Adm::t('user', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php }?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email:email',
            [
                'label' => 'role',
                'value' => $model->roles($model->role),
            ],
            [
                'label' => 'status',
                'value' => $model->status($model->status),
            ],
            [
                'label' => 'updated_at',
                'value' => Yii::$app->formatter->asDate($model->updated_at),
            ],
            [
                'label' => 'created_at',
                'value' => Yii::$app->formatter->asDate($model->created_at),
            ],
        ],
    ]) ?>

</div>
