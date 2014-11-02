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
                'elfinder' => [
                    'class' => 'mihaildev\elfinder\Controller',
                    'access' => ['@', '?'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
                    'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
                    'roots' => [
                        [
                            'baseUrl'=>'@web',
                            'basePath'=>'@webroot',
                            'path' => 'files',
                            'name' => 'Global',
                            'options' => [
                                'uploadMaxSize' => '1G',
                            ],
                        ],
                        [
                            'class' => 'mihaildev\elfinder\UserPath',
                            'path'  => 'files/user_{id}',
                            'name'  => 'My Documents'
                        ],
                    ]
                ],
            ],
            'components' => [
                'manager' => [
                    'class' => 'pavlinter\adm\ModelManager'
                ],
                'user' => Yii::$app->user,
            ],
            'params' => [
                'user.passwordResetTokenExpire' => 3600,
                'left-menu' => [
                    'dashboard' => [
                        'label' => '<i class="fa fa-desktop"></i><span>' . self::t("menu", "Dashboard", ['dot' => false]) . '</span>',
                        'url' => ['/' . $id . '/default/index']
                    ],
                    'elfinder' => [
                        'label' => '<i class="fa fa-picture-o"></i><span>' . self::t("menu", "Media Files", ['dot' => false]) . '</span>',
                        'url' => ['/' . $id . '/file/index']
                    ],
                    'user' => [
                        'label' => '<i class="fa fa-picture-o"></i><span>' . self::t("menu", "Users", ['dot' => false]) . '</span>',
                        'url' => ['/' . $id . '/user/index']
                    ],
                    'authItem' => [
                        'label' => '<span class="pull-right auto"><i class="fa fa-angle-down text"></i><i class="fa fa-angle-up text-active"></i></span><i class="fa fa-lock"></i><span>' . Yii::t("adm/menu", "Rules", ['dot' => false]) . '</span>',
                        'url' => "#",
                        'items' => [
                            [
                                'label' => '<i class="fa fa-sign-in"></i><span>' . self::t("menu", "Auth Assignment", ['dot' => false]) . '</span>',
                                'url' => ['/' . $id . '/auth-assignment/index']
                            ],
                            [
                                'label' => '<i class="fa fa-sitemap"></i><span>' . self::t("menu", "Auth Item", ['dot' => false]) . '</span>',
                                'url' => ['/' . $id . '/auth-item/index']
                            ],
                            [
                                'label' => '<i class="fa fa-link"></i><span>' . self::t("menu", "Auth Item Child", ['dot' => false]) . '</span>',
                                'url' => ['/' . $id . '/auth-item-child/index']
                            ],
                            [
                                'label' => '<i class="fa fa-unlock"></i><span>' . self::t("menu", "Auth Rule", ['dot' => false]) . '</span>',
                                'url' => ['/' . $id . '/auth-rule/index']
                            ]

                        ],
                    ],
                    'language' => [
                        'label' => '<i class="fa fa-folder"></i><span>' . self::t("menu", "Languages", ['dot' => false]) . '</span>',
                        'url' => ['/' . $id . '/language/index']
                    ],
                    'source-message' => [
                        'label' => '<i class="fa fa-file-text-o"></i><span>' . self::t("menu", "Translations", ['dot' => false]) . '</span>',
                        'url' => ['/' . $id . '/source-message/index']
                    ],
                ],
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
        $this->get('user')->loginUrl = [$this->id.'/default/login'];
        Yii::$app->getI18n()->dialog = I18N::DIALOG_BS;

        $this->widgets = ArrayHelper::merge([
            'FileManager' => '\pavlinter\adm\widgets\FileManager',
            'FileInput' => '\pavlinter\adm\widgets\FileInput',
            'GridView' => '\pavlinter\adm\widgets\GridView',
            'Redactor' => '\pavlinter\adm\widgets\Redactor',
        ],$this->widgets);

        self::$t = $this->tCategory;
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
    public function registerTranslations()
    {
        if (!isset(Yii::$app->i18n->translations[$this->tCategory])) {
            Yii::$app->i18n->translations[$this->tCategory . '*'] = [
                'class' => 'pavlinter\translation\DbMessageSource',
                'forceTranslation' => true,
            ];
        }
    }
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

    public static function t($category, $message, $params = [], $language = null)
    {
        if ($category !== '') {
            $category = self::$t . '/' . $category;
        } else {
            $category = self::$t;
        }
        return Yii::t($category, $message, $params, $language);
    }
    public static function getAsset($root = false)
    {
        list($assetRoot, $assetUrl) = Yii::$app->getAssetManager()->publish('@admAsset');
        if ($root) {
            return $assetRoot;
        } else {
            return $assetUrl;
        }
    }
}
