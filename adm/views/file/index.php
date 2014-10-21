<?php

use pavlinter\adm\Adm;

/**
 * @var yii\web\View $this
 */
?>

<div class="elfinder-default-index">
    <h1><?= Adm::t('file','Media Files'); ?></h1>
    <?= Adm::widget('FileManager');?>
</div>
