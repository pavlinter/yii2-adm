<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.0
 */

namespace pavlinter\adm\widgets;

use pavlinter\adm\Adm;
use pavlinter\adm\NestableAsset;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Application;
use yii\web\Request;
use yii\web\Response;


/**
 * Class GridNestable
 */
class GridNestable extends \yii\base\Widget
{
    public $grid;

    public $clientOptions = [];

    public $idCol = 'id';

    public $nameCol = 'name';

    public $weightCol = 'weight';

    public $parentCol = 'id_parent'; //set false if parent field is not exist

    public $btn;

    public $template = '{btn}<div class="dd" id="{nestableId}"><ol class="dd-list">{items}</ol>{pager}</div>';

    public $itemTemplate = '<li class="dd-item dd3-item dd-collapsed" data-id="{id}"><div class="fa-arrows dd-handle dd3-handle"></div><div class="dd3-content"><span class="nestable-loading-{id} fa fa-spinner fa-spin hide"></span>{name} <span class="badge nestable-weight-{id}">{weight}</span>{links}</div><ol class="dd-list"></ol></li>';

    public $buttonsTemplate = '<div class="pull-right">{view} {update} {copy} {delete}</div>';

    public $buttons = [];

    private $_models = [];

    public function init()
    {
        parent::init();

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

        $request = Yii::$app->getRequest();
        $headers = $request->getHeaders();


        $this->initDefaultButtons();

        $pagination = $this->grid->dataProvider->getPagination();


        if (($params = $pagination->params) === null) {
            $params = $request instanceof Request ? $request->getQueryParams() : [];
        }
        $params['nestable'] = 1;
        $pagination->params = $params;

        $this->_models = $this->grid->dataProvider->getModels();
        //ajax
        if (isset($headers['adm-nestable-ajax'])) {
            $output = $this->ajax();

            if (is_array($output)) {
                exit('dd');

            }

            Yii::$app->on(Application::EVENT_AFTER_REQUEST, function ($event) {
                $response = Yii::$app->getResponse();
                if (is_array($event->data['output'])) {
                    exit('dd');
                    $response->data = Json::encode($event->data['output']);
                } else {
                    echo gettype($event->data['output']);
                    $response->data = $event->data['output'];
                }
            },['output' => $output]);
            return null;
        }
        $view = Yii::$app->getView();
        if($this->_models) {
            $this->registerAssets($view);
            $output = strtr($this->template, [
                '{btn}' => $this->renderBtn(),
                '{nestableId}' => $this->id,
                '{items}' => $this->renderItems(),
                '{pager}' => $this->renderPager()
            ]);
            echo $output;
        } else {
            $view->registerJs('
                $(".btn-adm-nestable-view").hide();
            ');
        }
        unset($params['nestable']);
        $pagination->params = $params;
    }

    /**
     * Initializes the default button rendering callbacks
     */
    public function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $that) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'title' => Yii::t('yii', 'View'),
                    'data-pjax' => '0',
                ]);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $that) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'title' => Yii::t('yii', 'Update'),
                    'data-pjax' => '0',
                ]);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $that) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'title' => Yii::t('yii', 'Delete'),
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ]);
            };
        }

        if (!isset($this->buttons['copy'])) {
            $this->buttons['copy'] = function ($url, $that) {
                return Html::a('<span class="fa fa-copy"></span>', [
                    'create',
                    $that->idCol => '{id}'
                ], [
                    'title' => Adm::t('', 'Copy'),
                    'data-pjax' => '0',
                ]);
            };
        }

        if (!isset($this->buttons['copy'])) {
            $this->buttons['copy'] = function ($url, $that) {
                return Html::a('<span class="fa fa-copy"></span>', [
                    'index',
                    $that->idCol => '{id}'
                ], [
                    'title' => Adm::t('', 'Copy'),
                    'data-pjax' => '0',
                ]);
            };
        }
    }

    /**
     * @param $view
     */
    public function registerAssets($view)
    {
        NestableAsset::register($view);
        $view->registerJs('
                $("#' . $this->id . '").nestable(' . Json::encode($this->clientOptions) .');

                var nestableItemTemplate    = \'' . $this->itemTemplate . '\';
                var nestableLinksTemplate   = \'' . $this->renderLinks() . '\';
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
                            data: {id_parent: id},
                            beforeSend: function (request){
                                request.setRequestHeader("adm-nestable-ajax", "1");
                            },
                        }).done(function(d){
                            if(d.r){
                                var lis = [];
                                for (var i in d.items) {
                                  var html = nestableItemTemplate.replace(/\{links\}/g, nestableLinksTemplate).replace(/\{id\}/g, d.items[i].id).replace(/\{name\}/g, d.items[i].name).replace(/\{weight\}/g, d.items[i].weight);
                                  var $li = $(html);
                                  $li.prepend($(that.options.expandBtnHTML));
                                  $li.prepend($(that.options.collapseBtnHTML));
                                  $li.children("[data-action=\"collapse\"]").hide();
                                  var event = $.Event("appendItem");
                                  $this.trigger(event,[$li, d.items[i]]);
                                  if(event.result !== false){
                                    lis.push($li);
                                  }
                                }
                                $($item).children("." + that.options.listClass).prepend(lis);

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
                            data: {items: items}
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
                });

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

    public function ajax()
    {
        $id_parent = Yii::$app->getRequest()->post('id_parent');

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

    /**
     * @return string
     */
    public function renderItems()
    {
        $links = $this->renderLinks();
        $res = '';
        foreach ($this->_models as $model) {
            $res .= strtr($this->itemTemplate, [
                '{id}' => $model->{$this->idCol},
                '{name}' => $model->{$this->nameCol},
                '{weight}' => $model->{$this->weightCol},
                '{links}' => strtr($links, ['{id}' => $model->{$this->idCol}])
            ]);
        }
        return $res;
    }

    /**
     * @param $model
     * @return string
     */
    public function renderLinks()
    {
        static $links;
        if ($links !== null) {
            return $links;
        }
        $links = $this->buttonsTemplate;
        foreach ($this->buttons as $name => $func) {
            if (is_callable($func)) {
                $url['0'] = $name;
                $url[$this->idCol] = '{id}';
                $links = strtr($links, [
                    '{' . $name . '}' => call_user_func_array($func,['url' => $url, 'that' => $this]),
                ]);
            }
        }
        return $links;
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
