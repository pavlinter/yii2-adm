<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.1
 */

namespace pavlinter\adm\widgets;

use pavlinter\adm\Adm;
use pavlinter\adm\NestableAsset;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Request;
use yii\web\Response;


/**
 * Class GridNestable
 */
class GridNestable extends \yii\base\Widget
{
    public $grid;

    public $clientOptions = [];

    public $tableAlias;

    public $idCol = 'id';

    public $nameCol = 'name';

    public $weightCol = 'weight';

    public $parentCol = 'id_parent'; //set false if parent field is not exist

    public $orderBy = SORT_DESC;

    public $btn;

    public $template = '{btn}<div class="dd hide" id="{nestableId}"><ol class="dd-list">{items}</ol>{pager}</div>';

    public $itemTemplate = '<li class="dd-item dd3-item dd-collapsed" data-id="{id}"><div class="fa-arrows dd-handle dd3-handle"></div><div class="dd3-content"><span class="nestable-loading nestable-loading-{id} fa fa-spinner fa-spin hide"></span>{name} <span class="badge nestable-weight-{id}">{weight}</span><div class="pull-right">{links}</div></div><ol class="dd-list"></ol></li>';
    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     */
    public function init()
    {
        parent::init();

        $request = Yii::$app->getRequest();
        $headers = $request->getHeaders();

        //ajax
        if (isset($headers['adm-nestable-ajax'])) {
            $this->ajax();
        } else {
            $view = $this->getView();

            if ($this->btn === null || $this->btn === false) {
                $this->btn = Html::tag('button', '', [
                    'class' => 'btn btn-primary btn-adm-nestable' . ($this->btn === false? ' hide' : ''),
                    'data' => [
                        'is-nestable' => Yii::$app->getRequest()->get('nestable', 0),
                        'gridview-text' => Adm::t('', 'Search',['dot' => false]),
                        'nestable-text' => Adm::t('', 'Sort',['dot' => false]),
                    ],
                ]);
            }
            $pagination = $this->grid->dataProvider->getPagination();

            if (($params = $pagination->params) === null) {
                $params = $request instanceof Request ? $request->getQueryParams() : [];
            }
            $params['nestable'] = 1;
            $pagination->params = $params;

            $models = $this->grid->dataProvider->getModels();
            if(!$models) {
                $view->registerJs('$(".btn-adm-nestable-view").hide();');
                return null;
            }
            $keys = $this->grid->dataProvider->getKeys();
            $this->registerAssets($view);
            $output = strtr($this->template, [
                '{btn}' => $this->renderBtn(),
                '{nestableId}' => $this->id,
                '{items}' => $this->renderItems($models, $keys),
                '{pager}' => $this->renderPager()
            ]);
            echo $output;
            unset($params['nestable']);
            $pagination->params = $params;
        }
    }

