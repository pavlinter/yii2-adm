Yii2: Adm CMS
================

Установка
------------
Удобнее всего установить это расширение через [composer](http://getcomposer.org/download/).

Либо запустить

```
php composer.phar require --prefer-dist pavlinter/yii2-adm "dev-master"
```

или добавить

```
"pavlinter/yii2-adm": "dev-master"
```

в разделе require вашего composer.json файла.


Запустить миграцию
-------------
```php
    yii migrate --migrationPath=@vendor/pavlinter/adm/migrations
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
    'dynagrid'=> [
        'class'=>'\kartik\dynagrid\Module',
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
            return Yii::$app->getUser()->can('Adm-SourceMessage');
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

Использование
-----
