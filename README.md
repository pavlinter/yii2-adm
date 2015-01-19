Yii2: Adm CMS
================

Установка
------------
Удобнее всего установить это расширение через [composer](http://getcomposer.org/download/).

```
"pavlinter/yii2-adm": "dev-master",
```

Список включающих пакетов
-------------------------
[pavlinter/yii2-dot-translation](https://github.com/pavlinter/yii2-dot-translation)<br/>
[pavlinter/yii2-url-manager](https://github.com/pavlinter/yii2-url-manager)<br/>
[pavlinter/yii2-buttons](https://github.com/pavlinter/yii2-buttons)<br/>
[mihaildev/yii2-ckeditor](https://github.com/MihailDev/yii2-ckeditor)<br/>
[mihaildev/yii2-elfinder](https://github.com/MihailDev/yii2-elfinder)<br/>
[kartik-v/yii2-grid](https://github.com/kartik-v/yii2-grid)<br/>
[kartik-v/yii2-detail-view](https://github.com/kartik-v/yii2-detail-view)<br/>
[kartik-v/yii2-widgets](https://github.com/kartik-v/yii2-widgets)<br/>
[kartik-v/yii2-checkbox-x](https://github.com/kartik-v/yii2-checkbox-x)


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
        /*
        'components' => [
            'manager' => [
                'loginFormClass' => 'pavlinter\adm\models\LoginForm',
                'userClass' => 'pavlinter\adm\models\User',
                'userSearchClass' => 'pavlinter\adm\models\UserSearch',
                'authItemClass' => 'pavlinter\adm\models\AuthItem',
                'authItemSearchClass' => 'pavlinter\adm\models\AuthItemSearch',
                'authRuleClass' => 'pavlinter\adm\models\AuthRule',
                'authRuleSearchClass' => 'pavlinter\adm\models\AuthRuleSearch',
                'authItemChildClass' => 'pavlinter\adm\models\AuthItemChild',
                'authItemChildSearchClass' => 'pavlinter\adm\models\AuthItemChildSearch',
                'authAssignmentClass' => 'pavlinter\adm\models\AuthAssignment',
                'authAssignmentSearchClass' => 'pavlinter\adm\models\AuthAssignmentSearch',
                'languageClass' => 'pavlinter\adm\models\Language',
                'languageSearchClass' => 'pavlinter\adm\models\LanguageSearch',
                'sourceMessageClass' => 'pavlinter\adm\models\SourceMessage',
                'sourceMessageSearchClass' => 'pavlinter\adm\models\SourceMessageSearch',
                'messageClass' => 'pavlinter\adm\models\Message',
            ],
        ],
        */
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
        'langBegin' => ['ru','en'],
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'onlyFriendlyParams' => false,
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

Вход в adm
------------------
```php
http://domain.com/adm
```

Доступ
------------------
```php
username: adm
password: 123456
```

Дополнительный модуль
---------------------
[yii2-adm-pages](https://github.com/pavlinter/yii2-adm-pages)

Как дополнить adm?
---------------------
Генерируешь модуль через gii или создаешь сам.
```php
'modules' => [
    ...
    'adm' => [
        ...
        'modules' => [
            'my_module' // вызываем метод pavlinter\my_module\Module::loading когда adm layout
        ],
        ...
    ],
    'my_module' => [
        'class' => 'pavlinter\my_module\Module',
    ],
    ...
],
```
- Добавить в adm в левое меню свой модуль
```php
public function loading($adm)
{
    if ($adm->user->can('AdmRoot')) {
        $adm->params['left-menu']['my_module'] = [
            'label' => '<i class="fa fa-file-text"></i><span>' . $adm::t('menu', 'My module') . '</span>',
            'url' => ['/my_module/default/index']
        ];
    }
}
```

- Полностью закрыть доступ к модулю.
```php
public function beforeAction($action)
{
    $adm = Adm::register();
    if (!parent::beforeAction($action) || !$adm->user->can('AdmRoot')) {
        return false;
    }
    return true;
}
```

- Частично закрыть доступ к модулю
[beforeAction](https://github.com/pavlinter/yii2-adm-pages/blob/master/admpages/Module.php#L119)<br/>
[Доступ к админке через controller](https://github.com/pavlinter/yii2-adm-pages/blob/master/admpages/controllers/PageController.php#L25)<br/>

- Если публичный модуль, то нужно создавать manager класов.
[Пример](https://github.com/pavlinter/yii2-adm-pages/blob/master/admpages/Module.php#L74)<br/>
[Manager](https://github.com/pavlinter/yii2-adm-pages/blob/master/admpages/ModelManager.php)<br/>