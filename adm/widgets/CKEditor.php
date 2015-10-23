<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.8
 */

namespace pavlinter\adm\widgets;

use mihaildev\ckeditor\Assets;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * Class CKEditor
 */
class CKEditor extends InputWidget{

    public $initOnEvent = false; //"focus"

    public $editorOptions = [];
    public $containerOptions = [];
    private $_inline = false;

    public function init()
    {
        parent::init();

        if (array_key_exists('inline', $this->editorOptions)) {
            $this->_inline = $this->editorOptions['inline'];
            unset($this->editorOptions['inline']);
        }

        if (array_key_exists('preset', $this->editorOptions)) {
            if($this->editorOptions['preset'] == 'basic'){
                $this->presetBasic();
            }elseif($this->editorOptions['preset'] == 'standard'){
                $this->presetStandard();
            }elseif($this->editorOptions['preset'] == 'full'){
                $this->presetFull();
            }
            unset($this->editorOptions['preset']);
        }

        if($this->_inline && !isset($this->editorOptions['height']))
            $this->editorOptions['height'] = 100;

        if($this->_inline && !isset($this->containerOptions['id']))
            $this->containerOptions['id'] = $this->id.'_inline';
    }

    private function presetBasic(){
        $options['height'] = 100;

        $options['toolbarGroups'] = [
            ['name' => 'undo'],
            ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
            ['name' => 'colors'],
            ['name' => 'links', 'groups' => ['links', 'insert']],
            ['name' => 'others','groups' => ['others', 'about']],
        ];
        $options['removeButtons'] = 'Subscript,Superscript,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe';
        $options['removePlugins'] = 'elementspath';
        $options['resize_enabled'] = false;


        $this->editorOptions = ArrayHelper::merge($options, $this->editorOptions);
    }

    private function presetStandard(){
        $options['height'] = 300;

        $options['toolbarGroups'] = [
            ['name' => 'clipboard', 'groups' => ['mode','undo', 'selection', 'clipboard','doctools']],
            ['name' => 'editing', 'groups' => ['tools', 'about']],
            '/',
            ['name' => 'paragraph', 'groups' => ['templates', 'list', 'indent', 'align']],
            ['name' => 'insert'],
            '/',
            ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
            ['name' => 'colors'],
            ['name' => 'links'],
            ['name' => 'others'],
        ];

        $options['removeButtons'] = 'Smiley,Iframe';

        if($this->_inline){
            $options['extraPlugins'] = 'sourcedialog';
            $options['removePlugins'] = 'sourcearea';
        }

        $this->editorOptions = ArrayHelper::merge($options, $this->editorOptions);
    }



    private function presetFull(){
        $options['height'] = 400;

        $options['toolbarGroups'] = [
            ['name' => 'clipboard', 'groups' => ['mode','undo', 'selection', 'clipboard', 'doctools']],
            ['name' => 'editing', 'groups' => ['find', 'spellchecker', 'tools', 'about']],
            '/',
            ['name' => 'paragraph', 'groups' => ['templates', 'list', 'indent', 'align']],
            ['name' => 'forms'],
            '/',
            ['name' => 'styles'],
            ['name' => 'blocks'],
            '/',
            ['name' => 'basicstyles', 'groups' => ['basicstyles', 'colors','cleanup']],
            ['name' => 'links', 'groups' => ['links', 'insert']],
            ['name' => 'others'],
        ];

        if($this->_inline){
            $options['extraPlugins'] = 'sourcedialog';
            $options['removePlugins'] = 'sourcearea';
        }

        $this->editorOptions = ArrayHelper::merge($options, $this->editorOptions);
    }

    public function run()
    {
        Assets::register($this->getView());

        echo Html::beginTag('div', $this->containerOptions);
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }

        echo Html::endTag('div');
        $js = [
            'mihaildev.ckEditor.registerOnChange('.Json::encode($this->options['id']).');'
        ];

        if(isset($this->editorOptions['filebrowserUploadUrl']))
            $js[] = "mihaildev.ckEditor.registerCsrf();";

        if(!isset($this->editorOptions['on']['instanceReady']))
            $this->editorOptions['on']['instanceReady'] = new JsExpression("function( ev ){".implode(' ', $js)."}");

        if($this->_inline){
            $JavaScript = "CKEDITOR.inline(";
            $JavaScript .= Json::encode($this->options['id']);
            $JavaScript .= empty($this->editorOptions) ? '' : ', '.Json::encode($this->editorOptions);
            $JavaScript .= ");";
            $this->getView()->registerCss('#'.$this->containerOptions['id'].', #'.$this->containerOptions['id'].' .cke_textarea_inline{height: '.$this->editorOptions['height'].'px;}');
        }else{
            $JavaScript = "CKEDITOR.replace(";
            $JavaScript .= Json::encode($this->options['id']);
            $JavaScript .= empty($this->editorOptions) ? '' : ', '.Json::encode($this->editorOptions);
            $JavaScript .= ");";
        }
        if ($this->initOnEvent) {
            $JavaScript = 'jQuery("#'.$this->options['id'].'").one("' . $this->initOnEvent . '", function(){' . $JavaScript . '});';
            JqueryAsset::register($this->getView());
        }
        $this->getView()->registerJs($JavaScript, View::POS_END);
    }

}
