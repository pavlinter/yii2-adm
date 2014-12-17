<?php
/**
 * This is the template for generating a controller class within a module.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */

$className = $generator->moduleClass;
$pos = strrpos($className, '\\');
$ns = ltrim(substr($className, 0, $pos), '\\');

echo "<?php\n";
?>

namespace <?= $ns ?>;

use pavlinter\adm\Manager;

/**
 * @method \<?= $ns ?>\models\Page createPage
 * @method \<?= $ns ?>\models\Page createPageQuery
 */
class ModelManager extends Manager
{
    /**
     * @var string|\<?= $ns ?>\models\Page
     */
    public $pageClass = '<?= $ns ?>\models\Page';
}