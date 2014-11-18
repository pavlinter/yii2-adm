<?php

/**
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2014
 * @package yii2-adm
 * @version 1.0.0
 */

namespace pavlinter\adm;

use pavlinter\translation\I18N;
use Yii;
use yii\base\BootstrapInterface;
use yii\helpers\ArrayHelper;

/**
 * @property \pavlinter\adm\components\User $user
 * @property \pavlinter\adm\ModelManager $manager
 * @property \yii\rbac\DbManager $authManager
 */
class Adm extends \yii\base\Module
{
    const VERSION = '1.0.0';

    const EVENT_INNER_PROFILE_MENU  = 'innerProfileMenu';

    const EVENT_FOOTER  = 'footer';

    const EVENT_TOP_MENU  = 'topMenu';

    const EVENT_BEFORE_LEFT_MENU  = 'beforeLeftMenu';

    const EVENT_AFTER_LEFT_MENU  = 'afterLeftMenu';

    const EVENT_RIGHT_MENU  = 'rightMenu';

    public $controllerNamespace = 'pavlinter\adm\controllers';

    public $layout = 'main';

    public $tCategory = 'adm';

    public $widgets = [];

    static public $t;

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, $config = [])
    {
        $this->registerTranslations();
        $config = ArrayHelper::merge([
            'aliases' => [
                '@admRoot' => '@vendor/pavlinter/yii2-adm/adm',
                '@admAsset' => '@admRoot/assets',
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
        self::$t = $this->tCategory;
        $this->params = ArrayHelper::merge($this->params(), $this->params);

        if (is_callable($this->controllerMap['elfinder'])) {
            $this->controllerMap['elfinder'] = call_user_func($this->controllerMap['elfinder'], $this->elfinderConfig());
        } else if ($this->controllerMap['elfinder'] === true) {
            $this->controllerMap['elfinder'] = $this->elfinderConfig();
        }

        if (Yii::$app->getUrlManager() instanceof \pavlinter\urlmanager\UrlManager) {
            Yii::$app->getUrlManager()->onlyFriendlyParams = false;
        }

        $this->get('user')->loginUrl = [$this->id.'/default/login'];
        Yii::$app->getI18n()->dialog = I18N::DIALOG_BS;

        $this->widgets = ArrayHelper::merge([
            'FileManager' => '\pavlinter\adm\widgets\FileManager',
            'FileInput' => '\pavlinter\adm\widgets\FileInput',
            'GridView' => '\pavlinter\adm\widgets\GridView',
            'Redactor' => '\pavlinter\adm\widgets\Redactor',
            'ActiveForm' => '\pavlinter\adm\widgets\ActiveForm',
            'Alert' => '\pavlinter\adm\widgets\Alert',
        ],$this->widgets);


        foreach ($this->getModules() as $name => $module) {
            $module = $this->getModule($name);
            if ($module instanceof BootstrapInterface) {
                $module->bootstrap($this);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        return true;
    }

    /**
     *
     */
    public function registerTranslations()
    {
        if (!isset(Yii::$app->i18n->translations[$this->tCategory])) {
            Yii::$app->i18n->translations[$this->tCategory . '*'] = [
                'class' => 'pavlinter\translation\DbMessageSource',
                'forceTranslation' => true,
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
            $category = self::$t;
        } else {
            $category = self::$t . '/' . $category;
        }
        return Yii::t($category, $message, $params, $language);
    }

    /**
     * @param bool $root
     * @return mixed
     */
    public static function getAsset($root = false)
    {
        list($assetRoot, $assetUrl) = Yii::$app->getAssetManager()->publish('@admAsset');
        if ($root) {
            return $assetRoot;
        } else {
            return $assetUrl;
        }
    }

    /**
     * @return array
     */
    public function params()
    {
        return [
            'user.passwordResetTokenExpire' => 3600,
            'left-menu' => [
                /*'dashboard' => [
                    'label' => '<i class="fa fa-desktop"></i><span>' . self::t("menu", "Dashboard", ['dot' => false]) . '</span>',
                    'url' => ['/' . $this->id . '/default/index']
                ],*/
                'elfinder' => [
                    'label' => '<i class="fa fa-picture-o"></i><span>' . self::t("menu", "Media Files", ['dot' => false]) . '</span>',
                    'url' => ['/' . $this->id . '/file/index'],
                    'visible' => $this->user->can('Adm-FilesRoot') || $this->user->can('Adm-FilesAdmin'),
                ],
                'user' => [
                    'label' => '<i class="fa fa-picture-o"></i><span>' . self::t("menu", "Users", ['dot' => false]) . '</span>',
                    'url' => ['/' . $this->id . '/user/index'],
                    'visible' => $this->user->can('AdmRoot'),
                ],
                'authItem' => [
                    'label' => '<span class="pull-right auto"><i class="fa fa-angle-down text"></i><i class="fa fa-angle-up text-active"></i></span><i class="fa fa-lock"></i><span>' . Yii::t("adm/menu", "Rules", ['dot' => false]) . '</span>',
                    'url' => "#",
                    'visible' => $this->user->can('AdmRoot'),
                    'items' => [
                        [
                            'label' => '<i class="fa fa-sign-in"></i><span>' . self::t("menu", "Auth Assignment", ['dot' => false]) . '</span>',
                            'url' => ['/' . $this->id . '/auth-assignment/index']
                        ],
                        [
                            'label' => '<i class="fa fa-sitemap"></i><span>' . self::t("menu", "Auth Item", ['dot' => false]) . '</span>',
                            'url' => ['/' . $this->id . '/auth-item/index']
                        ],
                        [
                            'label' => '<i class="fa fa-link"></i><span>' . self::t("menu", "Auth Item Child", ['dot' => false]) . '</span>',
                            'url' => ['/' . $this->id . '/auth-item-child/index']
                        ],
                        [
                            'label' => '<i class="fa fa-unlock"></i><span>' . self::t("menu", "Auth Rule", ['dot' => false]) . '</span>',
                            'url' => ['/' . $this->id . '/auth-rule/index']
                        ]
                    ],
                ],
                'language' => [
                    'label' => '<i class="fa fa-folder"></i><span>' . self::t("menu", "Languages", ['dot' => false]) . '</span>',
                    'url' => ['/' . $this->id . '/language/index'],
                    'visible' => $this->user->can('Adm-Language'),
                ],
                'source-message' => [
                    'label' => '<i class="fa fa-file-text-o"></i><span>' . self::t("menu", "Translations", ['dot' => false]) . '</span>',
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

        if ($this->user->can('Adm-FilesRoot')) {
            $config['roots'][] = [
                'baseUrl'=>'@web',
                'basePath'=>'@webroot',
                'path' => 'files',
                'name' => 'Global',
                'options' => [
                    'uploadMaxSize' => '1G',
                ],
            ];
        }

        if ($this->user->can('Adm-FilesRoot')) {
            $config['roots'][] = [
                'class' => 'mihaildev\elfinder\UserPath',
                'path'  => 'files/user_{id}',
                'name'  => 'Files'
            ];
        }
        return $config;
    }

}
