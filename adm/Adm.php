<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 2.0.1
 */

namespace pavlinter\adm;

use pavlinter\translation\I18N;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * @property \yii\web\User $user
 * @property \pavlinter\adm\ModelManager $manager
 */
class Adm extends \yii\base\Module
{
    const VERSION = '2.0.1';
    /**
     * @event Event an event that is triggered by [[beginPage()]].
     */
    const EVENT_BEGIN_PAGE = 'beginPage';
    /**
     * @event Event an event that is triggered by [[endPage()]].
     */
    const EVENT_END_PAGE = 'endPage';
    /**
     * @event Event an event that is triggered by [[beginBody()]].
     */
    const EVENT_BEGIN_BODY = 'beginBody';
    /**
     * @event Event an event that is triggered by [[endBody()]].
     */
    const EVENT_END_BODY = 'endBody';

    const EVENT_INNER_PROFILE_MENU  = 'innerProfileMenu';

    const EVENT_FOOTER  = 'footer';

    const EVENT_TOP_MENU  = 'topMenu';

    const EVENT_INIT_LEFT_MENU  = 'initLeftMenu';

    const EVENT_BEFORE_LEFT_MENU  = 'beforeLeftMenu';

    const EVENT_AFTER_LEFT_MENU  = 'afterLeftMenu';

    const EVENT_RIGHT_MENU  = 'rightMenu';

    public $controllerNamespace = 'pavlinter\adm\controllers';

    public $layout = 'main';

