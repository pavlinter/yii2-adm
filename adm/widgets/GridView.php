<?php

namespace pavlinter\adm\widgets;

use pavlinter\adm\NestableAsset;
use Yii;
use yii\helpers\ArrayHelper;

class GridView extends \kartik\grid\GridView
{
    public $export = false;

    public $admNestable = [];

    public function init()
    {

        $nestable = ArrayHelper::merge([
            'dbFields' => [
                'id' => 'id',
                'name' => 'name',
            ],
        ], $this->admNestable);

        NestableAsset::register(Yii::$app->getView());
        $models = $this->dataProvider->getModels();
        if($models) {
            ?>
            <div class="dd" id="nestable1">
                <ol class="dd-list">
                    <?php foreach ($models as $model) {?>
                    <li class="dd-item" data-id="<?= $model->{$nestable['dbFields']['id']} ?>">
                        <div class="dd-handle"><?= $model->{$nestable['dbFields']['name']} ?></div>
                        <ol class="dd-list">
                            
                        </ol>
                    </li>
                    <?php }?>
                </ol>
            </div>
        <?php
        }
        parent::init();
    }
}