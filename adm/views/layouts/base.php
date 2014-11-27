<?php

use pavlinter\adm\AdmAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AdmAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script type="text/javascript">
        var admId = '<?= \pavlinter\adm\Adm::getInstance()->id; ?>';
        var admController = '<?= $this->context->id ?>';
    </script>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <?= $content ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