    /**
     * @return array|string
     */
    public function ajax()
    {
        $id_parent = Yii::$app->getRequest()->get('nestable_id_parent');
        $items = Yii::$app->getRequest()->post('nestable_items');
        $json['r'] = 0;

        if ($this->tableAlias === null) {
            $query = $this->grid->dataProvider->query;
            if (is_array($query->from)) {
                foreach ($query->from as $k => $table) {
                    if (is_integer($k)) {
                        $this->tableAlias = $table . '.';
                    } else {
                        $this->tableAlias = $k . '.';
                    }
                    break;
                }
            } else {
                if ($query->from) {
                    $this->tableAlias = $query->from . '.';
                }
            }
        } else if($this->tableAlias = false){
            $this->tableAlias = '';
        } else {
            $this->tableAlias .= '.';
        }


        if ($id_parent) {
            if ($this->parentCol) {
                $query = $this->getQuery()
                    ->where([$this->parentCol => $id_parent]);

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => false,
                    'sort' => [
                        'defaultOrder' => [
                            $this->weightCol => $this->orderBy,
                        ],
                    ],
                ]);

                $models = $dataProvider->getModels();
                $keys = $dataProvider->getKeys();
                $json['r'] = 1;
                $json['items'] = $this->renderItems($models, $keys);
            }
        } elseif (!empty($items)){
            $weight = [];
            $this->step($weight, $items);
            $json = ['r' => 1, 'weight' => $weight];
        }
        // only need the content enclosed within this widget
        $response = Yii::$app->getResponse();
        $response->clearOutputBuffers();
        $response->setStatusCode(200);
        $response->format = Response::FORMAT_JSON;
        $response->data = $json;
        $response->send();
        Yii::$app->end();
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

        $query = $this->getQuery();
        $models = $query->select(['id' => $this->tableAlias . $this->idCol, 'weight' => $this->tableAlias . $this->weightCol])
            ->where([$this->tableAlias . $this->idCol => $ids])
            ->orderBy([$this->tableAlias . $this->weightCol => $this->orderBy])
            ->indexBy($this->idCol)
            ->all();

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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuery()
    {
        return clone $this->grid->dataProvider->query;
    }

    /**
     * @param $view
     */
    public function registerAssets($view)
    {
        NestableAsset::register($view);
        $view->registerJs('
                $("#' . $this->id . '").nestable(' . Json::encode($this->clientOptions) .');
                var parentDisabled = ' . ($this->parentCol? 'true' : 'false') .';
                var nestableSerialize       = $("#' . $this->id . '").nestable("serialize");
                var nestableLoadingItem = function(id, showLoading){
                    var $loading = $(".nestable-loading-" + id);
                    if (showLoading){
                        $loading.removeClass("hide");
                    } else {
                        $loading.addClass("hide");
                    }
                    return $loading;
                }
                if(!parentDisabled){
                    $(".dd-item").find("[data-action=\'collapse\'],[data-action=\'expand\']").remove();
                }

                $("#' . $this->id . '").on("touchclick", function(e,that,action,$target, $item){
                    if(action == "expand"){
                        var id = $item.attr("data-id");
                        var $this = $(this);

                        $collapse = $item.children("[data-action=\"collapse\"]").hide();
                        nestableLoadingItem(id,true);

                        $.ajax({
                            url: "' . Url::to(Yii::$app->request->url) . '",
                            type: "get",
                            dataType: "json",
                            data: {nestable_id_parent: id},
                            beforeSend: function (request){
                                request.setRequestHeader("adm-nestable-ajax", "1");
                            },
                        }).done(function(d){
                            if(d.r){
                                $children = $($item).children("." + that.options.listClass);
                                $children.prepend(d.items);
                                $children.children("li").prepend($(that.options.expandBtnHTML)).prepend($(that.options.collapseBtnHTML)).children("[data-action=\"collapse\"]").hide();
                            }
                        }).always(function(jqXHR, textStatus){
                            nestableLoadingItem(id, false);
                            $collapse.show();
                            if (textStatus !== "success") {

                            }
                        }).fail(function(jqXHR, textStatus, message){
                            alert(message);
                        });
                    } else {
                        $("." + that.options.listClass, $item).empty();
                    }

                });

                $("#' . $this->id . '").on("change", function(e,el) {
                    var id = $(el).attr("data-id");
                    var $this = $(this);
                    var items = $this.nestable("serialize");
                    if(JSON.stringify(items) == JSON.stringify(nestableSerialize)){
                        return;
                    }
                    nestableLoadingItem(id, true);

                    nestableSerialize = items;
                    $.ajax({
                            url: "' . Url::to(Yii::$app->request->url) . '",
                            type: "POST",
                            dataType: "json",
                            data: {nestable_items: items, "' . Yii::$app->request->csrfParam . '": "' . Yii::$app->request->getCsrfToken() . '"},
                            beforeSend: function (request){
                                request.setRequestHeader("adm-nestable-ajax", "1");
                            },
                        }).done(function(d){
                            if(d.error){
                               alert(error);
                            }
                            if (d.weight){
                                for (var i in d.weight) {
                                    $(".nestable-weight-" + i, $this).text(d.weight[i]);
                                }
                            }
                        }).always(function(jqXHR, textStatus){
                            nestableLoadingItem(id, false);
                            if (textStatus !== "success") {

                            }
                        }).fail(function(jqXHR, textStatus, message){
                            alert(message);
                        });

                });


                $("#' . $this->grid->id . ',#' . $this->id . '").addClass("hide");
                $(".btn-adm-nestable-view").on("click", function(e){
                    $(".btn-adm-nestable").trigger("click");
                    return false;
                }).show();

                $(".btn-adm-nestable").on("click", function(e){
                    var $this = $(this);
                    var isNestable = parseInt($this.attr("data-is-nestable"));
                    var text = isNestable ? $this.attr("data-gridview-text") : $this.attr("data-nestable-text");

                    if(isNestable){
                        $("#' . $this->grid->id . '").addClass("hide");
                        $("#' . $this->id . '").removeClass("hide");
                        $this.attr("data-is-nestable", 0);
                    } else {
                        $("#' . $this->id . '").addClass("hide");
                        $("#' . $this->grid->id . '").removeClass("hide");
                        $this.attr("data-is-nestable", 1);
                    }
                    $this.text(text);
                    $(".btn-adm-nestable-view").text(text);
                    return false;
                }).trigger("click");

            ');
    }


    /**
     * @param $models array
     * @param $keys array
     * @return null|string
     */
    public function renderItems($models, $keys)
    {
        $columns = $this->grid->columns;
        $actionColumn = null;
        foreach ($columns as $column) {
            if ($column instanceof \yii\grid\ActionColumn) {
                $actionColumn = $column;
                break;
            }
        }
        if ($actionColumn === null) {
            return null;
        }
        $res = '';
        $models = array_values($models);
        foreach ($models as $index => $model) {
            $key = $keys[$index];
            $res .= strtr($this->itemTemplate, [
                '{id}' => $model->{$this->idCol},
                '{name}' => $model->{$this->nameCol},
                '{weight}' => $model->{$this->weightCol},
                '{links}' => $this->renderLinks($actionColumn, $model, $key, $index)
            ]);
        }
        return $res;
    }


    /**
     * @param $actionColumn
     * @param $model
     * @param $key
     * @param $index
     * @return mixed
     */
    public function renderLinks($actionColumn , $model, $key, $index)
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($actionColumn, $model, $key, $index) {
            $name = $matches[1];
            if (isset($actionColumn->buttons[$name])) {
                $url = $actionColumn->createUrl($name, $model, $key, $index);

                return call_user_func($actionColumn->buttons[$name], $url, $model, $key);
            } else {
                return '';
            }
        }, $actionColumn->template);
    }
    /**
     * @return string
     */
    public function renderBtn()
    {
        return $this->btn;
    }

    /**
     * @return string
     */
    public function renderPager()
    {
        return $this->grid->renderPager();
    }
}
