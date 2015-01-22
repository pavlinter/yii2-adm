<?php
use pavlinter\adm\Adm;
use pavlinter\adm\AdmAsset;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AdmAsset::register($this);
$adm = Adm::getInstance();
?>
<?php $adm->beginPage($this) ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script type="text/javascript">
        var admController = '<?= $this->context->id ?>';
    </script>
    <?php $this->head() ?>
</head>
<body>
    <?php $adm->beginBody($this) ?>
    <?= $content ?>
    <?php $adm->endBody($this) ?>
</body>
</html>
<?php $adm->endPage($this) ?>
