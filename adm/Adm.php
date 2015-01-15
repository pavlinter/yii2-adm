<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.0
 */

namespace pavlinter\adm;

use pavlinter\translation\I18N;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * @property \pavlinter\adm\components\User $user
 * @property \pavlinter\adm\ModelManager $manager
 * @property \yii\rbac\DbManager $authManager
 */
class Adm extends \yii\base\Module
{
    const VERSION = '1.0.0';
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
                'user' => Yii::$app->user,
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
        $adm = Yii::$app->getModule('adm');
        $view = Yii::$app->getView();
        //override default error handler
        $handler = new \yii\web\ErrorHandler(['errorAction' => $adm->id . '/default/error']);
        Yii::$app->set('errorHandler', $handler);
        $handler->register();

        if (Yii::$app->getUrlManager() instanceof \pavlinter\urlmanager\UrlManager) {
            Yii::$app->getUrlManager()->onlyFriendlyParams = false;
        }
        Yii::$app->getI18n()->dialog = I18N::DIALOG_BS;
        ConflictAsset::register($view);
        return $adm;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        self::register();
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
        $adm = self::getInstance();
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
        $adm = self::getInstance();
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
        $adm = self::getInstance();
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
            'user.passwordResetTokenExpire' => 3600,
            'left-menu' => [
                'elfinder' => [
                    'label' => '<i class="fa fa-picture-o"></i><span>' . self::t("menu", "Media Files") . '</span>',
                    'url' => ['/' . $this->id . '/file/index'],
                    'visible' => $this->user->can('Adm-FilesRoot') || $this->user->can('Adm-FilesAdmin'),
                ],
                'user' => [
                    'label' => '<i class="fa fa-users"></i><span>' . self::t("menu", "Users") . '</span>',
                    'url' => ['/' . $this->id . '/user/index'],
                    'visible' => $this->user->can('AdmRoot'),
                ],
                'authItem' => [
                    'label' => '<span class="pull-right auto"><i class="fa fa-angle-down text"></i><i class="fa fa-angle-up text-active"></i></span><i class="fa fa-lock"></i><span>' . self::t("menu", "Rules") . '</span>',
                    'url' => "#",
                    'visible' => $this->user->can('AdmRoot'),
                    'items' => [
                        [
                            'label' => '<span>' . self::t("menu", "Auth Assignment") . '</span>',
                            'url' => ['/' . $this->id . '/auth-assignment/index']
                        ],
                        [
                            'label' => '<span>' . self::t("menu", "Auth Item") . '</span>',
                            'url' => ['/' . $this->id . '/auth-item/index']
                        ],
                        [
                            'label' => '' . self::t("menu", "Auth Item Child") . '</span>',
                            'url' => ['/' . $this->id . '/auth-item-child/index']
                        ],
                        [
                            'label' => '<span>' . self::t("menu", "Auth Rule") . '</span>',
                            'url' => ['/' . $this->id . '/auth-rule/index']
                        ]
                    ],
                ],
                'language' => [
                    'label' => '<i class="fa fa-folder"></i><span>' . self::t("menu", "Languages") . '</span>',
                    'url' => ['/' . $this->id . '/language/index'],
                    'visible' => $this->user->can('Adm-Language'),
                ],
                'source-message' => [
                    'label' => '<i class="fa fa-file-text-o"></i><span>' . self::t("menu", "Translations") . '</span>',
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
            'access' => ['Adm-FilesRoot', 'Adm-FilesAdmin'],
            'disabledCommands' => ['netmount'], // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
        ];

        $startPath = Yii::$app->request->get('startPath');
        if ($startPath) {
            $startPath = Yii::getAlias('@webroot') . '/files' . DIRECTORY_SEPARATOR . strtr($startPath, '::', '/');
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
        } else if($this->user->can('AdmAdmin')) {
            $config['roots'][] = [
                'class' => 'mihaildev\elfinder\UserPath',
                'path'  => 'files/adm_users/user_{id}',
                'name'  => 'Files',
                'options' => [
                    'startPath' => $startPath,
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
}
