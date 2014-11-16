Yii2: Adm CMS
================

Установка
------------
Удобнее всего установить это расширение через [composer](http://getcomposer.org/download/).

```
"pavlinter/yii2-adm": "@dev",
"pavlinter/yii2-dot-translation": "@dev",
"pavlinter/yii2-url-manager": "@dev",
"mihaildev/yii2-ckeditor": "1.*",
"mihaildev/yii2-elfinder": "1.*",
"kartik-v/yii2-grid": "2.*",
"kartik-v/yii2-widgets": "3.*",
"kartik-v/yii2-checkbox-x": "1.*"
```

Настройка
-------------
```php
'bootstrap' => [
    'urlManager',
    'i18n',
],
'modules' => [
    'adm' => [
        'class' => 'pavlinter\adm\Adm',
        'modules' => [

        ],
    ],
    'gridview'=> [
        'class'=>'\kartik\grid\Module',
    ],
],
'components' => [
    'authManager' => [
        'class' => 'yii\rbac\DbManager',
    ],
    'urlManager' => [
        'class'=>'\pavlinter\urlmanager\UrlManager', //https://github.com/pavlinter/yii2-url-manager
        'enableLang' => true,
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'ruleConfig' => [
            'class' => '\pavlinter\urlmanager\UrlRule',
        ],
        'rules' => []
    ],
    'i18n' => [
        'class'=>'pavlinter\translation\I18N', //https://github.com/pavlinter/yii2-dot-translation
        'access' => function () {
            return Yii::$app->getUser()->can('Adm-Transl');
        },
        'dotCategory' => ['app*' => false],
        'dialog' => 'jq',
        'router' => '/adm/source-message/dot-translation',
        'translations' => [
            'app*' => [
                'class' => 'pavlinter\translation\DbMessageSource',
                'forceTranslation' => true,
                'autoInsert' => true,
            ],
        ],
    ],
],
```

Запустить миграцию
-------------
```php
yii migrate --migrationPath=@vendor/pavlinter/yii2-adm/adm/migrations
```