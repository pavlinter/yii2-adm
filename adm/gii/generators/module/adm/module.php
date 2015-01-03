<?php
/**
 * This is the template for generating a module class file.
 */

/* @var $this yii\web\View */
/* @var $generator pavlinter\adm\gii\generators\module\Generator */

$className = $generator->moduleClass;
$pos = strrpos($className, '\\');
$ns = ltrim(substr($className, 0, $pos), '\\');
$className = substr($className, $pos + 1);

echo "<?php\n";
?>

namespace <?= $ns ?>;

use Yii;
use pavlinter\adm\Adm;
use pavlinter\adm\AdmBootstrapInterface;

/**
 * Class Module
 * @package <?= $ns ?>
 */
class <?= $className ?> extends \yii\base\Module implements AdmBootstrapInterface
{
    public $controllerNamespace = '<?= $generator->getControllerNamespace() ?>';

    public $layout = '@vendor/pavlinter/yii2-adm/adm/views/layouts/main';

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, $config = [])
    {
        $this->registerTranslations();
        parent::__construct($id, $parent, $config);
    }

    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }

    /**
     * @param \pavlinter\adm\Adm $adm
     */
    public function loading($adm)
    {

        $adm->params['left-menu']['<?= $generator->moduleID ?>'] = [
            'label' => '<i class="fa fa-hdd-o"></i><span>' . self::t('', '<?= $generator->moduleID ?>') . '</span>',
            'url' => ['/<?= $generator->moduleID ?>']
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        //if ($action->controller->id !== 'default') {
            Yii::$app->getModule('adm'); //required load adm,if use adm layout
            return parent::beforeAction($action) && Adm::getInstance()->user->can('AdmRoot');
        //}
        return parent::beforeAction($action);
    }

    /**
     *
     */
    public function registerTranslations()
    {
        if (!isset(Yii::$app->i18n->translations['<?= $generator->moduleID ?>*'])) {
            Yii::$app->i18n->translations['<?= $generator->moduleID ?>*'] = [
                'class' => 'pavlinter\translation\DbMessageSource',
                'forceTranslation' => true,
                'autoInsert' => true,
                'dotMode' => true,
            ];
        }
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
        if ($category) {
            $category = '<?= $generator->moduleID ?>/' . $category;
        } else {
            $category = '<?= $generator->moduleID ?>';
        }
        return Yii::t($category, $message, $params, $language);
    }
}
