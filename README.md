Yii2: Adm CMS
================

Установка
------------
Удобнее всего установить это расширение через [composer](http://getcomposer.org/download/).

```
"pavlinter/yii2-adm": "dev-master",
```

Настройка
------------------
```php
//console.php
'components' => [
    ...
    'authManager' => [
        'class' => 'yii\rbac\DbManager',
    ],
    ...
],
```

```php
//main.php
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
    'gii' => [
        'class'      => 'yii\gii\Module',
        'generators' => [
            'model'   => [
                'class'     => '\pavlinter\adm\gii\generators\model\Generator',
            ],
            'crud'   => [
                'class'     => '\pavlinter\adm\gii\generators\crud\Generator',
            ],
            'module'   => [
                'class'     => '\pavlinter\adm\gii\generators\module\Generator',
            ],
        ]
    ],
],
'components' => [
    'user' => [
        'identityClass' => 'pavlinter\adm\models\User',
        'enableAutoLogin' => true,
    ],
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
        'dialog' => 'jq',
        'router' => '/adm/source-message/dot-translation',
        'translations' => [
            'app*' => [
                'class' => 'pavlinter\translation\DbMessageSource',
                'forceTranslation' => true,
                'autoInsert' => true,
                'dotMode' => true,
            ],
        ],
    ],
],
```

Запустить миграцию
------------------
```php
yii migrate --migrationPath=@vendor/pavlinter/yii2-adm/adm/migrations
```

Доступ
------------------
```php
username: adm
password: 123456
```
