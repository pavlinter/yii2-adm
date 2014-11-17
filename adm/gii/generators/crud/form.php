<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\crud\Generator */
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
echo $form->field($generator, 'baseControllerClass');
echo $form->field($generator, 'moduleID');
echo $form->field($generator, 'enableLanguage')->checkbox();
echo $form->field($generator, 'indexWidgetType')->dropDownList([
    'admGrid' => 'Adm GridView',
    'grid' => 'GridView',
    'list' => 'ListView',
]);

echo $form->field($generator, 'languagePanelType')->dropDownList([
    'panelTab' => 'Panel-Tab',
    'panelToggle' => 'Panel-Toggle',
]);


echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');