    public $widgets = [];

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, $config = [])
    {
        $this->registerTranslations();
        $config = ArrayHelper::merge([
            'aliases' => [
                '@admRoot' => '@vendor/pavlinter/yii2-adm/adm',
            ],
            'controllerMap' => [
                'elfinder' => true
            ],
            'components' => [
                'manager' => [
                    'class' => 'pavlinter\adm\ModelManager'
                ],
                'user' => Yii::$app->getUser(),
            ],
        ], $config);

        parent::__construct($id, $parent, $config);
    }
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params = ArrayHelper::merge($this->params(), $this->params);

        if (is_callable($this->controllerMap['elfinder'])) {
            $this->controllerMap['elfinder'] = call_user_func($this->controllerMap['elfinder'], $this->elfinderConfig());
        } else if ($this->controllerMap['elfinder'] === true) {
            $this->controllerMap['elfinder'] = $this->elfinderConfig();
        }

        $this->get('user')->loginUrl = [$this->id . '/default/login'];

        $this->widgets = ArrayHelper::merge([
            'FileManager' => '\pavlinter\adm\widgets\FileManager',
            'FileInput' => '\pavlinter\adm\widgets\FileInput',
            'GridView' => '\pavlinter\adm\widgets\GridView',
            'DetailView' => '\pavlinter\adm\widgets\DetailView',
            'Redactor' => '\pavlinter\adm\widgets\Redactor',
            'ActiveForm' => '\pavlinter\adm\widgets\ActiveForm',
            'Alert' => '\pavlinter\adm\widgets\Alert',
        ],$this->widgets);


        $modules = $this->getModules();
        foreach ($modules as $name => $module) {
            if (is_integer($name)) {
                $module = Yii::$app->getModule($module);
            } else {
                $module = $this->getModule($name);
            }
            if ($module instanceof AdmBootstrapInterface) {
                $module->loading($this);
            }
        }
    }


    /**
     * Initialization Adm settings
     * @return \pavlinter\adm\Adm
     */
    public static function register()
    {
        static $registered;
        $adm = Yii::$app->getModule('adm');
        if ($registered === null) {
            //override default error handler
            $handler = Yii::$app->getErrorHandler();
            $handler->errorAction = '/' . $adm->id . '/default/error';

            if (Yii::$app->getUrlManager() instanceof \pavlinter\urlmanager\UrlManager) {
                Yii::$app->getUrlManager()->onlyFriendlyParams = false;
            }
            Yii::$app->getI18n()->dialog = I18N::DIALOG_BS;
            $registered = true;
        }
        return $adm;
    }

    /**
     * @return self
     */
    public static function getInst()
    {
        return Yii::$app->getModule('adm');
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        static::register();
        return parent::beforeAction($action);
    }

    /**
     *
     */
    public function registerTranslations()
    {
        if (!isset(Yii::$app->i18n->translations['adm*'])) {
            Yii::$app->i18n->translations['adm*'] = [
                'class' => 'pavlinter\translation\DbMessageSource',
                'forceTranslation' => true,
                'autoInsert' => true,
                'dotMode' => true,
            ];
        }
        if (!isset(Yii::$app->i18n->translations['modelAdm*'])) {
            Yii::$app->i18n->translations['modelAdm*'] = [
                'class' => 'pavlinter\translation\DbMessageSource',
                'forceTranslation' => true,
                'autoInsert' => true,
                'dotMode' => false,
            ];
        }
    }

    /**
     * @param $class
     * @param array $config
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public static function widget($class, $config = [])
    {
        $adm = static::getInstance();
        if ($adm === null) {
            $adm = Yii::$app->getModule('adm');
        }
        $widgets = $adm->widgets;
        if (isset($widgets[$class])) {
            $config['class'] = $widgets[$class];
        } else {
            $config['class'] = $class;
        }
        $widget = Yii::createObject($config);
        return $widget->run();
    }

    /**
     * @param $class
     * @param array $config
     * @return mixed
     */
    public static function begin($class, $config = [])
    {
        $adm = static::getInstance();
        if ($adm === null) {
            $adm = Yii::$app->getModule('adm');
        }
        $widgets = $adm->widgets;
        if (isset($widgets[$class])) {
            $class = $widgets[$class];
        }
        return forward_static_call_array([$class, 'begin'],[$config]);
    }

    /**
     * @param $category
     * @param array $options
     * @return mixed
     */
    public static function getDots($category, $options = [])
    {
        if (empty($category)) {
            $category = 'adm';
        } else {
            $category = 'adm/' . $category;
        }
        return Yii::$app->getI18n()->getOnlyDots($category, $options);
    }

    /**
     * @param $class
     * @return mixed
     */
    public static function end($class)
    {
        $adm = static::getInstance();
        if ($adm === null) {
            $adm = Yii::$app->getModule('adm');
        }
        $widgets = $adm->widgets;
        if (isset($widgets[$class])) {
            $class = $widgets[$class];
        }
        return forward_static_call([$class, 'end']);
    }

    /**
     * @param $category
     * @param $message
     * @param array $params
     * @param null $language
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        if (empty($category)) {
            $category = 'adm';
        } else {
            $category = 'adm/' . $category;
        }
        return Yii::t($category, $message, $params, $language);
    }

    /**
     * @return array
     */
    public function params()
    {
        return [
            'html.bodyOptions' => [],
            'left-menu-active' => [],
            'left-menu' => [
                'settings' => [
                    'label' => '<span class="pull-right auto"><i class="fa fa-angle-down text"></i><i class="fa fa-angle-up text-active"></i></span><i class="fa fa-wrench"></i><span>' . static::t("menu", "Settings") . '</span>',
                    'url' => "#",
                    'items' => [],
                ],
                'elfinder' => [
                    'label' => '<i class="fa fa-picture-o"></i><span>' . static::t("menu", "Media Files") . '</span>',
                    'url' => ['/' . $this->id . '/file/index'],
                    'visible' => $this->user->can('Adm-FilesRoot') || $this->user->can('Adm-FilesAdmin'),
                ],
                'user' => [
                    'label' => '<i class="fa fa-users"></i><span>' . static::t("menu", "Users") . '</span>',
                    'url' => ['/' . $this->id . '/user/index'],
                    'visible' => $this->user->can('AdmRoot'),
                ],
                'authItem' => [
                    'label' => '<span class="pull-right auto"><i class="fa fa-angle-down text"></i><i class="fa fa-angle-up text-active"></i></span><i class="fa fa-lock"></i><span>' . static::t("menu", "Rules") . '</span>',
                    'url' => "#",
                    'visible' => $this->user->can('AdmRoot'),
                    'items' => [
                        [
                            'key' => 'auth-assignment',
                            'label' => '<span>' . static::t("menu", "Auth Assignment") . '</span>',
                            'url' => ['/' . $this->id . '/auth-assignment/index']
                        ],
                        [
                            'key' => 'auth-item',
                            'label' => '<span>' . static::t("menu", "Auth Item") . '</span>',
                            'url' => ['/' . $this->id . '/auth-item/index']
                        ],
                        [
                            'key' => 'auth-item-child',
                            'label' => '' . static::t("menu", "Auth Item Child") . '</span>',
                            'url' => ['/' . $this->id . '/auth-item-child/index']
                        ],
                        [
                            'key' => 'auth-rule',
                            'label' => '<span>' . static::t("menu", "Auth Rule") . '</span>',
                            'url' => ['/' . $this->id . '/auth-rule/index']
                        ]
                    ],
                ],
                'language' => [
                    'label' => '<i class="fa fa-folder"></i><span>' . static::t("menu", "Languages") . '</span>',
                    'url' => ['/' . $this->id . '/language/index'],
                    'visible' => $this->user->can('Adm-Language'),
                ],
                'source-message' => [
                    'label' => '<i class="glyphicon glyphicon-globe"></i><span>' . static::t("menu", "Translations") . '</span>',
                    'url' => ['/' . $this->id . '/source-message/index'],
                    'visible' => $this->user->can('Adm-Transl'),
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function elfinderConfig()
    {
        $config = [
            'class' => 'mihaildev\elfinder\Controller',
            'on beforeAction' => function ($event) {
                Yii::$app->getView()->off('endBody'); //for pavlinter\translation\I18N
            },
            'access' => ['Adm-FilesRoot', 'Adm-FilesAdmin'],
            'disabledCommands' => ['netmount'], // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
        ];

        $startPath = Yii::$app->request->get('startPath');
        if ($startPath) {
            $startPath = Yii::getAlias('@webroot') . '/files' . DIRECTORY_SEPARATOR . str_replace('::', '/', $startPath);
        }

        if ($this->user->can('Adm-FilesRoot')) {
            $config['roots'][] = [
                'baseUrl'=>'@web',
                'basePath'=>'@webroot',
                'path' => 'files',
                'name' => 'Global',
                'options' => [
                    'startPath' => $startPath,
                    'uploadMaxSize' => '1G',
                ],
            ];
        } else if($this->user->can('Adm-FilesAdmin')) {
            $config['roots'][] = [
                'class' => 'mihaildev\elfinder\UserPath',
                'path'  => 'files/adm_users/user_{id}',
                'name'  => 'Files',
                'options' => [
                    'startPath' => $startPath,
                    'uploadMaxSize' => '5M',
                ],
            ];
        }
        return $config;
    }
    /**
     * Marks the beginning of a page.
     * @param \yii\web\View $view the view to be registered with
     */
    public function beginPage($view)
    {
        $view->beginPage();
        $this->trigger(self::EVENT_BEGIN_PAGE);
    }

    /**
     * Marks the ending of a page.
     * @param \yii\web\View $view the view to be registered with
     */
    public function endPage($view)
    {
        $view->endPage();
        $this->trigger(self::EVENT_END_PAGE);
    }

    /**
     * Marks the beginning of an HTML body section.
     * @param \yii\web\View $view the view to be registered with
     */
    public function beginBody($view)
    {
        $view->beginBody();
        $this->trigger(self::EVENT_BEGIN_BODY);
    }

    /**
     * Marks the ending of an HTML body section.
     * @param \yii\web\View $view the view to be registered with
     */
    public function endBody($view)
    {
        $view->endBody();
        $this->trigger(self::EVENT_END_BODY);
    }

    /**
     * @param string|array $url the URL to be redirected to. This can be in one of the following formats:
     * - a string representing a URL (e.g. "http://example.com")
     * - a string representing a URL alias (e.g. "@example.com")
     * - an array in the format of `[$route, ...name-value pairs...]` (e.g. `['site/index', 'ref' => 1]`)
     *   [[Url::to()]] will be used to convert the array into a URL.
     * @param array $options
     * @return \yii\web\Response|\yii\console\Response the response component.
     */
    public static function redirect($url, $options = [])
    {
        $response = Yii::$app->getResponse();
        $options = ArrayHelper::merge([
            'onlyRedirect' => false,
            'post' => 'redirect',
            'statusCode' => 302,
            'params' => [],
            'return' => false,
            'goBack' => false,
        ], $options);
        $redirect = Yii::$app->request->post($options['post']);
        if ($redirect && $options['post'] !== false) {
            $template = [];
            if (is_array($url)) {
                $params = ArrayHelper::merge($url, $options['params']);
                ArrayHelper::remove($params, '0');
            } else {
                $params = $options['params'];
            }
            foreach ($params as $k => $v) {
                $template['{' . $k . '}'] = $v;
                $template['%7B' . $k . '%7D'] = $v;
            }
            $url = strtr($redirect, $template);

            if ($options['return']) {
                return Url::to($url);
            }
            return $response->redirect(Url::to($url), $options['statusCode']);
        }

        if ($options['goBack'] === true) {
            return static::goBack($url, $options);
        }

        if ($options['onlyRedirect'] === false) {
            if ($options['return']) {
                return Url::to($url);
            }
            return $response->redirect(Url::to($url), $options['statusCode']);
        }
        return null;
    }


    /**
     * @param $defaultUrl
     * @param array $options
     * @return static
     */
    public static function goBack($defaultUrl, $options = [])
    {
        $options = ArrayHelper::merge([
            'statusCode' => 302,
        ], $options);

        $response = Yii::$app->getResponse();
        $referrer = Yii::$app->getRequest()->getReferrer();
        if($referrer){
            return $response->redirect($referrer, $options['statusCode']);
        }else{
            return $response->redirect($defaultUrl, $options['statusCode']);
        }
    }
}
