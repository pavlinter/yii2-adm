<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.0
 */

namespace pavlinter\adm\actions;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * Class GridNestableAction
 */
class GridNestableAction extends Action
{
    public $idCol = 'id';

    public $nameCol = 'name';

    public $weightCol = 'weight';

    public $parentCol = 'id_parent'; //set false if parent field is not exist

    public $model;

    public $order = SORT_ASC;

    /**
     * Initializes the action.
     * @throws InvalidConfigException if the font file does not exist.
     */
    public function init()
    {
        if ($this->model === null) {
            throw new InvalidConfigException('The "model" property must be set!');
        }
    }
    /**
     * Runs the action.
     */
    public function run($id_parent = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($id_parent) {
            if (!$this->parentCol) {
                $json['r'] = 0;
                return $json;
            }
            /* @var \yii\db\ActiveQuery $query */
            $query = forward_static_call([$this->model, 'find']);
            $models = $query->where([$this->parentCol => $id_parent])->orderBy([$this->weightCol => $this->order])->all();
            $json['items'] = [];
            foreach ($models as $model) {
                $json['items'][] = [
                    'id' => $model->{$this->idCol},
                    'name' => $model->{$this->nameCol},
                    'weight' => $model->{$this->weightCol}
                ];
            }
            $json['r'] = 1;
            return $json;
        }

        $items = Yii::$app->getRequest()->post('items');
        if (!empty($items)) {
            $weight = [];
            $this->step($weight, $items);
            return ['r' => 1, 'weight' => $weight];
        }
    }

    /**
     * @param $items
     * @param null $id_parent
     */
    public function step(&$json, $items, $id_parent = null)
    {
        foreach ($items as $item) {
            if(!empty($item['children'])) {
                $this->step($json, $item['children'], $item['id']);
            }
        }

        $ids = ArrayHelper::getColumn($items, 'id');

        /* @var \yii\db\ActiveQuery $query */
        $query = forward_static_call([$this->model, 'find']);
        $models = $query->select(['id' => $this->idCol, 'weight' => $this->weightCol])->where([$this->idCol => $ids])->orderBy([$this->weightCol => $this->order])->indexBy($this->idCol)->all();

        $weight = ArrayHelper::getColumn($models, $this->weightCol, false);


        foreach ($ids as $i => $id) {
            if (isset($weight[$i], $models[$id])) {
                $json[$id] = $weight[$i];
                $models[$id]->{$this->weightCol} = $weight[$i];
                if ($this->parentCol) {
                    $models[$id]->{$this->parentCol} = $id_parent;
                }
                $models[$id]->save(false);
            }
        }
    }
}
