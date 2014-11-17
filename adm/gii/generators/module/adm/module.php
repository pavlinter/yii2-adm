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

use pavlinter\adm\Adm;
use Yii;
use yii\base\BootstrapInterface;

class <?= $className ?> extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = '<?= $generator->getControllerNamespace() ?>';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    /**
     * @inheritdoc
     */
    public function bootstrap($adm)
    {
        /* @var $adm \pavlinter\adm\Adm */
        $adm->params['left-menu']['admpage'] = [
            'label' => '<i class="fa fa-hdd-o"></i><span>' . $adm::t('<?= $generator->moduleID ?>','<?= $generator->moduleID ?>') . '</span>',
            'url' => ['/' . $adm->id . '/<?= $generator->moduleID ?>']
        ];
    }
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action) || !Adm::getInstance()->user->can('AdmRoot')) {
            return false;
        }
        return true;
    }
}
